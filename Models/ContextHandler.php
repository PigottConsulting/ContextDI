<?php namespace TechData\ContextDiBundle\Models;

use TechData\ContextDiBundle\Interfaces\ContextProviderInterface;
use TechData\ContextDiBundle\Interfaces\ContextInterface;
use TechData\ContextDiBundle\Interfaces\ContextCacheInterface;
use TechData\ContextDiBundle\Exceptions\ContextNotProvidedException;
use TechData\ContextDiBundle\Exceptions\ContextException;
use Psr\Log\LoggerInterface;
use ReflectionException;
use ReflectionClass;

/**
 * Description of ContextHandler
 *
 * @author wpigott
 */
class ContextHandler
{

    /**
     *
     * @var ContextCacheInterface 
     */
    private $contextCache;

    /**
     *
     * @var LoggerInterface
     */
    private $logger;
    private $availableContexts = array();
    private $providers = array();

    function __construct(ContextCacheInterface $contextCache, LoggerInterface $logger, array $availableContexts)
    {
        $this->contextCache = $contextCache;
        $this->logger = $logger;
        $this->availableContexts = $availableContexts;
    }

    public function addProvider(ContextProviderInterface $provider, $contextName)
    {
        // Get an SPL hash so we make sure we don't have the same provider multiple times.
        $spl = spl_object_hash($provider);

        // Add the provider to the array.
        $this->providers[$contextName][$spl] = $provider;
    }

    public function getContext($name)
    {
        $this->logger->debug('Attempting to get context for "' . $name . '".', array('ContextHandler', 'getContext'));

        // Make sure it is a registered context.
        if(!array_key_exists($name, $this->availableContexts)) {
            $this->logger->debug('Context "' . $name . '" is not a registered available context.', array('ContextHandler', 'getContext'));
            throw new ContextException('Context "' . $name . '" is not a registered available context.');
        }
        
        // Check if we have it in cache
        if (!$this->contextCache->hasContext($name)) {

            // Resolve it and add it to the cache.
            $this->contextCache->setContext($this->resolveContext($name));
        }

        // Try to return the context.
        return $this->contextCache->getContext($name);
    }

    private function resolveContext($name)
    {
        // Make sure we have at least one provider for the name.
        if (!isset($this->providers[$name])) {
            throw new ContextNotProvidedException('No providers for context "' . $name . '".');
        }

        // Try to resolve it.
        foreach ($this->providers[$name] as $provider) {
            try {
                $context = $this->returnValidContextFromProvider($provider);
                $this->validateContextObjectType($name, $context);
                return $context;
            } catch (ContextNotProvidedException $e) {
                // Log it and move on.
                $this->logger->debug($e->getMessage(), array('ContextHandler', 'resolveContext'));
            }
        }

        // Not able to find context
        $this->logger->debug('Unable to resolve context for "' . $name . '".', array('ContextHandler', 'resolveContext'));
        throw new ContextNotProvidedException('No providers for context "' . $name . '".');
    }

    private function returnValidContextFromProvider(ContextProviderInterface $provider)
    {
        $context = $provider->getContext();
        if ($context instanceof ContextInterface) {
            return $context;
        }
        throw new ContextNotProvidedException('Unable to determine context from "' . get_class($provider) . '".');
    }
    
    private function validateContextObjectType($contextName, ContextInterface $context) 
    {
        // Check that the context name matches the name being requested.
        if($contextName != $context->getContextName()) {
            $e = new ContextNotProvidedException('Context name does not match.');
            $this->logger->debug($e->getMessage(), array('ContextHandler', 'validateContextObjectType'));
            throw $e;
        }
        
        
        // Check that the object in the context is the correct type.
        try {
            $objectReflection = new ReflectionClass($context->getEntity());
            $interfaceReflection = new ReflectionClass($this->availableContexts[$contextName]);
            if(($interfaceReflection->isInterface() && ($objectReflection->implementsInterface($this->availableContexts[$contextName]))) 
                    || ($objectReflection->isSubclassOf($this->availableContexts[$contextName]))
                    || ($objectReflection->getName() == $this->availableContexts[$contextName])) {
                return TRUE;                
            }
        } catch (ReflectionException $e) {
            $e = new ContextNotProvidedException($e->getMessage(), NULL, $e);
            $this->logger->debug($e->getMessage(), array('ContextHandler', 'validateContextObjectType'));
            throw $e;
        }
        
        // Incorrect context type returned
        $e = new ContextNotProvidedException('Provider returned incorrect type: "' . get_class($context->getEntity()) . '".  Expecting: "'. $this->availableContexts[$contextName].'".');
        $this->logger->debug($e->getMessage(), array('ContextHandler', 'validateContextObjectType'));
        throw $e;
    }
}

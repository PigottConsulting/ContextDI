<?php namespace TechData\ContextDiBundle\Models\Cache;

use TechData\ContextDiBundle\Interfaces\ContextCacheInterface;
use TechData\ContextDiBundle\Exceptions\ContextCacheException;
use TechData\ContextDiBundle\Interfaces\ContextInterface;

/**
 * Caches for the single request so context is not repeatedly resolved.
 *
 * @author wpigott
 */
class SingleRequestCache implements ContextCacheInterface
{

    private $values = array();

    public function getContext($name)
    {
        if (!$this->hasContext($name)) {
            throw new ContextCacheException('Value for "' . $name . '" does not exist in cache.');
        }
        return $this->values[$name];
    }

    public function hasContext($name)
    {
        return array_key_exists($name, $this->values);
    }

    public function setContext(ContextInterface $context)
    {
        $this->values[$context->getContextName()] = $context;
    }

    public function clearCache()
    {
        $this->values = array();
    }

    public function clearSingle($name)
    {
        unset($this->values[$name]);
    }
}

<?php namespace TechData\ContextDiBundle\Interfaces;

use TechData\ContextDiBundle\Exceptions\ContextCacheException;
use TechData\ContextDiBundle\Interfaces\ContextInterface;

/**
 *
 * @author wpigott
 */
interface ContextCacheInterface
{

    /**
     * 
     * @param ContextInterface $context
     * @throws ContextCacheException If unable to set the value.
     */
    public function setContext(ContextInterface $context);

    /**
     * 
     * @param string $name
     * @return ContextInterface
     * @throws ContextCacheException If unable to find or retrieve value with specified name.
     */
    public function getContext($name);
    
    /**
     * 
     * @param string $name
     * @return boolean Depending on if the value exists in the cache or not.
     */
    public function hasContext($name);

    /**
     * @throws ContextCacheException When there is an error clearing the cache.
     */
    public function clearCache();

    /**
     * 
     * @param string $name
     * @throws ContextCacheException When unable to clear a value.
     */
    public function clearSingle($name);
}

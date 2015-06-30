<?php namespace TechData\ContextDiBundle\Interfaces;

/**
 *
 * @author wpigott
 */
interface ContextInterface
{

    public function __construct($contextName, $entity);
    
    public function getContextName();

    /**
     * @return Object
     */
    public function getEntity();
    
}

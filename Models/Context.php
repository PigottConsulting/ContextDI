<?php namespace TechData\ContextDiBundle\Models;

use TechData\ContextDiBundle\Interfaces\ContextInterface;

/**
 * Description of Context
 *
 * @author wpigott
 */
class Context implements ContextInterface
{

    private $contextName;
    private $entity;
    
    public function __construct($contextName, $entity) 
    {
        $this->contextName = $contextName;
        $this->entity = $entity;
    }
    
    public function getContextName()
    {
        return $this->contextName;
    }

    public function getEntity()
    {
        return $this->entity;
    }

}

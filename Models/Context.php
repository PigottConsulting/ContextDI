<?php namespace TechData\ContextDiBundle\Models;

use TechData\ContextDiBundle\Interfaces\ContextInterface;
use TechData\ContextDiBundle\Interfaces\EditableContextInterface;

/**
 * Description of Context
 *
 * @author wpigott
 */
class Context implements ContextInterface, EditableContextInterface
{

    private $contextName;
    private $entityType;
    private $entity;
    private $id;

    function getContextName()
    {
        return $this->contextName;
    }

    function getEntityType()
    {
        return $this->entityType;
    }

    function getEntity()
    {
        return $this->entity;
    }

    function getId()
    {
        return $this->id;
    }

    function setContextName($contextName)
    {
        $this->contextName = $contextName;
    }

    function setEntityType($entityType)
    {
        $this->entityType = $entityType;
    }

    function setEntity($entity)
    {
        $this->entity = $entity;
    }

    function setId($id)
    {
        $this->id = $id;
    }
}

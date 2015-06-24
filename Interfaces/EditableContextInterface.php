<?php namespace TechData\ContextDiBundle\Interfaces;

/**
 *
 * @author wpigott
 */
interface EditableContextInterface
{

    public function setContextName($contextName);

    public function setId($id);

    public function setEntity($entity);

    public function setEntityType($entityType);
}

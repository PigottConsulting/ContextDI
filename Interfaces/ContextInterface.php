<?php namespace TechData\ContextDiBundle\Interfaces;

/**
 *
 * @author wpigott
 */
interface ContextInterface
{

    public function getContextName();

    public function getId();

    /**
     * @return Object
     */
    public function getEntity();

    /**
     * @return string
     */
    public function getEntityType();
}

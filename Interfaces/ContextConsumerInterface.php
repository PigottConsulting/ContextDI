<?php namespace TechData\ContextDiBundle\Interfaces;

use TechData\ContextDiBundle\Interfaces\ContextInterface;

/**
 *
 * @author wpigott
 */
interface ContextConsumerInterface
{

    public function addContext(ContextInterface $context);
}

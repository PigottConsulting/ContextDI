<?php namespace TechData\ContextDiBundle\Interfaces;

use TechData\ContextDiBundle\Interfaces\ContextInterface;
use TechData\ContextDiBundle\Exceptions\ContextNotProvidedException;

/**
 *
 * @author wpigott
 */
interface ContextProviderInterface
{

    /**
     * @return ContextInterface
     * @throws ContextNotProvidedException When the context is not able to be determined/resolved/provided.
     */
    public function getContext();

}

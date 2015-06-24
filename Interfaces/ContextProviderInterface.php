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

    /**
     * @return string A valid class/interface which the context extends/implements.
     * This is used by the context handler to validate the context is a valid type.
     * Example: The UserContextProvider would return "Some\Name\Space\UserInterface"
     */
    public function getContextType();
}

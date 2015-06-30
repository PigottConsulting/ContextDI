<?php namespace TechData\ContextDiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use RuntimeException;
use ReflectionClass;

/**
 * Description of Validators
 *
 * @author wpigott
 */
class Validators
{

    public static function validateInterfaceImplemented(ContainerBuilder $container, $serviceId, $interfaceName)
    {
        $class = $container->findDefinition($serviceId)->getClass();
        $reflection = new ReflectionClass($class);
        if (!$reflection->implementsInterface($interfaceName)) {
            throw new RuntimeException('Class must implement "' . $interfaceName . '".');
        }
    }

    public static function validateArrayKeyExists($key, array $array)
    {
        if (!array_key_exists($key, $array)) {
            throw new RuntimeException('Array must have key "' . $key . '".');
        }
    }
}

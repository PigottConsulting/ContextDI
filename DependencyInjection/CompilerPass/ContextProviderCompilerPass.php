<?php namespace TechData\ContextDiBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use TechData\ContextDiBundle\DependencyInjection\Validators;

class ContextProviderCompilerPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        // Get the reference for the handler service
        $handlerReference = new Reference('tech_data_context_di.context_handler');

        // Loop through all the context_provider tags and add the services to the context handler service
        $taggedServices = $container->findTaggedServiceIds('context_provider');
        foreach ($taggedServices as $id => $serviceTags) {
            Validators::validateInterfaceImplemented($container, $id, 'TechData\ContextDiBundle\Interfaces\ContextProviderInterface');
            foreach ($serviceTags as $tag) {
                Validators::validateArrayKeyExists('context_name', $tag);
                $handlerReference->addMethodCall(
                    'addProvider', array(new Reference($id), $tag['context_name'])
                );
            }
        }
    }
}

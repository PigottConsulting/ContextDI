<?php

namespace TechData\ContextDiBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use TechData\ContextDiBundle\DependencyInjection\Validators;

class ContextConsumerCompilerPass implements CompilerPassInterface {

    private $serviceDefinistions = array();

    public function process(ContainerBuilder $container) {
        
        // Loop through all the context_consumer tags and add the contexts via injection
        $taggedServices = $container->findTaggedServiceIds('context_consumer');
        foreach ($taggedServices as $id => $serviceTags) {
            Validators::validateInterfaceImplemented($container, $id, 'TechData\ContextDiBundle\Interfaces\ContextConsumerInterface');
            $service = $container->getDefinition($id);
            foreach ($serviceTags as $tag) {
                Validators::validateArrayKeyExists('context_name', $tag);
                $service->addMethodCall(
                        'addContext', array($this->getServiceFactory($container, $tag['context_name']))
                );
            }
        }
    }

    /**
     * return from local cache or make a new one and put it in cache and then return it.
     * @param ContainerBuilder $container
     * @param string $contextName
     * @returns Reference The service definition reference
     */
    private function getServiceFactory(ContainerBuilder $container, $contextName) {
        if (!array_key_exists($contextName, $this->serviceDefinistions)) {
            $def = new Definition();
            $def->setClass();
            $def->setLazy(TRUE);
            $def->setFactoryService('tech_data_context_di.context_handler');
            $def->setFactoryMethod('getContext');
            $def->setArguments(array($contextName));
            $id = 'tech_data_context_di.contexts.' . $contextName;
            $container->setDefinition($id, $def);
            $this->serviceDefinistions[$contextName] = new Reference($id);
        }
        return $this->serviceDefinistions[$contextName];
    }
}

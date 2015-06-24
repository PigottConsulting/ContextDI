<?php namespace TechData\ContextDiBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use TechData\ContextDiBundle\DependencyInjection\Validators;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TechDataContextDiExtension extends Extension
{

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Get the available contexts from the config
        $availableContexts = array();
        if (isset($config['available_contexts']) && is_array($config['available_contexts'])) {
            $availableContexts = $config['available_contexts'];
        }

        // Add the possible contexts to the container for later use
        $container->setParameter('tech_data_context_di.context_handler.available_contexts', $availableContexts);

        // Add an alias to the configured cache
        if (!$container->hasDefinition($config['cache_service'])) {
            throw new \RuntimeException('Unable to locate service with name "' . $config['cache_service'] . '".');
        }

        // Make sure the class implements the interface
        Validators::validateInterfaceImplemented($container, $config['cache_service'], 'TechData\ContextDiBundle\Interfaces\ContextCacheInterface');

        $container->setAlias('tech_data_context_di.cache', $config['cache_service']);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }

    public function getAlias()
    {
        return 'context_di';
    }
}

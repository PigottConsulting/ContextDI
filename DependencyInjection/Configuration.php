<?php namespace TechData\ContextDiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('tech_data_context_di');

        $rootNode
            ->children()
                ->arrayNode('available_contexts')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('cache_service')
                    ->defaultValue('tech_data_context_di.cache.single_request')
                ->end()
            ->end();

        return $treeBuilder;
    }
}

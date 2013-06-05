<?php

namespace MDB\AssetBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('mdb_asset', 'array');

        $rootNode
            ->children()
                ->arrayNode('asset')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('form')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('mdb_asset_asset')->end()
                                ->scalarNode('name')->defaultValue('mdb_asset_asset')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('class')->isRequired()
                    ->children()
                        ->arrayNode('model')->isRequired()
                            ->children()
                                ->scalarNode('location')->isRequired()->end()
                                ->scalarNode('vendor')->isRequired()->end()
                                ->scalarNode('asset')->isRequired()->end()
                                ->scalarNode('parent_log')->isRequired()->end()
                                ->scalarNode('properties_log')->isRequired()->end()
                                ->scalarNode('assign_log')->isRequired()->end()
                                ->scalarNode('status_log')->isRequired()->end()
                                ->scalarNode('document_log')->isRequired()->end()
                                ->scalarNode('delete_log')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('service')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('manager')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('asset')->cannotBeEmpty()->defaultValue('mdb_asset.manager.asset.default')->end()
                                ->scalarNode('vendor')->cannotBeEmpty()->defaultValue('mdb_asset.manager.vendor.default')->end()
                                ->scalarNode('location')->cannotBeEmpty()->defaultValue('mdb_asset.manager.location.default')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}

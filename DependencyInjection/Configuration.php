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
                ->arrayNode('status')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('form')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('mdb_asset_status')->end()
                                ->scalarNode('name')->defaultValue('mdb_asset_status')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();


        return $treeBuilder;
    }

}   

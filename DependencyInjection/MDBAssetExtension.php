<?php

namespace MDB\AssetBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MDBAssetExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $bundles = $container->getParameter('kernel.bundles');

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('search.yml');
        $loader->load('listeners.yml');
        $loader->load('validators.yml');

        $container->setParameter('mdb_asset.form.asset.type', $config['asset']['form']['type']);
        $container->setParameter('mdb_asset.form.asset.name', $config['asset']['form']['name']);

        $container->setParameter('mdb_asset.model.asset.class', $config['class']['model']['asset']);
        $container->setParameter('mdb_asset.model.parent_log.class', $config['class']['model']['parent_log']);
        $container->setParameter('mdb_asset.model.properties_log.class', $config['class']['model']['properties_log']);
        $container->setParameter('mdb_asset.model.assign_log.class', $config['class']['model']['assign_log']);
        $container->setParameter('mdb_asset.model.status_log.class', $config['class']['model']['status_log']);
        $container->setParameter('mdb_asset.model.document_log.class', $config['class']['model']['document_log']);
        $container->setParameter('mdb_asset.model.delete_log.class', $config['class']['model']['delete_log']);

        // $container->setParameter('mdb_asset.search.asset_provider.class', $config['class']['search_provider']['asset']);

        $container->setAlias('mdb_asset.manager.asset', $config['service']['manager']['asset']);
    }
}

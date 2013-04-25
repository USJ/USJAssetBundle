<?php
namespace MDB\AssetBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AssetCloneCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mdb:asset:clone')
            ->setDescription('Clone asset')
            ->addArgument(
                'asset_id',
                InputArgument::REQUIRED,
                'Asset node id'
            )
            ->addOption(
               'children',
               null,
               InputOption::VALUE_NONE,
               'If set, all of the children will also be copied'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $assetClass = $this->getContainer()->getParameter('mdb_asset.model.asset.class');
        $assetManager = $this->get('mdb_asset.manager.asset');

        $asset = $assetManager
            ->getRepository()
            ->createQueryBuilder($assetClass)
            ->field('_id')->equals($input->getArgument('asset_id'))
            ->getQuery()
            ->getSingleResult();

        if(!$asset) {
            throw new \RuntimeException(sprintf('Asset with <comment>%s</comment> was not found', $input->getArgument('asset_id')));
        }

        $output->writeln(sprintf('found asset <comment>%s</comment>', $input->getArgument('asset_id')));
        $output->writeln('cloning asset...');

        $assetManager->cloneAssetHierachy($asset);
    }

    protected function get($serviceName)
    {
        return $this->getContainer()->get($serviceName);
    }
}

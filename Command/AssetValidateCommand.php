<?php
namespace MDB\AssetBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AssetValidateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mdb:asset:validate')
            ->setDescription('Validate all of the assets');
            // ->addArgument(
            //     'asset_id',
            //     InputArgument::REQUIRED,
            //     'Asset node id'
            // )
            // ->addOption(
            //    'children',
            //    null,
            //    InputOption::VALUE_NONE,
            //    'If set, all of the children will also be copied'
            // );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $assetClass = $this->getContainer()->getParameter('mdb_asset.model.asset.class');
        $assetManager = $this->get('mdb_asset.manager.asset');
        // $organizations = $this->get('cloudruge_user.manager.organization')->findAllOrganizations();


    }

    protected function get($serviceName)
    {
        return $this->getContainer()->get($serviceName);
    }
}

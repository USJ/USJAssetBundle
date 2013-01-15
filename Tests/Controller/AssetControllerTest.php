<?php

namespace MDB\AssetBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use MDB\AssetBundle\Controller\AssetController;

class AssetControllerTest extends WebTestCase
{
    // function will return a response object, could use getContent() function as assertation
    public function testGetAction()
    {
        $aController = new AssetController();
        $aController->setContainer($this->getMockContainer());
    }

    private function getMockContainer()
    { 
        // mock of container
        // return get('something') method
        //  the status mana
        // $mContainer = ;
    }

    private function getMockStatusManager()
    {

    }
}
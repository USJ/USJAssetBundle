<?php

namespace MDB\AssetBundle\Tests\Document;

/**
 *
 */
abstract class BaseAssetTreeTest extends \PHPUnit_Framework_TestCase
{
    protected $dm;
    protected $dispatcher;
    protected $assets;

    public function setUp()
    {
        $assets = array();
        // build tree lvl 3
        $lvl1asset = new MockAsset();
        $lvl1asset->setLevel(1);
        $assets[] = $lvl1asset;
        $lvl21asset = new MockAsset();
        $lvl21asset->setParent($lvl1asset);
        $lvl21asset->setLevel(2);
        $lvl22asset = new MockAsset();
        $lvl22asset->setParent($lvl1asset);
        $lvl22asset->setLevel(2);
        $lvl23asset = new MockAsset();
        $lvl23asset->setParent($lvl1asset);
        $lvl23asset->setLevel(2);
        $assets[] = $lvl21asset;
        $assets[] = $lvl22asset;
        $assets[] = $lvl23asset;

        $lvl31asset = new MockAsset();
        $lvl31asset->setParent($lvl21asset);
        $lvl31asset->setLevel(3);
        $lvl32asset = new MockAsset();
        $lvl32asset->setParent($lvl21asset);
        $lvl32asset->setLevel(3);
        $lvl33asset = new MockAsset();
        $lvl33asset->setParent($lvl22asset);
        $lvl33asset->setLevel(3);
        $lvl34asset = new MockAsset();
        $lvl34asset->setParent($lvl22asset);
        $lvl34asset->setLevel(3);
        $assets[] = $lvl31asset;
        $assets[] = $lvl32asset;
        $assets[] = $lvl33asset;
        $assets[] = $lvl34asset;

        $this->assets = $assets;
        $assetsCollection = new \Doctrine\Common\Collections\ArrayCollection($assets);

        $this->dm = $this->getMockDocumentManager();
        $this->dispatcher = $this->getMockDispatcher();
        $repository = $this->getMockRepository();

        $repository->expects($this->any())
            ->method('getChildren')
            ->will($this->returnValue($assetsCollection));

        $this->dm->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($repository));
    }

    public function getMockDocumentManager()
    {
        $dm = $this->getMockBuilder('Doctrine\ODM\MongoDB\DocumentManager')
            ->disableOriginalConstructor()
            ->setMethods(array('getRepository'))
            ->getMock();
        return $dm;
    }

    public function getMockRepository()
    {
        $repository = $this->getMockBuilder('Doctrine\ODM\MongoDB\DocumentRepository')
            ->disableOriginalConstructor()
            ->setMethods(array('getChildren'))
            ->getMock();
        return $repository;
    }

    public function getMockDispatcher()
    {
        $dispatcher = $this->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcher')
            ->disableOriginalConstructor()
            ->getMock();
        return $dispatcher;
    }
}


class MockAsset extends \MDB\AssetBundle\Document\Asset
{
    protected $id;
    protected $parent;
    protected $level;

    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }
    public function getLevel()
    {
        return $this->level;
    }
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    public function getParent()
    {
        return $this->parent;
    }
    public function __construct()
    {
        $this->id = uniqid();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}

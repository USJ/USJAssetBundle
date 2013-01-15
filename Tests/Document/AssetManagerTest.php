<?php
namespace MDB\AssetBundle\Tests\Document;

use MDB\AssetBundle\Document\AssetManager;
use MDB\AssetBundle\Document\Asset;


class AssetManagerTest extends \PHPUnit_Framework_TestCase
{
	private $assetMangaer;
	private $dm;
	private $repository;

	const ASSETTYPE = "MDB\AssetBundle\Tests\Document\DummyAsset";

	public function setUp()
	{
		$this->assetManager = $this->getAssetManagerMock();
	}

	public function testFindAssetBy()
	{
		$crit = array("name" => "Asset Name");
		$this->assetManager->expects($this->once())
			 ->method('findAssetBy')
			 ->with($this->equalTo(array('name' => 'Asset Name')));

        $this->assetManager->findAssetBy($crit);
	}

	public function testFindAssets()
	{
		# code...
	}

	protected function getAssetManagerMock()
	{
		return $this->getMockBuilder('MDB\AssetBundle\Document\AssetManager')
            ->disableOriginalConstructor()
            //set of method that mockup will do.
            ->setMethods(array('findAssetBy'))
            ->getMock();
	}

}
class DummyAsset extends \MDB\AssetBundle\Document\Asset
{

}
<?php
namespace MDB\AssetBundle\Tests\Document;

use MDB\AssetBundle\Document\AssetManager;
use MDB\AssetBundle\Document\Asset;


class AssetManagerTest extends BaseAssetTreeTest
{
    public function testCloneAssetTree()
    {
        $am = new AssetManager($this->dispatcher, $this->dm, null);
        $newAssets = $am->cloneAssetHierachy($this->assets[0]);

        $expectedAssets = array();
        foreach ($this->assets as $newAsset) {
            $expectedAssets[] = $newAsset;
        }
        $this->assertEquals($expectedAssets, $newAssets);

    }
}

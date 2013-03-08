<?php
namespace MDB\AssetBundle\Document;
use MDB\AssetBundle\Model\AssetManager as BaseAssetManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * This manager contain following functionalities.
 * - query for different asset information
 * - return an asset object by variety of information
 * - removing asset
 * - change asset information
 * - retrieve children hierachy
 * - return children of a node
 */

use Doctrine\ODM\MongoDB\DocumentManager;

class AssetManager extends BaseAssetManager
{
    protected $class;
    protected $dm;
    protected $repository;
    protected $metadata;

    /**
     * Constructor, initialize the repository class.
     */
    public function __construct(EventDispatcherInterface $dispatcher, $dm, $class)
    {
        parent::__construct($dispatcher);

        $this->class = $class;
        $this->dm = $dm;

        $this->repository = $this->dm->getRepository($this->class);
    }

    /**
     * Create a new asset
     *
     * @param $asset Asset object
     */
    public function createAsset()
    {
        $class = $this->getClass();
        $asset = new $class;

        return $asset;
    }

    public function getClass()
    {
        return $this->class;
    }


    /**
     * Find a single asset with specific criteria
     *
     * @param array $criteria
     *
     * @return MDB\AssetBundle\Document\Asset $asset
     */
    public function findAssetBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    public function findAssetById($id)
    {
        return $this->repository->findOneById($id);
    }

    /**
     * Find assets with specific criteria
     *
     * @param array $criteria
     *
     * @return MDB\AssetBundle\Document\Asset $asset
     */
    public function findAssetsBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    /**
     * Delete an asset
     *
     * @param $asset asset object
     */
    public function deleteAsset(Asset $asset)
    {
        $this->dm->remove($asset);
        $this->dm->flush();
    }

    /**
     * Update an asset
     *
     * @param $asset given the provided asset
     */
    public function updateAsset(Asset $asset, $andFlush = true)
    {
        $this->dm->persist($user);
        if ($andFlush) {
            $this->dm->flush();
        }
    }

    /**
     * This class will be remove later, use findAssets() instead
     */
    public function findAllAssets()
    {
        // retrieve all the asset
        return $this
            ->findAssets();
    }


    /**
     *Retrieve all the assets in the database
     *
     * @return $assets Doctrine_Collection
     */
    public function findAssets()
    {
        return $this
            ->getManager()
            ->getRepository($this->class)->findAll();
    }

    private function getManager()
    {
        return $this->dm;
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function getAssetRepository()
    {
        return $this->repository;
    }

    public function cloneAssetHierachy($asset)
    {
        $batchSize = 1;
        // clone the children
        // clone the make the link back
        $assets = $this->assetChildren($asset, null, 'level', 'asc', true);
        // top to bottom
        $index = 0;
        $topParent = null;
        $clonedAssets = array();
        foreach ($assets as $asset) {
            $newAsset = clone $asset;
            $newAsset->setId(null);
            $newAsset->setOldId($asset->getId());
            if($index == 0) {
                $newAsset->setName('Copy of '.$asset->getName());
            }

            if($asset->getParent()){
                $newAsset->setOldParentId($asset->getParent()->getId());
                if($index == 0) {
                    $topParent = $asset->getParent();
                }
            }

            $clonedAssets[] = $newAsset;
            $index += 1;
        }

        // set the parent with id
        foreach ($clonedAssets as $clonedAsset) {
            // var_dump("called first");
            // var_dump(!is_null($clonedAsset->getParent()));
            // find out the parent and replace id with newly cloned
            if(!is_null($clonedAsset->getParent())) {
                // var_dump($clonedAsset->getOldParentId());
                // var_dump($topParent->getId() == $clonedAsset->getOldParentId());
                if($topParent) {
                    if($topParent->getId() == $clonedAsset->getOldParentId()){
                        $clonedAsset->setParent($topParent);
                    }
                    $topParent = null;
                }else{
                    $assetParentMap = function($ele) {
                        return $ele->getOldId();
                    };
                    $parentAssetIdArray = array_map($assetParentMap, $clonedAssets);
                    $aIndex = array_search($clonedAsset->getOldParentId(), $parentAssetIdArray);
                    $clonedAsset->setParent($clonedAssets[$aIndex]);
                }
            }
        }
        $generatePath = function($asset) {
            if(!isset($this->metadata)) {
                $this->metadata = $this->dm->getClassMetadata($this->class);
            }

            $sources = array();
            $parent = null;
            for ($i=0; $i < $asset->getLevel(); $i++) {
                if($i == 0) {
                    $sources[] = $asset;
                    continue;
                }
                $sources[] = $sources[$i-1]->getParent();
            }
            $sources = array_reverse($sources);
            $path = '';

            foreach ($sources as $p => $id) {
                $path .= '-'.$id.'|';
            }
            return $asset->setPath($path);
        };
        $clonedAssets = array_map($generatePath, $clonedAssets);

        $collection = new \Doctrine\Common\Collections\ArrayCollection($clonedAssets);
        foreach ($collection as $item) {
            $this->dm->persist($item);
        }
        $this->dm->flush();
        $this->dm->clear();
        return $collection->first();
        // $this->saveAsset($clonedAssets);

        // foreach ($clonedAssets as $clonedAsset) {
        //     $this->saveAsset($clonedAsset);
        // }

        // var_dump(array_map(
        //     function($ele){ return array(
        //         'id'=>(string)$ele->getId(),
        //         'parent_id'=>($ele->getParent())?(string)$ele->getParent()->getId():'no parent',
        //         'level'=>$ele->getLevel());
        //     }
        //     ,$clonedAssets));die;

        // for ($i=0; $i < count($clonedAssets); $i++) {
        //     $asset = $clonedAssets[$i];
        //     $this->dm->persist($asset);
        //     if(($i % $batchSize) === 0) {
        //         $this->dm->flush();
        //         $this->dm->clear();
        //     }
        // }
        // die;
        // $this->dm->flush();
        // return $newAssets;
        // $this->container->get("mdb_asset.manager.asset")->saveAsset($newAsset);
    }

    /**
     * children of a asset, wrapping all DoctrineExtensions childrenHierachy function.
     */
    public function assetChildrenHierachy(Asset $asset = null, $direct = false ,array $options, $includeNode = false)
    {
        return $this->repository->childrenHierachy($asset, $direct, $options, $includeNode);
    }

    /**
     * get all children of an asset.
     */
    public function assetDirectChildren(Asset $asset, $direct = true, $sortByField = null, $direction = "asc", $includeNode = false)
    {
        return $this->repository->getChildren($asset, $direct , $sortByField , $direction , $includeNode);
    }

    public function assetChildren(Asset $asset, $direct = false, $sortByField = null, $direction = "asc", $includeNode = false)
    {
        return $this->repository->getChildren($asset, $direct, $sortByField , $direction , $includeNode);
    }

    /**
     * get all the root assets.
     */
    public function getRootAssets($sortByField = null, $direction = "asc")
    {
        return $this->repository->getRootNodes($sortByField, $direction);
    }

    public function doSaveAsset($asset)
    {
        $this->dm->persist($asset);
        $this->dm->flush();
    }

    public function isNewAsset($asset)
    {
        return !$this->dm->getUnitOfWork()->isInIdentityMap($asset);
    }

}

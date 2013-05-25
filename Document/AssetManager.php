<?php
namespace MDB\AssetBundle\Document;

use MDB\AssetBundle\Model\AssetManager as BaseAssetManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\Common\Collections\ArrayCollection;
use MDB\AssetBundle\Document\Asset;

/**
 *
 * This manager contain following functionalities.
 * - query for different asset information
 * - return an asset object by variety of information
 * - removing asset
 * - change asset information
 * - retrieve children hierachy
 * - return children of a node
 *
 * @author Marco Leong <leong.chou.kin@usj.edu.mo>
 */
class AssetManager extends BaseAssetManager
{

    /**
     * @var string
     */
    protected $class;

    /**
     * @var \Doctrine\ODM\MongoDB\DocumentManager
     */
    protected $dm;

    /**
     * @var \MDB\AssetBundle\Repository\AssetRepository
     */
    protected $repository;

    /**
     * @var \Doctrine\ODM\MongoDB\Mapping\ClassMetadata
     */
    protected $metadata;

    public function __construct(EventDispatcherInterface $dispatcher, $dm, $class)
    {
        parent::__construct($dispatcher);

        $this->class = $class;
        $this->dm = $dm;

        $this->repository = $this->getRepository();
    }

    /**
     * Create a new asset
     *
     * @return \MDB\AssetBundle\Document\Asset
     */
    public function createAsset()
    {
        $class = $this->getClass();
        $asset = new $class;

        return $asset;
    }

    /**
     * Find a single asset with specific criteria
     *
     * @param array $criteria
     *
     * @return \MDB\AssetBundle\Document\Asset
     */
    public function findAssetBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * Find an asset via id
     *
     * @param string
     *
     * @return \MDB\AssetBundle\Document\Asset
     */
    public function findAssetById($id)
    {
        return $this->repository->findOneById($id);
    }

    /**
     * Find assets with specific criteria
     *
     * @param array $criteria
     *
     * @return MDB\AssetBundle\Document\Asset
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
     * @param \MDB\AssetBundle\Document\Asset $asset given the provided asset
     * @param bool $andFlush
     */
    public function updateAsset(Asset $asset, $andFlush = true)
    {
        $this->dm->persist($user);
        if ($andFlush) {
            $this->dm->flush();
        }
    }

    /**
     * @return Doctrine_Collection
     */
    public function findAllAssets()
    {
        // retrieve all the asset
        return $this
            ->findAssets();
    }

    /**
     * Retrieve all the assets in the database
     *
     * @return Doctrine_Collection
     */
    public function findAssets()
    {
        return $this->repository->findAll();
    }

    /**
     * Return the repository used by this manager
     *
     * @return AssetRepository
     */
    public function getRepository()
    {
        if (!$this->repository) {
            return $this->dm->getRepository($this->class);
        }

        return $this->repository;
    }

    /**
     * Asset cloning operation to clone all the children of
     * the asset.
     *
     * @param \MDB\AssetBundle\Document\Asset $asset
     *
     * @return ArrayCollection
     */
    public function cloneAssetHierachy($asset)
    {
        $assets = $this->assetChildren($asset, null, 'level', 'asc', true);
        // top to bottom
        $index = 0;
        $topParent = null;
        $clonedAssets = array();
        foreach ($assets as $asset) {
            $newAsset = clone $asset;

            if ($index == 0) {
                $newAsset->setName('Copy of '.$asset->getName());
            }

            if ($asset->getParent()) {
                $newAsset->setOldParentId($asset->getParent()->getId());
                if ($index == 0) {
                    $topParent = $asset->getParent();
                }
            }

            $clonedAssets[] = $newAsset;
            $index += 1;
        }

        // set the parent with id
        foreach ($clonedAssets as $clonedAsset) {
            // find out the parent and replace id with newly cloned
            if (!is_null($clonedAsset->getParent())) {
                if ($topParent) {
                    if ($topParent->getId() == $clonedAsset->getOldParentId()) {
                        $clonedAsset->setParent($topParent);
                    }
                    $topParent = null;
                } else {
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
            if (!isset($this->metadata)) {
                $this->metadata = $this->dm->getClassMetadata($this->class);
            }

            $sources = array();
            $parent = null;
            for ($i=0; $i < $asset->getLevel(); $i++) {
                if ($i == 0) {
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

        $collection = new ArrayCollection($clonedAssets);

        foreach ($collection as $item) {
            $this->dm->persist($item);
        }

        $this->dm->flush();
        $this->dm->clear();

        return $collection;
    }

    public static function generatePath($asset)
    {
        $sources = array();
        $parent = null;
        for ($i=0; $i < $asset->getLevel(); $i++) {
            if ($i == 0) {
                $sources[] = $asset;
                continue;
            }
            $sources[] = $sources[$i-1]->getParent();
        }
        $sources = array_reverse($sources);
        $path = '';

        foreach ($sources as $p) {
            $path .= '-'.(string) $p->getId().'|';
        }

        return $path;
    }

    /**
     * Children hierachy of an asset \Gedmo\Tree\Document\MongoDB\Repository\MaterializedPathRepository
     *
     * @see \Gedmo\Tree\Document\MongoDB\Repository\MaterializedPathRepository::childrenHierachy
     */
    public function assetChildrenHierachy(Asset $asset = null, $direct = false ,array $options, $includeNode = false)
    {
        return $this->repository->childrenHierachy($asset, $direct, $options, $includeNode);
    }

    /**
     * Direct children of an asset \Gedmo\Tree\Document\MongoDB\Repository\MaterializedPathRepository
     *
     * @see \Gedmo\Tree\Document\MongoDB\Repository\MaterializedPathRepository::getChildren
     */
    public function assetDirectChildren(Asset $asset, $direct = true, $sortByField = null, $direction = "asc", $includeNode = false)
    {
        return $this->repository->getChildren($asset, $direct , $sortByField , $direction , $includeNode);
    }

    /**
     * Children of an asset
     *
     * @see \Gedmo\Tree\Document\MongoDB\Repository\MaterializedPathRepository::getChildren
     */
    public function assetChildren(Asset $asset, $direct = false, $sortByField = null, $direction = "asc", $includeNode = false)
    {
        return $this->repository->getChildren($asset, $direct, $sortByField , $direction , $includeNode);
    }

    /**
     * Get all the root assets in a tree \Gedmo\Tree\Document\MongoDB\Repository\MaterializedPathRepository
     *
     * @see \Gedmo\Tree\Document\MongoDB\Repository\MaterializedPathRepository::getRootNodes
     */
    public function getRootAssets($sortByField = null, $direction = "asc")
    {
        return $this->repository->getRootNodes($sortByField, $direction);
    }

    /**
     * Do the actual save operation
     */
    protected function doSaveAsset($asset)
    {
        $this->dm->persist($asset);
        $this->dm->flush();
    }

    /**
     * Check if the asset in a new asset
     */
    public function isNewAsset($asset)
    {
        return !$this->dm->getUnitOfWork()->isInIdentityMap($asset);
    }

    /**
     * Return back the classname of the asset
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    private function getManager()
    {
        return $this->dm;
    }
}

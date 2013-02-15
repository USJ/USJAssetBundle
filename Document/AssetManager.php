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
		return $this->repository->getChildren($asset, $direct , $sortByField , $direction , $includeNode );
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
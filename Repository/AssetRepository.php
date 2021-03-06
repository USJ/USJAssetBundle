<?php

namespace MDB\AssetBundle\Repository;

use Gedmo\Tree\Document\MongoDB\Repository\MaterializedPathRepository;

/**
 * AssetRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AssetRepository extends MaterializedPathRepository
{
    public function findByIds($array)
    {
        return $this->createQueryBuilder('MDB\AssetBundle\Document\Asset')
            ->field('id')->in($array)
            ->getQuery()
            ->execute();
    }

    public function findAssetById($id)
    {
        return $this->createQueryBuilder('MDB\AssetBundle\Document\Asset')
            ->field('_id')->equals($id)
            ->getQuery()
            ->getSingleResult();
    }

    public function countChildren($forAsset)
    {
        return count($this->getChildren($forAsset, true)->slaveOkay());
    }

    public function findAndUpdateNbchildren($id, $nbchildren)
    {
        return $this->createQueryBuilder()
            ->findAndUpdate()
            ->field('_id')->equals($id)
            ->field('nbchildren')->set((int) $nbchildren)
            ->getQuery()
            ->execute();
    }

    public function updateNbchildren($assetOrId)
    {
        if ($assetOrId instanceof \MongoId) {
            $asset = $this->findById($assetOrId);

            return $this->findAndUpdateNbchildren($assetOrId, $this->countChildren($asset));
        }
    }

    public function findDistinctTags()
    {
        return $this->createQueryBuilder()
            ->distinct('tags')
            ->hydrate(false)
            ->getQuery()
            ->execute();
    }
}

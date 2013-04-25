<?php

namespace MDB\AssetBundle\Search;

use FOS\ElasticaBundle\Provider\ProviderInterface;
use Elastica_Document;

class AssetProvider implements ProviderInterface
{
    protected $assetType;
    protected $managerRegistry;
    protected $objectClass;

    public function __construct($assetType, $objectClass, $managerRegistry)
    {
        $this->assetType = $assetType;
        $this->managerRegistry = $managerRegistry;
        $this->objectClass = $objectClass;
    }

    public function populate(\Closure $loggerClosure = null)
    {
        $queryBuilder = $this->createQueryBuilder();
        $nbObjects = $this->countObjects($queryBuilder);

        for ($offset = 0; $offset < $nbObjects; $offset += 100) {
            if ($loggerClosure) {
                $stepStartTime = microtime(true);
            }
            $objects = $this->fetchSlice($queryBuilder, 100 , $offset);

            $this->assetType->addDocuments($objects);

            if ($loggerClosure) {
                $stepNbObjects = count($objects);
                $stepCount = $stepNbObjects + $offset;
                $percentComplete = 100 * $stepCount / $nbObjects;
                $objectsPerSecond = $stepNbObjects / (microtime(true) - $stepStartTime);
                $loggerClosure(sprintf('%0.1f%% (%d/%d), %d objects/s', $percentComplete, $stepCount, $nbObjects, $objectsPerSecond));
            }
        }
    }

    protected function countObjects($queryBuilder)
    {
        return $queryBuilder->getQuery()->execute()->count();
    }

    protected function fetchSlice($queryBuilder, $limit, $offset)
    {
        $assets = $queryBuilder
            ->skip($offset)
            ->limit($limit)
            ->getQuery()->execute();

        $objects = array();

        foreach ($assets as $asset) {
            $objects[] = $this->buildDocument($asset);
       }

       return $objects;
    }

    protected function buildDocument($asset)
    {
        $document = new Elastica_Document(
            $asset->getId(),
            array(
                "name" => $asset->getName(),
                "description" => $asset->getDescription(),
                "category" => $asset->getCategory()
            ),
            "asset",
            "mdb_asset"
         );

        if ($asset->getProperties()) {
            $flattened = '';
            foreach ($asset->getProperties() as $property) {
                $document->add($property['name'], $property['value']);
                $flattened .= sprintf("%s : %s", $property['name'], $property['value']);
            }
            $document->add("properties", $flattened);
        }

        return $document;
    }

    protected function createQueryBuilder()
    {
        return $this->managerRegistry
            ->getRepository($this->objectClass)
            ->createQueryBuilder($this->objectClass);
    }

}

<?php

namespace MDB\AssetBundle\Document;

use MDB\AssetBundle\Document\Location;

class LocationManager {

    protected $dispatcher;

    protected $dm;

    protected $class;

    protected $repository;

    public function __construct($dispatcher, $dm, $class)
    {
        $this->dispatcher = $dispatcher;
        $this->dm = $dm;
        $this->class = $class;
        $this->repository = $this->dm->getRepository($class);
    }

    public function createLocation()
    {
        return new $this->class;
    }

    public function saveLocation(Location $location)
    {
        $this->dm->persist($location);
        $this->dm->flush();
    }

    public function findLocationBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    public function findLocationsBy(array $criteria)
    {
        return $this->repository->findBy($criteria);
    }

    public function findLocationById($id)
    {
        return $this->repository->findOneById($id);
    }

    public function findLocationByName($name)
    {
        return $this->repository->findOneByName($name);
    }

    public function getRepository()
    {
        return $this->repository;
    }
}
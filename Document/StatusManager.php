<?php
namespace MDB\AssetBundle\Document;

use MDB\AssetBundle\Document\Status;

class StatusManager {

    protected $dm;
    protected $class;
    protected $repository;

    public function __construct($dm, $class)
    {
        $this->dm = $dm;
        $this->class = $class;
        $this->repository = $this->dm->getRepository($class);
    }

    public function getClass()
    {
        return $this->class;
    }

    public function createStatus()
    {
        $class = $this->getClass();
        $status = new $class;

        return $status;
    }

    public function deleteStatus($status)
    {
        $this->dm->remove($status);
        $this->dm->flush();
    }

    public function saveStatus($status)
    {
        $this->doSaveStatus($status);
    }

    public function doSaveStatus($status)
    {
        $this->dm->persist($status);
        $this->dm->flush();
    }
    
    public function findAllStatuses()
    {
        return $this->repository->findAll();    
    }

    public function findAll()
    {
        return $this->repository->findAll();    
    }

    public function findStatusesBy($criteria)
    {
        return $this->repository->findBy($criteria);
    }

    public function findOneBy($criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    public function findStatusById($id)
    {
        return $this->repository->findOneById($id);
    }

    public function findByCountedAsRunning($counted)
    {
        return $this->repository->findBy(array('countedAsRunning' => $counted));
    }

    public function getRepository()
    {
        return $this->repository;
    }
}
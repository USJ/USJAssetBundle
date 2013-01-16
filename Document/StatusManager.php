<?php
namespace MDB\AssetBundle\Document;

use MDB\AssetBundle\Document\Status;

class StatusManager {

    protected $dm;
    protected $class;

    public function __construct($dm, $class)
    {
        $this->dm = $dm;
        $this->class = $class;
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
        return $this->getRepository()->findAll();    
    }

    public function findAll()
    {
        return $this->getRepository()->findAll();    
    }

    public function findStatusesBy($criteria)
    {
        return $this->getRepository()->findBy($criteria);
    }

    public function findOneBy($criteria)
    {
        return $this->getRepository()->findOneBy($criteria);
    }

    public function findStatusById($id)
    {
        return $this->getRepository()->findOneById($id);
    }

    public function findByCountedAsRunning($counted)
    {
        return $this->getRepository()->findBy(array('countedAsRunning' => $counted));
    }

    private function getRepository()
    {
        return $this->dm->getRepository("MDBAssetBundle:Status");
    }
}
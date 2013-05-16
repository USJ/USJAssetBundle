<?php
namespace MDB\AssetBundle\Document;

/**
 * @author Marco Leong <marcoleong@cloudruge.com>
 */
class VendorManager
{
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

    public function findVendors()
    {
        return $this->repository->findAll();
    }

    public function findVendorById($id)
    {
        return $this->repository->findBy(array('_id' =>$id));
    }
}

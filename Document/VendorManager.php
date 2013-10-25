<?php
namespace MDB\AssetBundle\Document;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 *
 * Service to manage vendor
 * 
 * @author Marco Leong <marcoleong@cloudruge.com>
 */
class VendorManager
{

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var \Doctrine\ODM\MongoDB\DocumentManager
     */
    protected $dm;

    /**
     * @var string
     */
    protected $class;

    /**
     * 
     * @var \Doctrine\ODM\MongoDB\DocumentRepository
     */
    protected $repository;

    public function __construct(EventDispatcherInterface $dispatcher, $dm, $class)
    {
        $this->dispatcher = $dispatcher;
        $this->dm = $dm;
        $this->class = $class;

        $this->repository = $this->dm->getRepository($class);
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function findVendors()
    {
        return $this->repository->findAll();
    }

    public function findVendorById($id)
    {
        return $this->repository->findBy(array('_id' =>$id));
    }

    public function findVendorByName($name)
    {
        return $this->repository->findOneByName($name);
    }

    public function saveVendor($vendor)
    {
        $this->dm->persist($vendor);
        $this->dm->flush();
    }

    public function createVendor()
    {
        $class = $this->class;

        return new $class;
    }
}

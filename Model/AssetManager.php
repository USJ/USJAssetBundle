<?php
namespace MDB\AssetBundle\Model;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use MDB\AssetBundle\Event\AssetEvent;
use MDB\AssetBundle\Events;
/**
 * Abstract  of workorder manager
 */
abstract class AssetManager
{
    protected $dispatcher;

    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function saveAsset($asset)
    {
        $event = new AssetEvent($asset);
        $this->dispatcher->dispatch(Events::ASSET_PRE_PERSIST, $event);

        $this->doSaveAsset($asset);

        $event = new AssetEvent($asset);
        $this->dispatcher->dispatch(Events::ASSET_POST_PERSIST, $event);
    }

    public function findAllWorkOrders()
    {
        return $this->repository->findAll();
    }

    public function findWorkOrderBy($criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    public function findWorkOrderById($id)
    {
        return $this->repository->findOneById($id);
    }

    public function findWorkOrdersBy($criteria)
    {
        return $this->repository->findBy($criteria);
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function setRepository($repository)
    {
        $this->repository = $repository;
        return $this;
    }

    abstract protected function doSaveAsset($asset);
}

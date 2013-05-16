<?php
namespace MDB\AssetBundle\EventListener;

use Doctrine\Common\EventSubscriber;

/**
 * Subscribe to asset save and update operation, in order
 * to generate the count of asset children
 *
 * prePersist, check parent children count and +1 the count
 *
 * @author Marco Leong <marcoleong@cloudruge.com>
 */
class CountAssetChildrenSubscriber implements EventSubscriber
{
    protected $class;

    protected $repository;

    public function __construct($class)
    {
        $this->class = $class;
    }

    public function postPersist(\Doctrine\ODM\MongoDB\Event\LifecycleEventArgs $args)
    {
        // $this->doCountChildren($args);
        $document = $args->getDocument();

        if ($document instanceof $this->class && $document->getParent()) {
            $parentId = $document->getParent()->getId();
            $this->repository = $args->getDocumentManager()->getRepository($this->class);
            $this->repository->findAndUpdateNbchildren($parentId, $this->countChildren($document->getParent()) + 1);
        }
    }

    // public function postUpdate(\Doctrine\ODM\MongoDB\Event\LifecycleEventArgs $args)
    // {
    //     $this->doCountChildren($args);
    // }

    public function preUpdate(\Doctrine\ODM\MongoDB\Event\PreUpdateEventArgs $args)
    {
        $document = $args->getDocument();

        if ($document instanceof $this->class && $args->hasChangedField('parent')) {
            $documentManager = $args->getDocumentManager();
            $this->repository = $documentManager->getRepository($this->class);

            // if current asset parent set to null, then update the nbchildren count of parent
            if (!is_null($args->getOldValue('parent')) && is_null($args->getNewValue('parent'))) {
                $parent = $args->getOldValue('parent');
                $this->repository->findAndUpdateNbchildren($parent->getId(),$this->countChildren($parent) - 1);
            } else {
                $parent = $args->getNewValue('parent');
                $this->repository->findAndUpdateNbchildren($parent->getId(),$this->countChildren($parent) + 1);
            }
        }
    }

    // public function doCountChildren($args)
    // {
    //     $document = $args->getDocument();

    //     if ($document instanceof $this->class) {

    //         if (is_null($document->getParent())) {
    //             return;
    //         }

    //         $documentManager = $args->getDocumentManager();
    //         $this->repository = $documentManager->getRepository($this->class);

    //         $parent = $document->getParent();
    //         $parent->setNbchildren($this->countChildren($parent));

    //         $documentManager->persist($parent);
    //         $documentManager->flush();
    //     }
    // }
    /**
     * through checking the path and level of asset, count
     * the children of the asset.
     *
     * @param MDB\AssetBundle\Document\Asset $forAsset
     *
     * @return int $result;
     */
    public function countChildren($forAsset)
    {
        return $this->repository->countChildren($forAsset);
    }

    public function getSubscribedEvents()
    {
        return array('postPersist', 'preUpdate');
    }
}

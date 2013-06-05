<?php
namespace MDB\AssetBundle\EventListener;

class InOutChangeListener
{
    public function preUpdate(\Doctrine\ODM\MongoDB\Event\LifecycleEventArgs $eventArgs)
    {
        $document = $eventArgs->getDocument();

        if ($document instanceof \MDB\AssetBundle\Document\Asset) {
            $dm = $eventArgs->getDocumentManager();

            $class = $dm->getClassMetadata();
            $dm->getUnitOfWork()->recomputeSingleDocumentChangeSet($class, $document);
        }
    }
}

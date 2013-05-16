<?php

namespace MDB\AssetBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\PreUpdateEventArgs;
use MDB\AssetBundle\Document\Asset;
/**
*
*/
class StatusChangeListener
{
    protected $statusLogClass;

    public function __construct($statusLogClass)
    {
        $this->statusLogClass = $statusLogClass;
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $document = $args->getDocument();

        if ($document instanceof Asset && $args->hasChangedField('status')) {
            $dm = $args->getDocumentManager();
            $oldValue = $args->getOldValue('status');
            $newValue = $args->getNewValue('status');

            $statusLog = new $this->statusLogClass;
            $statusLog->change($oldValue, $newValue);
            $document->addLog($statusLog);

            $class = $dm->getClassMetadata(get_class($document));
            $dm->getUnitOfWork()->recomputeSingleDocumentChangeSet($class, $document);
        }
    }
}

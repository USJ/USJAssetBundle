<?php
namespace MDB\AssetBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\PreUpdateEventArgs;
use MDB\AssetBundle\Document\Asset;

/**
* Subscriber which response for logging the asset logs
*/
class DeletedAtChangeListener
{

    protected $deleteLogClass;

    public function __construct($deleteLogClass)
    {
        $this->deleteLogClass = $deleteLogClass;
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $document = $args->getDocument();

        if ($document instanceof Asset && $args->hasChangedField('deletedAt')) {
            $dm = $args->getDocumentManager();
            $deleteLog = new $this->deleteLogClass;
            $deleteLog->change($args->getOldValue('deletedAt'), $args->getNewValue('deletedAt'));

            $document->addLog($deleteLog);

            // nessessary for update
            $class = $dm->getClassMetadata(get_class($document));
            $dm->getUnitOfWork()->recomputeSingleDocumentChangeSet($class, $document);
        }
    }

}

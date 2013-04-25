<?php
namespace MDB\AssetBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\PreUpdateEventArgs;
use MDB\AssetBundle\Document\Asset;

/**
* Subscriber which response for logging the asset logs
*/
class AssigneeChangeListener
{

    protected $assignLogClass;

    public function __construct($assignLogClass)
    {
        $this->assignLogClass = $assignLogClass;
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $document = $args->getDocument();

        if ($document instanceof Asset && $args->hasChangedField('assignee')) {
            $dm = $args->getDocumentManager();
            $assignLog = new $this->assignLogClass;
            $assignLog->change($args->getOldValue('assignee'), $args->getNewValue('assignee'));

            $document->addLog($assignLog);

            // nessessary for update
            $class = $dm->getClassMetadata(get_class($document));
            $dm->getUnitOfWork()->recomputeSingleDocumentChangeSet($class, $document);
        }
    }

}

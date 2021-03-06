<?php
namespace MDB\AssetBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\PreUpdateEventArgs;
use MDB\AssetBundle\Document\Asset;
use MDB\AssetBundle\Document\AssetManager;

/**
* Subscriber which response for logging the asset logs
*/
class ParentChangeListener
{

    protected $parentLogClass;

    public function __construct($parentLogClass)
    {
        $this->parentLogClass = $parentLogClass;
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $document = $args->getDocument();

        if ($document instanceof Asset && $args->hasChangedField('parent')) {
            $dm = $args->getDocumentManager();
            $parentLog = new $this->parentLogClass;
            $parentLog->change($args->getOldValue('parent'), $args->getNewValue('parent'));

            $document->addLog($parentLog);
            $document->setPath(AssetManager::generatePath($document));
            // nessessary for update
            $class = $dm->getClassMetadata(get_class($document));
            $dm->getUnitOfWork()->recomputeSingleDocumentChangeSet($class, $document);
        }
    }

}

<?php 
namespace MDB\AssetBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\PreUpdateEventArgs;
use MDB\AssetBundle\Document\Asset;
use MDB\AssetBundle\Document\Action;

class ParentChangeListener {

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $document = $args->getDocument(); 
        if ($document instanceof Asset) {
            if($args->hasChangedField('parent')) {
                $dm = $args->getDocumentManager();
                // create new action
                $action = new Action();
                $action->setType("move");
                $properties['from_parent'] = $args->getOldValue('parent');
                $properties['to_parent'] = $args->getNewValue('parent');
                $action->setProperties($properties);
                $asset->addActions($action);  
            }
        }
    }
}
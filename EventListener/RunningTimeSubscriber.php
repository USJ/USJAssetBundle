<?php
namespace MDB\AssetBundle\EventListener;

use Doctrine\ODM\MongoDB\Event\LifecycleEventArgs,
	Doctrine\ODM\MongoDB\Event\PreUpdateEventArgs,
	Doctrine\Common\EventSubscriber,
	MDB\AssetBundle\Document\Asset,
	Symfony\Component\DependencyInjection\ContainerAware;
	
class RunningTimeSubscriber implements EventSubscriber{

    protected $dm;
    protected $statusManager;

    public function __construct($dm, $statusManager)
    {
        $this->dm = $dm;
        $this->statusManager = $statusManager;
    }

	public function getSubscribedEvents()
	{
		return array('preUpdate' => 'onPreUpdate');
	}

	public function onPreUpdate(PreUpdateEventArgs $eventArgs)
	{
		$document = $eventArgs->getDocument();
		if($document instanceof Asset){
            // doesn't work when asset create
			//RUNNING status means status that count
			if($eventArgs->hasChangedField('status') && $eventArgs->getOldValue('status')->isCountedAsRunning() ){

				$lastChangedTime = $document->getStatusChangedAt();
				$duration = time() - $lastChangedTime;
				$oldTime = $document->getRunningTime();
				$document->setRunningTime($oldTime + $duration);

				// $dm = $eventArgs->getDocumentManager();
		  //       $class = $dm->getClassMetadata('MDB\AssetBundle\Document\Asset');
		  //       $dm->getUnitOfWork()->recomputeSingleDocumentChangeSet($class, $document);
			}
		}
	}

}
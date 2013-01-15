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
			if($eventArgs->hasChangedField('status') && $this->isRunningTime($eventArgs->getOldValue('status')) ){

				$lastChangedTime = $document->getStatusChangedAt();
				$duration = time() - $lastChangedTime;
				$oldTime = $document->getRunningTime();
				$document->setRunningTime($oldTime + $duration);

				// $dm = $eventArgs->getDocumentManager();
		  //       $class = $dm->getClassMetadata('MDB\AssetBundle\Document\Asset');
		  //       $dm->getUnitOfWork()->recomputeSingleDocumentChangeSet($class, $document);
			}
            // if($dm->getUnitOfWork() > 0) {
            //     $dm->persist($document);
            //     $dm->flush();
            // }
		}
	}

	private function isRunningTime($status)
	{
        $status = $this->container->get('mdb_asset_status_manager')->findOneById($status);
		return $status->getCountedAsRunning();
	}

}
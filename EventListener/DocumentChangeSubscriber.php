<?php
namespace MDB\AssetBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use MDB\DocumentBundle\Events;
use MDB\DocumentBundle\Event\LinkEvent;
use MDB\AssetBundle\Document\Asset;

/**
*
*/
class DocumentChangeSubscriber implements EventSubscriberInterface
{
    protected $assetManager;
    protected $documentLogClass;

    public function __construct($assetManager, $documentLogClass)
    {
        $this->assetManager = $assetManager;
        $this->documentLogClass = $documentLogClass;
    }

    public function postLink(LinkEvent $event)
    {
        $asset = $this->assetManager->findAssetById((string) $event->getLink()->getObjectId());
        if(!$asset) {
            return;
        }

        $documentLog = new $this->documentLogClass;

        $documentLog->add($event->getDocument());
        $asset->addLog($documentLog);

        $this->assetManager->saveAsset($asset);
    }

    public function postUnlink(LinkEvent $event)
    {
        $asset = $this->assetManager->findAssetById((string) $event->getLink()->getObjectId());
        if(!$asset) {
            return;
        }
        $documentLog = new $this->documentLogClass;

        $documentLog->remove($event->getDocument());
        $asset->addLog($documentLog);

        $this->assetManager->saveAsset($asset);

    }

    public static function getSubscribedEvents()
    {
        return array(
                Events::DOCUMENT_POST_LINK => 'postLink',
                Events::DOCUMENT_POST_UNLINK => 'postUnlink',
        );
    }
}

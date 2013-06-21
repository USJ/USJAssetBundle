<?php

namespace MDB\AssetBundle\Document;

/**
 * Checkout validation logic to allow
 * 1, CHECK_OUT can change to PERMANENT
 */
class TransferManager
{
    protected $assetManager;

    public function __construct($assetManager)
    {
        $this->assetManager = $assetManager;
    }

    /**
     * this would create new transfer log for the asset
     */
    public function transfer(Asset $asset, $userOrLocation, $type, $comment = null)
    {
        $transferLog = new TransferLog();

        if (!is_null($comment)) {
            $transferLog->setComment($comment);
        }

        if ($userOrLocation instanceof \Symfony\Component\Security\Core\User\AdvancedUserInterface) {
            // consider as user;
            $transferLog->setToUser($userOrLocation);
        }

    }

    public function checkout(Asset $asset, $userOrLocation, $comment)
    {
        $this->transfer($asset, $userOrLocation, 'CHECK_OUT');
    }

    public function checkin(Asset $asset, $comment)
    {
        $this->transfer($asset, $asset->getLastTransfer()->getUser(), 'CHECK_IN', $comment);
    }

    public function findAllTrasferLog($asset)
    {

    }
}

<?php

namespace MDB\AssetBundle\Document;

class TransferManager
{
    /**
     * this would create new transfer log for the asset
     */
    public function transfer(Asset $asset, $userOrLocation, $type)
    {
        $transferLog = new TransferLog();
    }

    public function findAllTrasferLog($asset)
    {

    }
}

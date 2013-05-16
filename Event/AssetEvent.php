<?php
namespace MDB\AssetBundle\Event;
/**
*
*/
use Symfony\Component\EventDispatcher\Event;

class AssetEvent extends Event
{
    private $asset;

    public function __construct($asset)
    {
        $this->asset = $asset;
    }

    public function getAsset()
    {
        return $this->asset;
    }
}

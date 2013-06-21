<?php

namespace MDB\AssetBundle\Serializer\Handler;

use JMS\Serializer\JsonDeserializationVisitor;

/**
 * @author Marco Leong <marcoleong@cloudruge.com>
 */
class AssetParentHandler
{
    protected $assetManager;

    public function __construct($assetManager)
    {
        $this->assetManager = $assetManager;
    }

    public function deserializeJsonToAssetParent(JsonDeserializationVisitor $visitor, $json, array $type)
    {
        $parent = $this->assetManager->findAssetById($json);

        return $parent;
    }
}

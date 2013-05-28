<?php

namespace MDB\AssetBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class InOutLog
 * @package MDB\AssetBundle\Document
 *
 * @MongoDB\MappedSuperclass
 */
class InOutLog extends Log {
    protected $startedAt;
    protected $startedBy;
    protected $endedAt;
    protected $endedBy;
    protected $user;
    protected $location;
    protected $comment;
}
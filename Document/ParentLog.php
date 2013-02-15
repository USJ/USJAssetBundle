<?php
namespace MDB\AssetBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
* @MongoDB\MappedSuperclass
*/
class ParentLog extends Log
{
    const CHANGE = 0;

    protected $from;
    protected $to;

    /**
     * @MongoDB\Int
     */
    protected $changeType;

    public function change($from, $to)
    {
        $this->changeType = self::CHANGE;
        $this->from = $from;
        $this->to = $to;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }
}

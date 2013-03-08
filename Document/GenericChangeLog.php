<?php
namespace MDB\AssetBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
* @MongoDB\MappedSuperclass
*/
abstract class GenericChangeLog extends Log
{

    const CHANGE = 0;
    const ADD = 1;
    const REMOVE = 2;

    /**
     * @MongoDB\String
     */
    protected $from;

    /**
     * @MongoDB\String
     */
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

    public function add($to)
    {
        $this->changeType = self::ADD;
        $this->to = $to;
    }

    public function remove($from)
    {
        $this->changeType = self::REMOVE;
        $this->from = $from;
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

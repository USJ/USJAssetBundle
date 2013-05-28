<?php

namespace MDB\AssetBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class InOutLog
 * @package MDB\AssetBundle\Document
 *
 * @MongoDB\MappedSuperclass
 */
abstract class InOutLog extends Log {

    /**
     * @MongoDB\Date
     */
    protected $startedAt;

    /**
     * @MongoDB\ReferenceOne
     */
    protected $startedBy;

    /**
     * @MongoDB\Date
     */
    protected $endedAt;

    /**
     * @MongoDB\String
     */
    protected $endedBy;

    /**
     * @MongoDB\ReferenceOne
     */
    protected $user;

    /**
     * @MongoDB\ReferenceOne
     */
    protected $location;

    /**
     * @MongoDB\String
     */
    protected $comment;

    /**
     * @var string $type
     */
    protected $type;


    /**
     * Set startedAt
     *
     * @param date $startedAt
     * @return self
     */
    public function setStartedAt($startedAt)
    {
        $this->startedAt = $startedAt;
        return $this;
    }

    /**
     * Get startedAt
     *
     * @return date $startedAt
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * Set startedBy
     *
     * @param $startedBy
     * @return self
     */
    public function setStartedBy($startedBy)
    {
        $this->startedBy = $startedBy;
        return $this;
    }

    /**
     * Get startedBy
     *
     * @return $startedBy
     */
    public function getStartedBy()
    {
        return $this->startedBy;
    }

    /**
     * Set endedAt
     *
     * @param date $endedAt
     * @return self
     */
    public function setEndedAt($endedAt)
    {
        $this->endedAt = $endedAt;
        return $this;
    }

    /**
     * Get endedAt
     *
     * @return date $endedAt
     */
    public function getEndedAt()
    {
        return $this->endedAt;
    }

    /**
     * Set endedBy
     *
     * @param string $endedBy
     * @return self
     */
    public function setEndedBy($endedBy)
    {
        $this->endedBy = $endedBy;
        return $this;
    }

    /**
     * Get endedBy
     *
     * @return string $endedBy
     */
    public function getEndedBy()
    {
        return $this->endedBy;
    }

    /**
     * Set user
     *
     * @param $user
     * @return self
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set location
     *
     * @param $location
     * @return self
     */
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    /**
     * Get location
     *
     * @return $location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return self
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * Get comment
     *
     * @return string $comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return string $type
     */
    public function getType()
    {
        return $this->type;
    }
}

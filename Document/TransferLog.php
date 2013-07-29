<?php

namespace MDB\AssetBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class Transfer Log
 * @package MDB\AssetBundle\Document
 *
 * @MongoDB\MappedSuperclass
 */
abstract class TransferLog extends Log
{
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
    protected $toUser;

    /**
     * @MongoDB\ReferenceOne
     */
    protected $toLocation;

    /**
     * @MongoDB\ReferenceOne
     */
    protected $fromUser;

    /**
     * @MongoDB\ReferenceOne
     */
    protected $fromLocation;

    /**
     * @MongoDB\String
     */
    protected $comment;

    /**
     * @MongoDB\String
     */
    protected $transferType;

    /**
     * Set startedAt
     *
     * @param  date $startedAt
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
     * @param  date $endedAt
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
     * @param  string $endedBy
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
     * @param  string $comment
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

    public function getTransferType()
    {
        return $this->transferType;
    }

    public function setTransferType($transferType)
    {
        $this->transferType = $transferType;

        return $this;
    }

    public function getTransferStatus()
    {
        return $this->transferStatus;
    }

    public function setTransferStatus($transferStatus)
    {
        $this->transferStatus = $transferStatus;

        return $this;
    }

    public function getFromUser()
    {
        return $this->fromUser;
    }

    public function setFromUser($fromUser)
    {
        $this->fromUser = $fromUser;

        return $this;
    }

    public function getToUser()
    {
        return $this->toUser;
    }

    public function setToUser($toUser)
    {
        $this->toUser = $toUser;

        return $this;
    }

    public function getFromLocation()
    {
        return $this->fromLocation;
    }

    public function setFromLocation($fromLocation)
    {
        $this->fromLocation = $fromLocation;

        return $this;
    }

    public function getToLocation()
    {
        return $this->toLocation;
    }

    public function setToLocation($toLocation)
    {
        $this->toLocation = $toLocation;

        return $this;
    }
}

<?php

namespace MDB\AssetBundle\Document;

/**
 * Class Transfer Log
 * @package MDB\AssetBundle\Document
 *
 */
abstract class TransferLog extends Log
{
    /**
     */
    protected $startedAt;

    /**
     */
    protected $startedBy;

    /**
     */
    protected $endedAt;

    /**
     */
    protected $endedBy;

    /**
     */
    protected $toUser;

    /**
     */
    protected $toLocation;

    /**
     */
    protected $fromUser;

    /**
     */
    protected $fromLocation;

    /**
     */
    protected $comment;

    /**
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

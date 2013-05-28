<?php

namespace MDB\AssetBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Class InOut
 * @package MDB\AssetBundle\Document
 *
 * @MongoDB\MappedSuperclass
 */
abstract class InOut {

    /**
     * this should be a reference
     */
    protected $user;

    /**
     * a user reference
     */
    protected $createdBy;

    /**
     * timestampable behavior
     *
     * @MongoDB\Date
     */
    protected $createdAt;

    /**
     * @MongoDB\Date
     */
    protected $expectedAt;

    /**
     * @MongoDB\String
     */
    protected $comment;

    /**
     * Set permanent
     *
     * @param boolean $permanent
     * @return self
     */
    public function setPermanent($permanent)
    {
        $this->permanent = $permanent;
        return $this;
    }

    /**
     * Get permanent
     *
     * @return boolean $permanent
     */
    public function getPermanent()
    {
        return $this->permanent;
    }

    /**
     * Set expectedAt
     *
     * @param date $expectedAt
     * @return self
     */
    public function setExpectedAt($expectedAt)
    {
        $this->expectedAt = $expectedAt;
        return $this;
    }

    /**
     * Get expectedAt
     *
     * @return date $expectedAt
     */
    public function getExpectedAt()
    {
        return $this->expectedAt;
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
     * Set createdBy
     *
     * @param $createdBy
     * @return self
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * Get createdBy
     *
     * @return $createdBy
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set createdAt
     *
     * @param date $createdAt
     * @return self
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}

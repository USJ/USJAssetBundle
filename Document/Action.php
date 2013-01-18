<?php 

namespace MDB\AssetBundle\Document;
 
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\EmbeddedDocument
 */
class Action 
{
	/** 
     * @MongoDB\Id 
     */
	protected $id;

	/** 
     * @MongoDB\String
     */
	protected $type;

	/** 
     * @MongoDB\Timestamp
     */
	protected $createdAt;

    /** 
     * @MongoDB\Hash 
     */
    protected $properties = array();

    /**
     * @MongoDB\String
     */
    protected $message;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param int $type
     * @return Action
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

    /**
     * Set createdAt
     *
     * @param timestamp $createdAt
     * @return Action
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return timestamp $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set metadata
     *
     * @param collection $metadata
     * @return \Action
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
        return $this;
    }

    public function mergeProperties($properties)
    {
        array_merge($this->properties, $properties);
        return $this;
    }
    /**
     * Get properties
     *
     * @return collection $properties
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return \Action
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get message
     *
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }
}

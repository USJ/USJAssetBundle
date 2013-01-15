<?php
namespace MDB\AssetBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * status name, and is counted in running time.
 * @MongoDB\Document
 */
class Status {

    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\Boolean
     */
    protected $countedAsRunning;

    /**
     * @MongoDB\String
     */
    protected $name;

    /**
     * @MongoDB\Boolean
     */
    protected $isDefault;


    public function __construct($name = '', $countedAsRunning = false, $isDefault = false)
    {
        $this->name = $name;
        $this->countedAsRunning = $countedAsRunning;
        $this->isDefault = $isDefault;
    }
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
     * Set countedAsRunning
     *
     * @param boolean $countedAsRunning
     * @return Status
     */
    public function setCountedAsRunning($countedAsRunning)
    {
        $this->countedAsRunning = $countedAsRunning;
        return $this;
    }

    /**
     * Get countedAsRunning
     *
     * @return boolean $countedAsRunning
     */
    public function getCountedAsRunning()
    {
        return $this->countedAsRunning;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Status
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set isDefault
     *
     * @param boolean $isDefault
     * @return Status
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;
        return $this;
    }

    /**
     * Get isDefault
     *
     * @return boolean $isDefault
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }
}

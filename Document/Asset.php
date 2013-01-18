<?php
namespace MDB\AssetBundle\Document;
 
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document(repositoryClass="MDB\AssetBundle\Repository\AssetRepository")
 * @Gedmo\Tree(type="materializedPath", activateLocking=true)
 */
class Asset {

	/** 
     * @MongoDB\Id
 	 */
	protected $id;

    /** 
     * @MongoDB\Hash
     */
    protected $properties;

    /** 
     * Just of warranty and acquisition, etc.
     * 
     * @MongoDB\Hash
     */
    protected $ownershipInfo;
    
    /** 
     * @MongoDB\ReferenceOne(targetDocument="Status", simple=true)
     */ 
    protected $status;

    /** 
     * @MongoDB\Field(type="int")
     */
    protected $runningTime;

    /**
     * @MongoDB\Field(type="timestamp")
     * @Gedmo\Timestampable(on="change",field="status")
     */
    protected $statusChangedAt;

    /**
     * @MongoDB\Field(type="timestamp")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @MongoDB\Field(type="timestamp")
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

	/**
     * @MongoDB\Field(type="string")
     * @Gedmo\Versioned
     */
	protected $name;

	/**
     * @MongoDB\Field(type="string")
     * @Gedmo\Versioned
     */
	protected $description;

	/**
     * @MongoDB\Field(type="string")
     * @Gedmo\TreePathSource
     * @Gedmo\Versioned
     */
    protected $referenceId;

    /**
     * @MongoDB\Field(type="string")
     * @Gedmo\TreePath(separator="|")
     */
    protected $path;

    /**
     * @Gedmo\TreeParent
     * @MongoDB\ReferenceOne(targetDocument="Asset")
     * @Gedmo\Versioned
     */
    protected $parent;

    /**
     * @Gedmo\TreeLevel
     * @MongoDB\Field(type="int")
     */
    protected $level;

    /**
     * @Gedmo\TreeLockTime
     * @MongoDB\Field(type="date")
     */
    protected $lockTime;

    /**
     * @MongoDB\EmbedMany(targetDocument="Action")
     */
    protected $actions =  array();

    /**
     * @MongoDB\String
     */
    protected $category;

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
     * Set createdAt
     *
     * @param timestamp $createdAt
     * @return Asset
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
     * Set updatedAt
     *
     * @param timestamp $updatedAt
     * @return Asset
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return timestamp $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Asset
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
     * Set description
     *
     * @param string $description
     * @return Asset
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Asset
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Get path
     *
     * @return string $path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set parent
     *
     * @param MDB\AssetBundle\Document\Asset $parent
     * @return Asset
     */
    public function setParent(\MDB\AssetBundle\Document\Asset $parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Get parent
     *
     * @return MDB\AssetBundle\Document\Asset $parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set level
     *
     * @param int $level
     * @return Asset
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * Get level
     *
     * @return int $level
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set lockTime
     *
     * @param date $lockTime
     * @return Asset
     */
    public function setLockTime($lockTime)
    {
        $this->lockTime = $lockTime;
        return $this;
    }

    /**
     * Get lockTime
     *
     * @return date $lockTime
     */
    public function getLockTime()
    {
        return $this->lockTime;
    }

    /**
     * Set runningTime
     *
     * @param int $runningTime
     * @return Asset
     */
    public function setRunningTime($runningTime)
    {
        $this->runningTime = $runningTime;
        return $this;
    }

    /**
     * Get runningTime
     *
     * @return int $runningTime
     */
    public function getRunningTime()
    {
        return $this->runningTime;
    }

    /**
     * Set statusChangedAt
     *
     * @param timestamp $statusChangedAt
     * @return Asset
     */
    public function setStatusChangedAt($statusChangedAt)
    {
        $this->statusChangedAt = $statusChangedAt;
        return $this;
    }

    /**
     * Get statusChangedAt
     *
     * @return timestamp $statusChangedAt
     */
    public function getStatusChangedAt()
    {
        return $this->statusChangedAt;
    }


    /**
     * Set status
     *
     * @param MDB\AssetBundle\Document\Status $status
     * @return Asset
     */
    public function setStatus(\MDB\AssetBundle\Document\Status $status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return MDB\AssetBundle\Document\Status $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add actions
     *
     * @param MDB\AssetBundle\Document\Action $actions
     */
    public function addActions(\MDB\AssetBundle\Document\Action $actions)
    {
        $this->actions[] = $actions;
    }

    /**
     * Get actions
     *
     * @return Doctrine\Common\Collections\Collection $actions
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return Asset
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Get category
     *
     * @return string $category
     */
    public function getCategory()
    {
        return $this->category;
    }
    public function __construct()
    {
        $this->actions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set properties
     *
     * @param hash $properties
     * @return \Asset
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
        return $this;
    }
    public function addProperty($name, $value)
    {
        $this->properties[] = array(
            'name' => $name,
            'value' => $value
            );
        return $this;
    }

    /**
     * delete properties in specific index.
     * 
     * @param int $index
     * @return \Asset
     */
    public function deletePropertyAt($index)
    {
        unset($this->properties[$index]);
        return $this;
    }

    public function deleteProperty($name, $value)
    {
        // $found = false;
        // for($i = 0; $i < count($this->properties) ; $i++) {
        //     var_dump($this->properties);die;
        //     $property = $this->properties[$i];
        //     if($property['name'] == $name && $property['value'] == $value) {
        //         $found = true;
        //         break;
        //     }
        // }
        // if($found) unset($this->properties[$i]);
        $needle = array('name' => $name, 'value' => $value);
        $key = array_search($needle, $this->properties);
        unset($this->properties[$key]);
        return $this;
    }
    /**
     * Get properties
     *
     * @return hash $properties
     */
    public function getProperties()
    {
        return $this->properties;
    }

    public function getClass()
    {
        return get_class($this);
    }

    public function getAcquisitionDate()
    {
        return $ownershipInfo['acquisition_date'];
    }

    /**
     * Set ownershipInfo
     *
     * @param hash $ownershipInfo
     * @return \Asset
     */
    public function setOwnershipInfo($ownershipInfo)
    {
        $this->ownershipInfo = $ownershipInfo;
        return $this;
    }

    /**
     * Get ownershipInfo
     *
     * @return hash $ownershipInfo
     */
    public function getOwnershipInfo()
    {
        return $this->ownershipInfo;
    }

    /**
     * Set referenceId
     *
     * @param string $referenceId
     * @return \Asset
     */
    public function setReferenceId($referenceId)
    {
        $this->referenceId = $referenceId;
        return $this;
    }

    /**
     * Get referenceId
     *
     * @return string $referenceId
     */
    public function getReferenceId()
    {
        return $this->referenceId;
    }
}

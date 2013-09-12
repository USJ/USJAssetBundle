<?php
namespace MDB\AssetBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use MDB\AssetBundle\Validator\Constraints\UniqueAssetCode;

/**
 * @MongoDB\MappedSuperclass
 */
abstract class Asset
{
    /**
     * @MongoDB\Hash
     */
    protected $properties;

    /**
     * @MongoDB\Date
     */
    protected $createdAt;

    /**
     * @MongoDB\Date
     */
    protected $updatedAt;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $name;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $description;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $referenceId;

    /**
     * @MongoDB\Field(type="string")
     */
    protected $path;

    /**
     * @MongoDB\ReferenceOne(targetDocument="Asset")
     */
    protected $parent;

    /**
     * @MongoDB\Field(type="int")
     */
    protected $level;

    /**
     * @MongoDB\Field(type="date")
     */
    protected $lockTime;

    /**
     * @MongoDB\String
     */
    protected $category;

    /**
     * @MongoDB\String
     */
    protected $assignee;

    /**
     * @MongoDB\Collection
     */
    protected $tags = array();

    /**
     * @MongoDB\String
     * @UniqueAssetCode
     */
    protected $code;

    /**
     * @MongoDB\String
     */
    protected $oldId;

    /**
     * @MongoDB\String
     */
    protected $oldParentId;

    /**
     * @MongoDB\String
     */
    protected $manufacturer;

    /**
     * @MongoDB\String
     */
    protected $model;

    /**
     * @MongoDB\String
     */
    protected $serialnb;

    /**
     * @MongoDB\Int
     */
    protected $nbchildren;

    /**
     * have to define mapping in concrete class
     *
     * @var Location
     */
    protected $location;

    /**
     * embedded document of InOut
     */
    protected $inOut;

    protected $vendor;

    protected $logs;

    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set createdAt
     *
     * @param Date $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return Date $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param  Date  $updatedAt
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
     * @return Date $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     * @return $this
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string $createdBy
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param  string   $updatedBy
     * @return \Comment
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return string $updatedBy
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set name
     *
     * @param  string $name
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
     * @param  string $description
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
     * @param  string $path
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
     * @param  MDB\AssetBundle\Document\Asset $parent
     * @return Asset
     */
    public function setParent($parent)
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
     * @param  int   $level
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
     * @param  date  $lockTime
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
     * Set status
     *
     * @param  MDB\AssetBundle\Document\Status $status
     * @return Asset
     */
    public function setStatus($status)
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
     * Set category
     *
     * @param  string $category
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

    /**
     * Set properties
     *
     * @param  hash   $properties
     * @return \Asset
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;

        return $this;
    }

    public function setProperty($propertyId, $name = null, $value = null)
    {
        $result = array();
        foreach ($this->properties as $property) {
            if ($property['id'] == $propertyId) {
                if (!is_null($name)) {
                    $property['name'] = $name;
                }
                if (!is_null($value)) {
                    $property['value'] = $value;
                }
            }
            $result[] = $property;
        }
        $this->properties = $result;

    return $this;
    }

    public function hasProperty($name)
    {
        if (count($this->properties) < 1) {
            return false;
        }

        foreach ($this->properties as $property) {
            if ($property['name'] == $name) {
                return true;
            }
        }

        return false;
    }

    public function addProperty($name, $value)
    {
        if (!$this->hasProperty($name)) {
            $this->properties[] = array(
                'id' => uniqid(),
                'name' => $name,
                'value' => $value
            );

            return $this;
        }

        return false;
    }

    /**
     * delete properties in specific index.
     *
     * @param  int    $index
     * @return \Asset
     */
    public function deletePropertyAt($index)
    {
        unset($this->properties[$index]);

        return $this;
    }

    public function deleteProperty($id)
    {
        $key = array_search($this->getProperty($id), $this->properties);
        unset($this->properties[$key]);

        return $this;
    }

    public function getProperty($id)
    {
        foreach ($this->properties as $property) {
            if ($property['id'] == $id) {
                return $property;
            }
        }
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

    /**
     * Set referenceId
     *
     * @param  string $referenceId
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

    public function getPathIds()
    {
        $results = array();
        $ids = explode("|", $this->path);
        for ($i=0; $i < count($ids) - 1 ; $i++) {
            if ($ids[$i] == '') {
                continue;
            }
            $results[] = substr($ids[$i], -24);
        }

        return $results;
    }

    public function setAssignee($assignee)
    {
        $this->assignee = $assignee;
    }

    public function getAssignee()
    {
        return $this->assignee;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setTags($tags)
    {
        return $this->tags = $tags;
    }

    // Methods used when doing asset cloning
    public function getOldId()
    {
        return $this->oldId;
    }

    public function setOldId($oldId)
    {
        $this->oldId = $oldId;

        return $this;
    }

    /**
     * Method use in asset cloning
     */
    public function getOldParentId()
    {
        return $this->oldParentId;
    }

    /**
     * Method use in asset cloning
     */
    public function setOldParentId($oldParentId)
    {
        $this->oldParentId = $oldParentId;

        return $this;
    }

    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setSerialnb($serialnb)
    {
        $this->serialnb = $serialnb;

        return $this;
    }

    public function getSerialnb()
    {
        return $this->serialnb;
    }

    public function getNbchildren()
    {
        return $this->nbchildren;
    }

    public function setNbchildren($number)
    {
        $this->nbchildren = $number;

        return $this;
    }

    public function getVendor()
    {
        return $this->vendor;
    }

    public function setVendor($vendor)
    {
        $this->vendor = $vendor;

        return $this;
    }

    public function getInOut()
    {
        return $this->inOut;
    }

    public function setInOut($inOut)
    {
        $this->inOut = $inOut;

        return $this;
    }

}

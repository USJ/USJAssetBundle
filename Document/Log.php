<?php
namespace MDB\AssetBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\MappedSuperclass
 */
abstract class Log
{
    protected $createdBy;
    protected $createdAt;

    /**
     * @MongoDB\String
     */
    protected $type;

    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}

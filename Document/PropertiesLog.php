<?php
namespace MDB\AssetBundle\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
* @MongoDB\MappedSuperclass
*/
abstract class PropertiesLog extends GenericChangeLog
{
    /**
     * @MongoDB\String
     */
    protected $name;

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
}

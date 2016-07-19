<?php
namespace MDB\AssetBundle\Document;

/**
*/
abstract class PropertiesLog extends GenericChangeLog
{
    /**
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

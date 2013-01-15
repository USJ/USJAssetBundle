<?php 
namespace MDB\AssetBundle\Document;
 
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * For storing the properties of an asset.
 * @MongoDB\EmbeddedDocument
 */
 class AssetProperty
 {
 	/** @MongoDB\Id */
	protected $id;

 	/** @MongoDB\String */
 	protected $property;

 	/** @MongoDB\String */
 	protected $value;
 
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
     * Set property
     *
     * @param string $property
     * @return AssetProperty
     */
    public function setProperty($property)
    {
        $this->property = $property;
        return $this;
    }

    /**
     * Get property
     *
     * @return string $property
     */
    public function getProperty()
    {
        return $this->property;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return AssetProperty
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get value
     *
     * @return string $value
     */
    public function getValue()
    {
        return $this->value;
    }
}

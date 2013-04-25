<?php
namespace MDB\AssetBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
* @MongoDB\MappedSuperclass
*/
class Vendor
{
    /**
     * @MongoDB\String
     */
    protected $name;
}

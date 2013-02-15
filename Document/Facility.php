<?php 
namespace MDB\AssetBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @MongoDB\MappedSuperclass
 */
class Facility extends Asset
{
}

<?php
namespace MDB\AssetBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
* @MongoDB\MappedSuperclass
*/
abstract class TypeLog extends GenericChangeLog
{
}

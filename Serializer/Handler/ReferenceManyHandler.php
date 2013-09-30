<?php
namespace MDB\AssetBundle\Serializer\Handler;

use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\Context;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 *
 */
class ReferenceManyHandler
{
    protected $documentManager;
    protected $serializer;

    public function __construct(\Doctrine\ODM\MongoDB\DocumentManager $documentManager, $serializer)
    {
        $this->documentManager = $documentManager;
        $this->serializer = $serializer;
    }

    public function deserialize(JsonDeserializationVisitor $visitor, $json, array $type, Context $context)
    {
        $class = $type['params'][0]['name'];
        $method = $type['params'][1]['name'];
        $paramsName = array_map(function ($item) { return $item['name']; }, $type['params'][1]['params']);

        $collection = new \Doctrine\Common\Collections\ArrayCollection();
        $params = array();
        $repository = $this->documentManager->getRepository($class);

        foreach ($json as $jsonItem) {
            foreach ($paramsName as $paramName) {
                $params[] = $jsonItem[$paramName];
            }
            $document = call_user_func_array(array($repository, $method), $params);

            if (!$document) {
                throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('One or more referenced document(s) not found.');
            }

            $collection->add($document);
        }

        return $collection;
    }

    public function serialize(JsonSerializationVisitor $visitor, $data, array $type, Context $context)
    {
        $rs = array();

        $paramsName = array_map(function ($item) {
                return $item['name'];
            },
            $type['params'][1]['params']
        );

        $accessor = PropertyAccess::createPropertyAccessor();

        foreach ($data as $item) {
            $rsArr = array();
            $rsArr['id'] = $item->getId();

            foreach ($paramsName as $fieldName) {
                $rsArr[$fieldName] = $accessor->getValue($item, $fieldName);
            }

            $rs[] = $rsArr;
        }

        return $rs;
    }
}

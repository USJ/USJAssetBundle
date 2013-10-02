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
        $exclusionStrategy = $context->getExclusionStrategy();
        $class = $type['params'][0]['name'];

        $metadata = $context->getMetadataFactory()->getMetadataForClass($class);
        $rs = array();
        $accessor = PropertyAccess::createPropertyAccessor();

        if (isset($type['params'][2])) { // use serialize context is specify
            $subContext = new \JMS\Serializer\SerializationContext();
            $subContext->setGroups(array($type['params'][2]['name']));
            $context = $subContext;
        }

        foreach ($data as $object) {
            $singleRs = array();
            foreach ($metadata->propertyMetadata as $propertyMetadata) {
                if ($exclusionStrategy->shouldSkipProperty($propertyMetadata, $context)) {
                    continue;
                }

                $value = $accessor->getValue($object, $propertyMetadata->name);
                $singleRs[$propertyMetadata->name] = $value;
            }
            $rs[] = $singleRs;
        }

        return $rs;
    }
}

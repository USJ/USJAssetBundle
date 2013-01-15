<?php 
namespace MDB\AssetBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use MDB\AssetBundle\Document\Status;

class IdToStatusTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;


    public function __construct(ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
    }
    
    /**
     * transform from object to name
     * @param Status object
     * @return name string
     */
    public function transform($model) {
        if(!$model) {
            return null;
        }
        return $model->getId();
    }

    /**
     * from id to Status
     * @param name of the asset
     * @return Status object
     */ 
    public function reverseTransform($norm) {
        if(!$norm) {
            return null;
        }

        $status = $this->objectManager->getRepository("MDBAssetBundle:Status")->findOneById($norm);

        if(null === $status) {
             throw new TransformationFailedException(sprintf(
                'An status with id "%s" does not exist!',
                $norm
            ));
        }
        return $status;
    }
}

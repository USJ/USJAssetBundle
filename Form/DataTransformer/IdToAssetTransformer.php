<?php 
namespace MDB\AssetBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use MDB\AssetBundle\Document\Asset;

class IdToAssetTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (asset) to a string (name).
     *
     * @param  Asset | null $asset
     * @return string
     */
    public function transform($asset)
    {
        if (is_null($asset)) {
            return null;
        }

        return $asset->getId();
    }

    /**
     * Transforms a string (code) to an object (asset).
     *
     * @param  string $code
     * @return asset|null
     * @throws TransformationFailedException if object (asset) is not found.
     */
    public function reverseTransform($norm)
    {
        if (!$norm) {
            return;
        }
        $asset = $this->om
            ->getRepository('MDBAssetBundle:Asset')
            ->findOneById($norm);
        if(null === $asset ) {
             throw new TransformationFailedException(sprintf(
                'An asset with id "%s" does not exist!',
                $norm
            ));
        }
        return $asset;
    }

}

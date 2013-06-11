<?php
namespace MDB\AssetBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validate the asset code to make sure its uniqueness.
 */
class UniqueAssetCodeValidator extends ConstraintValidator
{
    protected $assetManager;

    public function __construct($assetManager)
    {
        $this->assetManager = $assetManager;
    }

    public function validate($value, Constraint $constraint)
    {
        $asset = $this->assetManager->findAssetByCode($value);
        $root = $this->context->getRoot();

        if ($root instanceof \Symfony\Component\Form\FormInterface) {
            $idToValidate = $root->getData()->getId();
        }

        if ($root instanceof \MDB\AssetBundle\Document\Asset) {
            $idToValidate = $root->getId();
        }

        if ($asset && $idToValidate && $asset->getId() != $idToValidate) {
            $this->context->addViolation($constraint->message, array('%code%' => $value));
        }
    }

}

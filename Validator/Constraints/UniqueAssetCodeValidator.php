<?php
namespace MDB\AssetBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
*
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
        if($asset) {
            $this->context->addViolation($constraint->message, array('%code%' => $value));
        }
    }
}

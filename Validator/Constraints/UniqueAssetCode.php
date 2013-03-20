<?php
namespace MDB\AssetBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueAssetCode extends Constraint
{
    public $message = 'Asset code %code% has been used';

    public function validatedBy()
    {
        return 'mdb_asset.unique_asset_code';
    }
}

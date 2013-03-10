<?php
namespace MDB\AssetBundle\Importer\ValueConverter;

use Ddeboer\DataImport\Exception\UnexpectedTypeException;
use Ddeboer\DataImport\ValueConverter\ValueConverterInterface;
/**
*
*/
class PropertiesConverter implements ValueConverterInterface
{

    public function convert($input)
    {
        $inputProps = explode('|', $input);
        $props = array();

        foreach($inputProps as $inputProp) {
            $propArr = explode(':', $inputProp);
            $props[$propArr[0]] = $propArr[1];
        }

        return $props;
    }

}

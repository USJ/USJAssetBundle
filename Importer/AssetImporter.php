<?php
namespace MDB\AssetBundle\Document;

use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Source\Filter\Unzip;
use Ddeboer\DataImport\ValueConverter\DateTimeValueConverter;
use Ddeboer\DataImport\Reader\CsvReader;
/**
*
*/
class AssetImporter
{
    protected $file;

    public function loadFile($file)
    {
        $this->file = $file;
    }

    public function process()
    {
        if(!$this->file instanceof \SplFileObject) {
            throw new \RuntimeException(sprintf("Expected SplFileObject but got %s", get_class($this->file)));
        }

        $workflow = new Workflow($this->file);
        // $workflow->
        return $this;
    }

    public function importToDatabase()
    {

    }
}

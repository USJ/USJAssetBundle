<?php
namespace MDB\AssetBundle\Importer;

use Ddeboer\DataImport\Workflow;
use Ddeboer\DataImport\Source\Filter\Unzip;
use Ddeboer\DataImport\ValueConverter\DateTimeValueConverter;
use Ddeboer\DataImport\Reader\CsvReader;
use Ddeboer\DataImport\Reader\ExcelReader;

use Cloudruge\AssetBundle\Document\Asset;
/**
* Main flow for doing import
*/
class AssetImporter
{
    protected $file;

    protected $data = array();

    protected $collection;

    protected $dm;

    public function __construct($dm)
    {
        $this->dm = $dm;
    }

    public function loadFile($file)
    {
        $this->file = $file;
    }

    public function process($persist = false)
    {
        $excelReader = new ExcelReader($this->file->getPathname());
        $excelReader->setHeaderRowNumber(0);

        $rows = array();
        $workflow = new Workflow($excelReader);

        $workflow->addValueConverter('PROPERTIES', new ValueConverter\PropertiesConverter());
        $workflow->addWriter(new \Ddeboer\DataImport\Writer\CallbackWriter(
            function($row) use(&$rows) {
                $rows[] = $row;
            }
        ));

        $workflow->process();
        $this->data = $rows;

        $this->collection = $this->getAssetsTree();
    }

    public function persist()
    {
        foreach ($this->collection as $item) {
            $this->dm->persist($item);
        }
        $this->dm->flush();
    }

    public function getCollection()
    {
        return $this->collection;
    }

    public function getAssetsTree()
    {
        $collection = new \Doctrine\Common\Collections\ArrayCollection();
        $parentIds = array();
        foreach ($this->data as $item) {
            $asset = new Asset();
            $asset->setName($item['ASSET_NAME']);
            $asset->setDescription($item['ASSET_DESCRIPTION']);
            $asset->setStatus($item['STATUS']);

            if(!is_null($item['PROPERTIES'])) {
                foreach ($item['PROPERTIES'] as $name => $value) {
                    $asset->addProperty($name, $value);
                }
            }

            $parentIds[$item['ROW']] = $item['PARENT_ROW_NB'];
            $collection->set($item['ROW'], $asset);
        }

        foreach ($parentIds as $row => $parent_row) {
            $assetHasParent = $collection->get($row);
            $assetHasParent->setParent($collection->get($parent_row));
        }

        foreach ($collection as $item) {
            $item->setLevel(self::calcAssetLevel($item));
            // $item->setPath(self::calcAssetPath($item));
        }
        // var_dump($collection);die;
       return $collection;
    }

    public static function calcAssetLevel($asset)
    {
        $count = 1;
        $parent = $asset->getParent();

        while(!is_null($parent)){
            $count += 1;
            $parent = $parent->getParent();
        }
        return $count;
    }

    public static function calcAssetPath($asset)
    {
        $sources = array();
        $parent = null;
        for ($i=0; $i < $asset->getLevel(); $i++) {
            if($i == 0) {
                $sources[] = $asset;
                continue;
            }
            $sources[] = $sources[$i-1]->getParent();
        }
        $sources = array_reverse($sources);
        $path = '';

        foreach ($sources as $p => $id) {
            $path .= '-'.$id.'|';
        }
        return $path;
    }

    public function getPreviewData()
    {
        return $this->data;
    }

    public function importToDatabase()
    {

    }
}

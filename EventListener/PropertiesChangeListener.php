<?php
namespace MDB\AssetBundle\EventListener;

use MDB\AssetBundle\Document\Asset;
use Doctrine\ODM\MongoDB\Event\PreUpdateEventArgs;

use MDB\AssetBundle\Document\GenericChangeLog;
/**
*
*/
class PropertiesChangeListener
{
    protected $propertiesLogClass;

    public function __construct($propertiesLogClass)
    {
        $this->propertiesLogClass = $propertiesLogClass;
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $document = $args->getDocument();

        if ($document instanceof Asset && $args->hasChangedField('properties')) {

            $dm = $args->getDocumentManager();
            // var_dump($args->getNewValue('properties'));die;
            $oldValue = $args->getOldValue('properties');
            $newValue = $args->getNewValue('properties');

            $newValue = !is_null($newValue)?$newValue:array();
            $oldValue = !is_null($oldValue)?$oldValue:array();

            if (count($oldValue) == count($newValue)) {
                $changeType = GenericChangeLog::CHANGE;
            }

            if (count($oldValue) < count($newValue)) {
                $changeType = GenericChangeLog::ADD;
            }

            if (count($oldValue) > count($newValue)) {
                $changeType = GenericChangeLog::REMOVE;
            }
// REFACTOR: This should be move to some class
            switch ($changeType) {
                case GenericChangeLog::CHANGE:
                    $props = $this->diff($oldValue, $newValue);
                    foreach ($props as $propName => $propValues) {
                        $keys = array_keys($propValues);
                        $name = $keys[0];

                        $values = array_values($propValues);

                        $propertiesLog = new $this->propertiesLogClass;
                        $propertiesLog->setName($name);
                        $propertiesLog->change($values[0]['old'],$values[0]['new']);
                        $document->addLog($propertiesLog);
                    }
                    break;

                case GenericChangeLog::ADD:
                    // find out what field added
                    $props = $this->diff($newValue,$oldValue, $changeType);
                    foreach ($props as $propName => $propValues) {
                        $keys = array_keys($propValues);
                        $name = $keys[0];

                        $values = array_values($propValues);

                        $propertiesLog = new $this->propertiesLogClass;
                        $propertiesLog->setName($name);
                        $propertiesLog->add($values[0]['new']);
                        $document->addLog($propertiesLog);
                    }
                    break;
                case GenericChangeLog::REMOVE:
                    // find out what field added
                    $props = $this->diff($oldValue, $newValue, $changeType);

                    foreach ($props as $propName => $propValues) {
                        $keys = array_keys($propValues);
                        $name = $keys[0];

                        $values = array_values($propValues);

                        $propertiesLog = new $this->propertiesLogClass;
                        $propertiesLog->setName($name);
                        $propertiesLog->remove($values[0]['old']);
                        $document->addLog($propertiesLog);
                    }
                    break;

                default:
                    # code...
                    break;
            }

            // nessessary for update
            $class = $dm->getClassMetadata(get_class($document));
            $dm->getUnitOfWork()->recomputeSingleDocumentChangeSet($class, $document);
        }
    }

    /**
     * @return array collection of changed properties
     */
    public function diff($oldArr, $newArr, $changeType = GenericChangeLog::CHANGE)
    {
        $mapOutNameValue = function($ele) {
            return $ele['name'].':'.$ele['value'];
        };
        $oldFlatArr = array_map($mapOutNameValue, $oldArr);
        $newFlatArr = array_map($mapOutNameValue, $newArr);

        $diff = array_diff($oldFlatArr, $newFlatArr);
        $keys = array_keys($diff);
        $changedProps = array();
        foreach ($keys as $key) {
            $changedProp[$oldArr[$key]['name']] =
                array(
                        'old' => isset($oldArr[$key]) ?$oldArr[$key]['value']:'',
                        'new' => isset($newArr[$key]) ?$newArr[$key]['value']:''
                    );
            if ($changeType == GenericChangeLog::ADD) {
                $changedProp[$oldArr[$key]['name']] =
                array(
                        'new' => isset($oldArr[$key]) ?$oldArr[$key]['value']:''
                );
            }
            $changedProps[$oldArr[$key]['id']] = $changedProp;
        }

        return $changedProps;
    }

}

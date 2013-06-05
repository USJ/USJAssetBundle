<?php

namespace MDB\AssetBundle\Document;

use MDB\AssetBundle\Document\Location;

class LocationManager {

    protected $dispatcher;

    protected $dm;

    protected $class;

    public function __construct($dispatcher, $dm, $class)
    {
        $this->dispatcher = $dispatcher;
        $this->dm = $dm;
        $this->class = $class;
    }

    public function createLocation()
    {
        return new $this->class;
    }

    public function saveLocation(Location $location)
    {
        $this->dm->persist($location);
        $this->dm->flush();
    }

}
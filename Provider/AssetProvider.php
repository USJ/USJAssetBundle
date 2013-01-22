<?php 

namespace MDB\AssetBundle\Provider;

use FOQ\ElasticaBundle\Provider\ProviderInterface;
use Elastica_Type;

class AssetProvider implements ProviderInterface
{
    
    public function populate(\Closure $loggerClosure = null)
    {
        if ($loggerClosure) {
            $loggerClosure('Indexing assets');
        }

        
    }
}
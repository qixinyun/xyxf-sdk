<?php
namespace Sdk\Statistical\Repository;

use Marmot\Core;

use Sdk\Statistical\Adapter\IStatisticalAdapter;
use Sdk\Statistical\Adapter\StatisticalAdapterFactory;
use Sdk\Statistical\Adapter\StatisticalRestfulAdapter;

class StatisticalRepository implements IStatisticalAdapter
{
    private $adapter;

    public function __construct(IStatisticalAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function getAdapter() : IStatisticalAdapter
    {
        return $this->adapter;
    }

    public function analyse(array $filter = array())
    {
        return $this->getAdapter()->analyse($filter);
    }
}

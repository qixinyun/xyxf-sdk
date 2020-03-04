<?php
namespace Sdk\Statistical\Adapter;

class StatisticalAdapterFactory
{
    const MAPS = array(
        'staticsEnterpriseServiceCount'=>
        'Sdk\Statistical\Adapter\StaticsEnterpriseServiceCountAdapter',
        'staticsServiceAuthenticationCount'=>
        'Sdk\Statistical\Adapter\StaticsServiceAuthenticationCountAdapter',
        'staticsServiceRequirementCount'=>
        'Sdk\Statistical\Adapter\StaticsServiceRequirementCountAdapter',
        'staticsServiceCount'=>
        'Sdk\Statistical\Adapter\StaticsServiceCountAdapter'
    );

    public function getAdapter(string $type) : IStatisticalAdapter
    {
        $adapter = isset(self::MAPS[$type]) ? self::MAPS[$type] : '';

        return class_exists($adapter) ? new $adapter : false;
    }
}

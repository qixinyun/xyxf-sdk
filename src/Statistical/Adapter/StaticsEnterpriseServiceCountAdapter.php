<?php
namespace Sdk\Statistical\Adapter;

use Marmot\Framework\Adapter\Restful\GuzzleAdapter;
use Sdk\Statistical\Model\NullStatistical;

class StaticsEnterpriseServiceCountAdapter extends GuzzleAdapter implements IStatisticalAdapter
{
    use StatisticalAdaoterTrait;

    public function analyse(array $filter = array())
    {
        $this->get(
            $this->getResource().'/staticsEnterpriseServiceCount',
            array(
                'filter'=>$filter
            )
        );

        return $this->isSuccess() ? $this->translateToObject() : NullStatistical::getInstance();
    }
}

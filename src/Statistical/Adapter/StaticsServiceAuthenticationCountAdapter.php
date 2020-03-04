<?php
namespace Sdk\Statistical\Adapter;

use Marmot\Framework\Adapter\Restful\GuzzleAdapter;
use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Statistical\Translator\StatisticalRestfulTranslator;
use Sdk\Statistical\Model\NullStatistical;

use Marmot\Core;

class StaticsServiceAuthenticationCountAdapter extends GuzzleAdapter implements IStatisticalAdapter
{
    use StatisticalAdaoterTrait;

    public function analyse(array $filter = array())
    {
        $this->get(
            $this->getResource().'/staticsServiceAuthenticationCount',
            array(
                'filter'=>$filter
            )
        );

        return $this->isSuccess() ? $this->translateToObject() : NullStatistical::getInstance();
    }
}

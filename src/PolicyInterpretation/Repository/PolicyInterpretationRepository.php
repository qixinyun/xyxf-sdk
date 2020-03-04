<?php
namespace Sdk\PolicyInterpretation\Repository;

use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\OperatAbleRepositoryTrait;
use Sdk\Common\Repository\OnShelfAbleRepositoryTrait;
use Sdk\Common\Repository\AsyncRepositoryTrait;
use Sdk\Common\Repository\ErrorRepositoryTrait;

use Sdk\PolicyInterpretation\Adapter\PolicyInterpretation\IPolicyInterpretationAdapter;
use Sdk\PolicyInterpretation\Adapter\PolicyInterpretation\PolicyInterpretationMockAdapter;
use Sdk\PolicyInterpretation\Adapter\PolicyInterpretation\PolicyInterpretationRestfulAdapter;
use Sdk\PolicyInterpretation\Model\PolicyInterpretation;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

class PolicyInterpretationRepository extends Repository implements IPolicyInterpretationAdapter
{
    use FetchRepositoryTrait,
        OperatAbleRepositoryTrait,
        OnShelfAbleRepositoryTrait,
        ErrorRepositoryTrait,
        AsyncRepositoryTrait;

    private $adapter;

    const LIST_MODEL_UN = 'POLICYINTERPRETATION_LIST';
    const FETCH_ONE_MODEL_UN = 'POLICYINTERPRETATION_FETCH_ONE';

    public function __construct()
    {
        $this->adapter = new PolicyInterpretationRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey') : []
        );
    }

    public function getActualAdapter() : IPolicyInterpretationAdapter
    {
        return $this->adapter;
    }

    public function getMockAdapter() : IPolicyInterpretationAdapter
    {
        return new PolicyInterpretationMockAdapter();
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }
}

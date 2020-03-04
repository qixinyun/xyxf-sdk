<?php
namespace Sdk\Policy\Repository;

use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\OperatAbleRepositoryTrait;
use Sdk\Common\Repository\OnShelfAbleRepositoryTrait;
use Sdk\Common\Repository\AsyncRepositoryTrait;
use Sdk\Common\Repository\ErrorRepositoryTrait;

use Sdk\Policy\Adapter\Policy\IPolicyAdapter;
use Sdk\Policy\Adapter\Policy\PolicyMockAdapter;
use Sdk\Policy\Adapter\Policy\PolicyRestfulAdapter;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

class PolicyRepository extends Repository implements IPolicyAdapter
{
    use FetchRepositoryTrait,
        OperatAbleRepositoryTrait,
        OnShelfAbleRepositoryTrait,
        ErrorRepositoryTrait,
        AsyncRepositoryTrait;

    private $adapter;

    const OA_LIST_MODEL_UN = 'OA_POLICY_LIST'; //OA列表场景
    const PORTAL_LIST_MODEL_UN = 'PORTAL_POLICY_LIST'; //门户列表场景
    const FETCH_ONE_MODEL_UN = 'POLICY_FETCH_ONE';

    public function __construct()
    {
        $this->adapter = new PolicyRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey') : []
        );
    }

    public function getActualAdapter() : IPolicyAdapter
    {
        return $this->adapter;
    }

    public function getMockAdapter() : IPolicyAdapter
    {
        return new PolicyMockAdapter();
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }
}

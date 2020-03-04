<?php
namespace Sdk\Enterprise\Repository;

use Sdk\Common\Repository\AsyncRepositoryTrait;
use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\ResubmitAbleRepositoryTrait;
use Sdk\Common\Repository\ApplyAbleRepositoryTrait;
use Sdk\Common\Repository\ErrorRepositoryTrait;

use Sdk\Enterprise\Adapter\Enterprise\IUnAuditedEnterpriseAdapter;
use Sdk\Enterprise\Adapter\Enterprise\UnAuditedEnterpriseMockAdapter;
use Sdk\Enterprise\Adapter\Enterprise\UnAuditedEnterpriseRestfulAdapter;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

class UnAuditedEnterpriseRepository extends Repository implements IUnAuditedEnterpriseAdapter
{
    use AsyncRepositoryTrait,
        FetchRepositoryTrait,
        ResubmitAbleRepositoryTrait,
        ApplyAbleRepositoryTrait,
        ErrorRepositoryTrait;

    private $adapter;

    const OA_LIST_MODEL_UN = 'OA_UNAUDITEDENTERPRISE_LIST';
    const PORTAL_LIST_MODEL_UN = 'PORTAL_UNAUDITEDENTERPRISE_LIST';
    const FETCH_ONE_MODEL_UN = 'UNAUDITEDENTERPRISE_FETCH_ONE';

    public function __construct()
    {
        $this->adapter = new UnAuditedEnterpriseRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey'):[]
        );
    }

    public function getActualAdapter() : IUnAuditedEnterpriseAdapter
    {
        return $this->adapter;
    }

    public function getMockAdapter() : IUnAuditedEnterpriseAdapter
    {
        return new UnAuditedEnterpriseMockAdapter();
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }
}

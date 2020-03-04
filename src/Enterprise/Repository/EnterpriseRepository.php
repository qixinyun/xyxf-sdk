<?php
namespace Sdk\Enterprise\Repository;

use Sdk\Common\Repository\AsyncRepositoryTrait;
use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\OperatAbleRepositoryTrait;
use Sdk\Common\Repository\ErrorRepositoryTrait;

use Sdk\Enterprise\Adapter\Enterprise\IEnterpriseAdapter;
use Sdk\Enterprise\Adapter\Enterprise\EnterpriseMockAdapter;
use Sdk\Enterprise\Adapter\Enterprise\EnterpriseRestfulAdapter;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

class EnterpriseRepository extends Repository implements IEnterpriseAdapter
{
    use AsyncRepositoryTrait,
        FetchRepositoryTrait,
        OperatAbleRepositoryTrait,
        ErrorRepositoryTrait;

    private $adapter;

    const OA_LIST_MODEL_UN = 'OA_ENTERPRISE_LIST';
    const PORTAL_LIST_MODEL_UN = 'PORTAL_ENTERPRISE_LIST';
    const FETCH_ONE_MODEL_UN = 'ENTERPRISE_FETCH_ONE';

    public function __construct()
    {
        $this->adapter = new EnterpriseRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey'):[]
        );
    }

    public function getActualAdapter() : IEnterpriseAdapter
    {
        return $this->adapter;
    }

    public function getMockAdapter() : IEnterpriseAdapter
    {
        return new EnterpriseMockAdapter();
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }
}

<?php
namespace Sdk\Service\Repository;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

use Sdk\Common\Repository\AsyncRepositoryTrait;
use Sdk\Common\Repository\ErrorRepositoryTrait;
use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\ApplyAbleRepositoryTrait;
use Sdk\Common\Repository\OperatAbleRepositoryTrait;
use Sdk\Common\Repository\ResubmitAbleRepositoryTrait;
use Sdk\Common\Repository\ModifyStatusAbleRepositoryTrait;

use Sdk\Service\Adapter\Service\IServiceAdapter;
use Sdk\Service\Adapter\Service\ServiceMockAdapter;
use Sdk\Service\Adapter\Service\ServiceRestfulAdapter;

use Sdk\Service\Model\Service;

class ServiceRepository extends Repository implements IServiceAdapter
{
    use AsyncRepositoryTrait,
        FetchRepositoryTrait,
        ApplyAbleRepositoryTrait,
        OperatAbleRepositoryTrait,
        ResubmitAbleRepositoryTrait,
        ModifyStatusAbleRepositoryTrait,
        ErrorRepositoryTrait;

    private $adapter;

    const OA_LIST_MODEL_UN = 'OA_SERVICE_LIST';
    const PORTAL_LIST_MODEL_UN = 'PORTAL_SERVICE_LIST';
    const FETCH_ONE_MODEL_UN = 'SERVICE_FETCH_ONE';

    public function __construct()
    {
        $this->adapter = new ServiceRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey') : []
        );
    }

    public function getMockAdapter(): IServiceAdapter
    {
        return new ServiceMockAdapter();
    }

    public function getActualAdapter(): IServiceAdapter
    {
        return $this->adapter;
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }

    public function onShelf(Service $service): bool
    {
        return $this->getAdapter()->onShelf($service);
    }

    public function offStock(Service $service): bool
    {
        return $this->getAdapter()->offStock($service);
    }
}

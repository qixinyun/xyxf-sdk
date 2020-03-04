<?php
namespace Sdk\ServiceRequirement\Repository;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

use Sdk\Common\Repository\ApplyAbleRepositoryTrait;
use Sdk\Common\Repository\AsyncRepositoryTrait;
use Sdk\Common\Repository\ModifyStatusAbleRepositoryTrait;
use Sdk\Common\Repository\ErrorRepositoryTrait;
use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\OperatAbleRepositoryTrait;

use Sdk\ServiceRequirement\Adapter\ServiceRequirement\IServiceRequirementAdapter;
use Sdk\ServiceRequirement\Adapter\ServiceRequirement\ServiceRequirementMockAdapter;
use Sdk\ServiceRequirement\Adapter\ServiceRequirement\ServiceRequirementRestfulAdapter;

class ServiceRequirementRepository extends Repository implements IServiceRequirementAdapter
{
    use AsyncRepositoryTrait,
        FetchRepositoryTrait,
        ApplyAbleRepositoryTrait,
        ModifyStatusAbleRepositoryTrait,
        OperatAbleRepositoryTrait,
        ErrorRepositoryTrait;

    private $adapter;

    const OA_LIST_MODEL_UN = 'OA_SERVICE_REQUIREMENT_LIST';
    const PORTAL_LIST_MODEL_UN = 'PORTAL_SERVICE_REQUIREMENT_LIST';
    const FETCH_ONE_MODEL_UN = 'SERVICE_REQUIREMENT_FETCH_ONE';

    public function __construct()
    {
        $this->adapter = new ServiceRequirementRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey') : []
        );
    }

    public function getMockAdapter(): IServiceRequirementAdapter
    {
        return new ServiceRequirementMockAdapter();
    }

    public function getActualAdapter(): IServiceRequirementAdapter
    {
        return $this->adapter;
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }
}

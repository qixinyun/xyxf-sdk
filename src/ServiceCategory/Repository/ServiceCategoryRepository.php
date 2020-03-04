<?php
namespace Sdk\ServiceCategory\Repository;

use Sdk\ServiceCategory\Adapter\ServiceCategory\ServiceCategoryRestfulAdapter;
use Sdk\ServiceCategory\Adapter\ServiceCategory\ServiceCategoryMockAdapter;
use Sdk\ServiceCategory\Adapter\ServiceCategory\IServiceCategoryAdapter;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

use Sdk\Common\Repository\AsyncRepositoryTrait;
use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\OperatAbleRepositoryTrait;
use Sdk\Common\Repository\EnableAbleRepositoryTrait;
use Sdk\Common\Repository\ErrorRepositoryTrait;

class ServiceCategoryRepository extends Repository implements IServiceCategoryAdapter
{
    use OperatAbleRepositoryTrait,
        EnableAbleRepositoryTrait,
        AsyncRepositoryTrait,
        FetchRepositoryTrait,
        ErrorRepositoryTrait;
    
    private $adapter;

    const LIST_MODEL_UN = 'SERVICECATEGORY_LIST';
    const FETCH_ONE_MODEL_UN = 'SERVICECATEGORY_FETCH_ONE';
    
    public function __construct()
    {
        $this->adapter = new ServiceCategoryRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey'):[]
        );
    }
    
    public function getActualAdapter() : IServiceCategoryAdapter
    {
        return $this->adapter;
    }

    public function getMockAdapter() : IServiceCategoryAdapter
    {
        return new ServiceCategoryMockAdapter();
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }
}

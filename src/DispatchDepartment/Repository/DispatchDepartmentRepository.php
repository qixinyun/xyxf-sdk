<?php
namespace Sdk\DispatchDepartment\Repository;

use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\OperatAbleRepositoryTrait;
use Sdk\Common\Repository\EnableAbleRepositoryTrait;
use Sdk\Common\Repository\ErrorRepositoryTrait;

use Sdk\DispatchDepartment\Adapter\DispatchDepartment\IDispatchDepartmentAdapter;
use Sdk\DispatchDepartment\Adapter\DispatchDepartment\DispatchDepartmentMockAdapter;
use Sdk\DispatchDepartment\Adapter\DispatchDepartment\DispatchDepartmentRestfulAdapter;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

class DispatchDepartmentRepository extends Repository implements IDispatchDepartmentAdapter
{
    use FetchRepositoryTrait,
        OperatAbleRepositoryTrait,
        EnableAbleRepositoryTrait,
        ErrorRepositoryTrait;

    private $adapter;

    const LIST_MODEL_UN = 'DISPATCHDEPARTMENT_LIST';
    const FETCH_ONE_MODEL_UN = 'DISPATCHDEPARTMENT_FETCH_ONE';

    public function __construct()
    {
        $this->adapter = new DispatchDepartmentRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey') : []
        );
    }

    public function getActualAdapter() : IDispatchDepartmentAdapter
    {
        return $this->adapter;
    }

    public function getMockAdapter() : IDispatchDepartmentAdapter
    {
        return new DispatchDepartmentMockAdapter();
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }
}

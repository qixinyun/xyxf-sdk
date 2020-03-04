<?php
namespace Sdk\ServiceCategory\Repository;

use Sdk\ServiceCategory\Adapter\ServiceCategory\ParentCategoryRestfulAdapter;
use Sdk\ServiceCategory\Adapter\ServiceCategory\ParentCategoryMockAdapter;
use Sdk\ServiceCategory\Adapter\ServiceCategory\IParentCategoryAdapter;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

use Sdk\Common\Repository\AsyncRepositoryTrait;
use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\OperatAbleRepositoryTrait;
use Sdk\Common\Repository\ErrorRepositoryTrait;

class ParentCategoryRepository extends Repository implements IParentCategoryAdapter
{
    use OperatAbleRepositoryTrait,
        AsyncRepositoryTrait,
        FetchRepositoryTrait,
        ErrorRepositoryTrait;
    
    private $adapter;

    const LIST_MODEL_UN = 'PARENTCATEGORY_LIST';
    const FETCH_ONE_MODEL_UN = 'PARENTCATEGORY_FETCH_ONE';
    
    public function __construct()
    {
        $this->adapter = new ParentCategoryRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey'):[]
        );
    }
    
    public function getActualAdapter() : IParentCategoryAdapter
    {
        return $this->adapter;
    }

    public function getMockAdapter() : IParentCategoryAdapter
    {
        return new ParentCategoryMockAdapter();
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }
}

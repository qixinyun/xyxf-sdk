<?php
namespace Sdk\NaturalPerson\Repository;

use Sdk\Common\Repository\AsyncRepositoryTrait;
use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\OperatAbleRepositoryTrait;
use Sdk\Common\Repository\ApplyAbleRepositoryTrait;
use Sdk\Common\Repository\ErrorRepositoryTrait;

use Sdk\NaturalPerson\Adapter\NaturalPerson\INaturalPersonAdapter;
use Sdk\NaturalPerson\Adapter\NaturalPerson\NaturalPersonMockAdapter;
use Sdk\NaturalPerson\Adapter\NaturalPerson\NaturalPersonRestfulAdapter;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

class NaturalPersonRepository extends Repository implements INaturalPersonAdapter
{
    use FetchRepositoryTrait,
        AsyncRepositoryTrait,
        OperatAbleRepositoryTrait,
        ApplyAbleRepositoryTrait,
        ErrorRepositoryTrait;

    private $adapter;

    const LIST_MODEL_UN = 'NATURALPERSON_LIST';
    const FETCH_ONE_MODEL_UN = 'NATURALPERSON_FETCH_ONE';

    public function __construct()
    {
        $this->adapter = new NaturalPersonRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey') : []
        );
    }

    public function getActualAdapter() : INaturalPersonAdapter
    {
        return $this->adapter;
    }

    public function getMockAdapter() : INaturalPersonAdapter
    {
        return new NaturalPersonMockAdapter();
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }
}

<?php
namespace Sdk\Authentication\Repository;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;
use Sdk\Authentication\Adapter\Authentication\AuthenticationMockAdapter;
use Sdk\Authentication\Adapter\Authentication\AuthenticationRestfulAdapter;
use Sdk\Authentication\Adapter\Authentication\IAuthenticationAdapter;
use Sdk\Common\Repository\AsyncRepositoryTrait;
use Sdk\Common\Repository\ErrorRepositoryTrait;
use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\OperatAbleRepositoryTrait;
use Sdk\Common\Repository\ResubmitAbleRepositoryTrait;
use Sdk\Common\Repository\ApplyAbleRepositoryTrait;

class AuthenticationRepository extends Repository implements IAuthenticationAdapter
{
    use AsyncRepositoryTrait,
        FetchRepositoryTrait,
        OperatAbleRepositoryTrait,
        ResubmitAbleRepositoryTrait,
        ApplyAbleRepositoryTrait,
        ErrorRepositoryTrait;

    const LIST_MODEL_UN = 'AUTHENTICATION_LIST';
    const FETCH_ONE_MODEL_UN = 'AUTHENTICATION_FETCH_ONE';

    private $adapter;

    public function __construct()
    {
        $this->adapter = new AuthenticationRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey') : []
        );
    }

    public function getMockAdapter(): IAuthenticationAdapter
    {
        return new AuthenticationMockAdapter();
    }

    public function getActualAdapter(): IAuthenticationAdapter
    {
        return $this->adapter;
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }
}

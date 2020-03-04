<?php
namespace Sdk\MemberAccount\Repository;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

use Sdk\Common\Repository\ErrorRepositoryTrait;
use Sdk\Common\Repository\FetchRepositoryTrait;

use Sdk\MemberAccount\Adapter\MemberAccount\IMemberAccountAdapter;
use Sdk\MemberAccount\Adapter\MemberAccount\MemberAccountMockAdapter;
use Sdk\MemberAccount\Adapter\MemberAccount\MemberAccountRestfulAdapter;

use Sdk\MemberAccount\Model\MemberAccount;

class MemberAccountRepository extends Repository implements IMemberAccountAdapter
{
    use FetchRepositoryTrait, ErrorRepositoryTrait;

    private $adapter;

    const FETCH_ONE_MODEL_UN = 'MEMBER_ACCOUNT_FETCH_ONE';

    public function __construct()
    {
        $this->adapter = new MemberAccountRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey') : []
        );
    }

    public function getMockAdapter(): IMemberAccountAdapter
    {
        return new MemberAccountMockAdapter();
    }

    public function getActualAdapter(): IMemberAccountAdapter
    {
        return $this->adapter;
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }
}

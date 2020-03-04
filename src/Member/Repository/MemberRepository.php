<?php
namespace Sdk\Member\Repository;

use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\OperatAbleRepositoryTrait;
use Sdk\Common\Repository\EnableAbleRepositoryTrait;
use Sdk\Common\Repository\AsyncRepositoryTrait;
use Sdk\Common\Repository\ErrorRepositoryTrait;

use Sdk\Member\Adapter\Member\IMemberAdapter;
use Sdk\Member\Adapter\Member\MemberMockAdapter;
use Sdk\Member\Adapter\Member\MemberRestfulAdapter;
use Sdk\Member\Model\Member;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

class MemberRepository extends Repository implements IMemberAdapter
{
    use FetchRepositoryTrait,
        AsyncRepositoryTrait,
        ErrorRepositoryTrait,
        OperatAbleRepositoryTrait,
        EnableAbleRepositoryTrait;

    private $adapter;

    const LIST_MODEL_UN = 'MEMBER_LIST';
    const FETCH_ONE_MODEL_UN = 'MEMBER_FETCH_ONE';

    public function __construct()
    {
        $this->adapter = new MemberRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey') : []
        );
    }

    public function getActualAdapter() : IMemberAdapter
    {
        return $this->adapter;
    }

    public function getMockAdapter() : IMemberAdapter
    {
        return new MemberMockAdapter();
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }

    public function signIn(Member $member) : bool
    {
        return $this->getAdapter()->signIn($member);
    }

    public function signUp(Member $member) : bool
    {
        return $this->getAdapter()->signUp($member);
    }

    public function resetPassword(Member $member) : bool
    {
        return $this->getAdapter()->resetPassword($member);
    }

    public function updatePassword(Member $member) : bool
    {
        return $this->getAdapter()->updatePassword($member);
    }

    public function updateCellphone(Member $member) : bool
    {
        return $this->getAdapter()->updateCellphone($member);
    }
}

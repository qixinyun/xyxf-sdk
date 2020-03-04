<?php
namespace Sdk\Member\Adapter\Member;

use Sdk\Common\Adapter\OperatAbleMockAdapterTrait;
use Sdk\Common\Adapter\EnableAbleMockAdapterTrait;

use Sdk\Member\Model\Member;
use Sdk\Member\Utils\MockFactory;

/**
 * 屏蔽类中所有PMD警告
 *
 * @SuppressWarnings(PHPMD)
 */
class MemberMockAdapter implements IMemberAdapter
{
    use OperatAbleMockAdapterTrait, EnableAbleMockAdapterTrait;

    public function fetchOne($id)
    {
        return MockFactory::generateMemberObject($id);
    }

    public function fetchList(array $ids) : array
    {
        $meberList = array();

        foreach ($ids as $id) {
            $meberList[] = MockFactory::generateMemberObject($id);
        }

        return $meberList;
    }

    public function search(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 20
    ) :array {
        unset($filter);
        unset($sort);

        $ids = [];

        for ($offset; $offset<$size; $offset++) {
            $ids[] = $offset;
        }

        $count = sizeof($ids);
        return array($this->fetchList($ids), $count);
    }

    public function signIn(Member $member) : bool
    {
        unset($member);
        return true;
    }

    public function signUp(Member $member) : bool
    {
        unset($member);
        return true;
    }

    public function resetPassword(Member $member) : bool
    {
        unset($member);
        return true;
    }

    public function updatePassword(Member $member) : bool
    {
        unset($member);
        return true;
    }

    public function updateCellphone(Member $member) : bool
    {
        unset($member);
        return true;
    }

    public function fetchOneAsync(int $id)
    {
        return MockFactory::generateMemberObject($id);
    }

    public function fetchListAsync(array $ids) : array
    {
        $parentCategoryList = array();

        foreach ($ids as $id) {
            $parentCategoryList[] = MockFactory::generateMemberObject($id);
        }

        return $parentCategoryList;
    }

    public function searchAsync(
        array $filter = array(),
        array $sort = array(),
        int $offset = 0,
        int $size = 20
    ) :array {
        unset($filter);
        unset($sort);

        $ids = [];

        for ($offset; $offset<$size; $offset++) {
            $ids[] = $offset;
        }

        $count = sizeof($ids);
        return array($this->fetchList($ids), $count);
    }
}

<?php
namespace Sdk\Authentication\Adapter\Authentication;

use Sdk\Common\Adapter\OperatAbleMockAdapterTrait;
use Sdk\Common\Adapter\ResubmitAbleMockAdapterTrait;
use Sdk\Common\Adapter\ApplyAbleMockAdapterTrait;

use Sdk\Authentication\Model\Authentication;
use Sdk\Authentication\Utils\MockFactory;

class AuthenticationMockAdapter implements IAuthenticationAdapter
{
    use OperatAbleMockAdapterTrait, ResubmitAbleMockAdapterTrait, ApplyAbleMockAdapterTrait;

    public function fetchOne($id)
    {
        return MockFactory::generateAuthenticationObject($id);
    }

    public function fetchList(array $ids) : array
    {
        $authenticationList = array();

        foreach ($ids as $id) {
            $authenticationList[] = MockFactory::generateAuthenticationObject($id);
        }

        return $authenticationList;
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

    public function fetchOneAsync(int $id)
    {
        return MockFactory::generateAuthenticationObject($id);
    }

    public function fetchListAsync(array $ids) : array
    {
        $parentCategoryList = array();

        foreach ($ids as $id) {
            $parentCategoryList[] = MockFactory::generateAuthenticationObject($id);
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

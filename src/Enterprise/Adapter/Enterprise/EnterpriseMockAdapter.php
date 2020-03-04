<?php
namespace Sdk\Enterprise\Adapter\Enterprise;

use Sdk\Common\Adapter\OperatAbleMockAdapterTrait;

use Sdk\Enterprise\Model\Enterprise;
use Sdk\Enterprise\Model\NullEnterprise;
use Sdk\Enterprise\Utils\EnterpriseMockFactory;

class EnterpriseMockAdapter implements IEnterpriseAdapter
{
    use OperatAbleMockAdapterTrait;

    public function fetchOne($id)
    {
        return EnterpriseMockFactory::generateEnterpriseObject(NullEnterprise::getInstance(), $id);
    }

    public function fetchList(array $ids) : array
    {
        $enterpriseList = array();

        foreach ($ids as $id) {
            $enterpriseList[] = EnterpriseMockFactory::generateEnterpriseObject(NullEnterprise::getInstance(), $id);
        }

        return $enterpriseList;
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
        return EnterpriseMockFactory::generateEnterpriseObject(NullEnterprise::getInstance(), $id);
    }

    public function fetchListAsync(array $ids) : array
    {
        $parentCategoryList = array();

        foreach ($ids as $id) {
            $parentCategoryList[] = EnterpriseMockFactory::generateEnterpriseObject(NullEnterprise::getInstance(), $id);
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

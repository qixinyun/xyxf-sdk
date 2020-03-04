<?php
namespace Sdk\Enterprise\Adapter\Enterprise;

use Sdk\Common\Adapter\ApplyAbleMockAdapterTrait;

use Sdk\Common\Model\IResubmitAble;

use Sdk\Enterprise\Model\UnAuditedEnterprise;
use Sdk\Enterprise\Utils\UnAuditedEnterpriseMockFactory;

class UnAuditedEnterpriseMockAdapter implements IUnAuditedEnterpriseAdapter
{
    use ApplyAbleMockAdapterTrait;

    public function fetchOne($id)
    {
        return UnAuditedEnterpriseMockFactory::generateUnAuditedEnterpriseObject($id);
    }

    public function fetchList(array $ids) : array
    {
        $unAuditedEnterpriseList = array();

        foreach ($ids as $id) {
            $unAuditedEnterpriseList[] = UnAuditedEnterpriseMockFactory::generateUnAuditedEnterpriseObject($id);
        }

        return $unAuditedEnterpriseList;
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
    /**
     * [resubmitAction 重新认证]
     * @param  UnAuditedEnterprise $unAuditedEnterprise [认证信息对象]
     * @return [bool]                                   [返回类型]
     */
    public function resubmit(IResubmitAble $unAuditedEnterprise) : bool
    {
        unset($unAuditedEnterprise);
        return true;
    }

    public function fetchOneAsync(int $id)
    {
        return UnAuditedEnterpriseMockFactory::generateUnAuditedEnterpriseObject($id);
    }

    public function fetchListAsync(array $ids) : array
    {
        $parentCategoryList = array();

        foreach ($ids as $id) {
            $parentCategoryList[] = UnAuditedEnterpriseMockFactory::generateUnAuditedEnterpriseObject($id);
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

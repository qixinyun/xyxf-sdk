<?php
namespace Sdk\Common\Model;

use Sdk\Common\Adapter\IModifyStatusAbleAdapter;

use Marmot\Core;

trait ModifyStatusAbleTrait
{
    /**
     * 撤销
     * @return bool 是否撤销成功
     */
    public function revoke() : bool
    {
        if (!$this->isPending() || !$this->isNormal()) {
            Core::setLastError(RESOURCE_STATUS_NOT_PENDING);
            return false;
        }
        $modifyStatusAdapter = $this->getIModifyStatusAbleAdapter();
        return $modifyStatusAdapter->revoke($this);
    }

    /**
     * 关闭
     * @return bool 是否关闭成功
     */
    public function close() : bool
    {
        if (!$this->isApprove() || !$this->isNormal()) {
            Core::setLastError(RESOURCE_STATUS_NOT_NORMAL);
            return false;
        }
        $modifyStatusAdapter = $this->getIModifyStatusAbleAdapter();
        return $modifyStatusAdapter->close($this);
    }

    /**
     * 删除
     * @return bool 是否删除成功
     */
    public function deletes() : bool
    {
        if (!$this->isReject() && !$this->isRevoked() && !$this->isClosed()) {
            Core::setLastError(RESOURCE_STATUS_NOT_REJECT);
            return false;
        }
        $modifyStatusAdapter = $this->getIModifyStatusAbleAdapter();
        return $modifyStatusAdapter->deletes($this);
    }

    abstract protected function getIModifyStatusAbleAdapter() : IModifyStatusAbleAdapter;

    public function setStatus(int $status)
    {
        $this->status = in_array($status, array_values(self::STATUS)) ? $status : self::STATUS['DELETED'];
    }

    public function isNormal() : bool
    {
        return $this->getStatus() == self::STATUS['NORMAL'];
    }

    public function isRevoked() : bool
    {
        return $this->getStatus() == self::STATUS['REVOKED'];
    }

    public function isClosed() : bool
    {
        return $this->getStatus() == self::STATUS['CLOSED'];
    }

    public function isPending() : bool
    {
        return $this->getApplyStatus() == self::APPLY_STATUS['PENDING'];
    }

    public function isApprove() : bool
    {
        return $this->getApplyStatus() == self::APPLY_STATUS['APPROVE'];
    }

    public function isReject() : bool
    {
        return $this->getApplyStatus() == self::APPLY_STATUS['REJECT'];
    }
}

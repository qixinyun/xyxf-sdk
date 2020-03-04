<?php
namespace Sdk\Common\Model;

use Sdk\Common\Adapter\IEnableAbleAdapter;

trait EnableAbleTrait
{
    /**
     * 启用
     * @return bool 是否启用成功
     */
    public function enable() : bool
    {
        if (!$this->isDisabled()) {
            return false;
        }
        $enableAdapter = $this->getIEnableAbleAdapter();
        return $enableAdapter->enable($this);
    }

    /**
     * 禁用
     * @return bool 是否禁用成功
     */
    public function disable() : bool
    {
        if (!$this->isEnabled()) {
            return false;
        }
        $enableAdapter = $this->getIEnableAbleAdapter();
        return $enableAdapter->disable($this);
    }

    abstract protected function getIEnableAbleAdapter() : IEnableAbleAdapter;

    public function setStatus(int $status)
    {
        $this->status = in_array($status, array_values(self::STATUS)) ? $status : self::STATUS['DISABLED'];
    }

    public function isEnabled() : bool
    {
        return $this->getStatus() == self::STATUS['ENABLED'];
    }

    public function isDisabled() : bool
    {
        return $this->getStatus() == self::STATUS['DISABLED'];
    }
}

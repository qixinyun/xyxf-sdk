<?php
namespace Sdk\Common\Model;

use Sdk\Common\Adapter\IOnShelfAbleAdapter;

trait OnShelfAbleTrait
{
    /**
     * 设置状态
     * @param int $status 状态
     */
    public function setStatus(int $status)
    {
        $this->status = in_array($status, array_values(self::STATUS)) ? $status : self::STATUS['OFFSTOCK'];
    }
    /**
     * 上架
     * @return bool 是否上架成功
     */
    public function onShelf() : bool
    {
        if (!$this->isOffStock()) {
            return false;
        }

        $onShelfAddapter = $this->getIOnShelfAbleAdapter();
        return $onShelfAddapter->onShelf($this);
    }

    /**
     * 下架
     * @return bool 是否下架成功
     */
    public function offStock() : bool
    {
        if (!$this->isOnShelf()) {
            return false;
        }

        $onShelfAddapter = $this->getIOnShelfAbleAdapter();
        return $onShelfAddapter->offStock($this);
    }

    abstract protected function getIOnShelfAbleAdapter() : IOnShelfAbleAdapter;

    public function isOnShelf() : bool
    {
        return $this->getStatus() == self::STATUS['ONSHELF'];
    }

    public function isOffStock() : bool
    {
        return $this->getStatus() == self::STATUS['OFFSTOCK'];
    }
}

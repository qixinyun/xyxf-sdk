<?php
namespace Sdk\DeliveryAddress\Model;

use Marmot\Core;
use Marmot\Common\Model\IObject;
use Marmot\Common\Model\Object;

use Sdk\Common\Model\IOperatAble;
use Sdk\Common\Model\OperatAbleTrait;
use Sdk\Common\Adapter\IOperatAbleAdapter;

use Sdk\Common\Model\IModifyStatusAble;
use Sdk\Common\Model\ModifyStatusAbleTrait;
use Sdk\Common\Adapter\IModifyStatusAbleAdapter;

use Sdk\Member\Model\Member;

use Sdk\DeliveryAddress\Repository\DeliveryAddressRepository;

class DeliveryAddress implements IObject, IOperatAble, IModifyStatusAble
{
    use Object, OperatAbleTrait, ModifyStatusAbleTrait;

    const IS_DEFAULT_ADDRESS = [
        'NO' => 0,
        'YES' => 2
    ];

    private $id;

    private $area;
    
    private $address;

    private $postalCode;

    private $realName;

    private $cellphone;

    private $isDefaultAddress;

    private $member;

    private $repository;

    public function __construct(int $id = 0)
    {
        $this->id = $id;
        $this->area = '';
        $this->address = '';
        $this->postalCode = '000000';
        $this->realName = '';
        $this->cellphone = '';
        $this->isDefaultAddress = self::IS_DEFAULT_ADDRESS['NO'];
        $this->member = Core::$container->has('user') ? Core::$container->get('user') : new Member();
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->status = self::STATUS['NORMAL'];
        $this->statusTime = 0;
        $this->repository = new DeliveryAddressRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->area);
        unset($this->address);
        unset($this->postalCode);
        unset($this->realName);
        unset($this->cellphone);
        unset($this->isDefaultAddress);
        unset($this->member);
        unset($this->createTime);
        unset($this->updateTime);
        unset($this->status);
        unset($this->statusTime);
        unset($this->repository);
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setArea(string $area) : void
    {
        $this->area = $area;
    }

    public function getArea() : string
    {
        return $this->area;
    }

    public function setAddress(string $address) : void
    {
        $this->address = $address;
    }

    public function getAddress() : string
    {
        return $this->address;
    }

    public function setPostalCode(string $postalCode) : void
    {
        $this->postalCode = $postalCode;
    }

    public function getPostalCode() : string
    {
        return $this->postalCode;
    }

    public function setRealName(string $realName) : void
    {
        $this->realName = $realName;
    }

    public function getRealName() : string
    {
        return $this->realName;
    }

    public function setCellphone(string $cellphone) : void
    {
        $this->cellphone = $cellphone;
    }

    public function getCellphone() : string
    {
        return $this->cellphone;
    }

    public function setIsDefaultAddress(int $isDefaultAddress) : void
    {
        $this->isDefaultAddress = in_array($isDefaultAddress, array_values(self::IS_DEFAULT_ADDRESS)) ?
            $isDefaultAddress : self::IS_DEFAULT_ADDRESS['NO'];
    }

    public function getIsDefaultAddress() : int
    {
        return $this->isDefaultAddress;
    }

    public function setMember(Member $member) : void
    {
        $this->member = $member;
    }

    public function getMember() : Member
    {
        return $this->member;
    }

    protected function getRepository(): DeliveryAddressRepository
    {
        return $this->repository;
    }

    protected function getIOperatAbleAdapter(): IOperatAbleAdapter
    {
        return $this->getRepository();
    }

    protected function getIModifyStatusAbleAdapter(): IModifyStatusAbleAdapter
    {
        return $this->getRepository();
    }
    /**
     * 设为默认地址
     * @return bool 是否设置成功
     */
    public function setDefault(): bool
    {
        if (!$this->defaultIsNormal()) {
            Core::setLastError(RESOURCE_STATUS_NOT_NORMAL);
            return false;
        }
        return $this->getRepository()->setDefault($this);
    }

    public function defaultIsNormal() : bool
    {
        return $this->getIsDefaultAddress() == self::IS_DEFAULT_ADDRESS['NO'];
    }

    /**
     * 删除
     * @return bool 是否删除成功
     */
    public function deletes() : bool
    {
        if (!$this->isNormal()) {
            Core::setLastError(RESOURCE_STATUS_NOT_NORMAL);
            return false;
        }
        $modifyStatusAdapter = $this->getIModifyStatusAbleAdapter();
        return $modifyStatusAdapter->deletes($this);
    }
}

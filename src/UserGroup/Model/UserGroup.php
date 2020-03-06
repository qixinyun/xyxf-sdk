<?php
namespace Sdk\UserGroup\Model;

use Sdk\Common\Model\IOperatAble;
use Sdk\Common\Model\OperatAbleTrait;

use Marmot\Common\Model\IObject;
use Marmot\Common\Model\Object;
use Marmot\Core;

// use Purview\Model\IPurviewAble;
// use Purview\Model\PurviewAbleTrait;

use Sdk\UserGroup\Repository\UserGroupRepository;

class UserGroup implements IObject, IOperatAble
{
    use Object, OperatAbleTrait;
    // use Object, PurviewAbleTrait, OperatAbleTrait;
    
    const STATUS_NORMAL = 0;
    const STATUS_DELETE = -2;

    private $id;

    private $name;

    private $shortName;
    /**
     * @var array $jurisdictionColumns 管辖栏目
     */
    private $jurisdictionColumns;

    private $administrativeArea;

    private $repository;

    public function __construct(int $id = 0)
    {
        $this->id = !empty($id) ? $id : 0;
        $this->name = '';
        $this->shortName = '';
        $this->jurisdictionColumns = array();
        $this->administrativeArea = NullUserGroupCategory::getInstance();
        $this->status = self::STATUS_NORMAL;
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->statusTime = 0;
        $this->repository = new UserGroupRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->name);
        unset($this->shortName);
        unset($this->jurisdictionColumns);
        unset($this->administrativeArea);
        unset($this->status);
        unset($this->createTime);
        unset($this->updateTime);
        unset($this->statusTime);
        unset($this->repository);
    }

    public function setId($id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setShortName(string $shortName) : void
    {
        $this->shortName = $shortName;
    }

    public function getShortName() : string
    {
        return $this->shortName;
    }

    public function addJurisdictionColumn(JurisdictionColumn $jurisdictionColumn) : void
    {
        $this->jurisdictionColumns[] = $jurisdictionColumn;
    }

    public function clearJurisdictionColumns() : void
    {
        $this->jurisdictionColumns = [];
    }

    public function getJurisdictionColumns() : array
    {
        return $this->jurisdictionColumns;
    }
    
    public function setAdministrativeArea(UserGroupCategory $administrativeArea) : void
    {
        $this->administrativeArea = $administrativeArea;
    }

    public function getAdministrativeArea() : UserGroupCategory
    {
        return $this->administrativeArea;
    }

    public function setStatus(int $status) : void
    {
        $this->status= in_array(
            $status,
            array(
                self::STATUS_NORMAL,
                self::STATUS_DELETE
            )
        ) ? $status : self::STATUS_NORMAL;
    }

    public function getRepository() : UserGroupRepository
    {
        return $this->repository;
    }

    protected function getIOperatAbleRepository() : UserGroupRepository
    {
        return $this->getRepository();
    }

    public function getColumn(): int
    {
        return IPurviewAble::COLUMN['SYSTEM_MANAGE'];
    }

    public function isPermit(): bool
    {
        if (Core::$container->get('user')->getId() == IPurviewAble::SUPER_ADMINISTRATOR_ID) {
            return true;
        }

        return false;
    }

    protected function getIOperatAbleAdapter() : IOperatAbleAdapter
    {
        return $this->getRepository();
    }
}

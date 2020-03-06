<?php
namespace Sdk\Crew\Model;

use Marmot\Core;
use Marmot\Common\Model\Object;

class Role
{
    use Object;

    const STATUS_NORMAL = 0;
    const STATUS_DELETE = -2;

    const PUBLISHER = 2;
    const AUDITOR = 1;

    //角色暂时不存储在数据库, 这里使用常量来定义角色
    const ROLES = array(
        self::PUBLISHER=>'发布角色',
        self::AUDITOR=>'审批角色'
    );

    private $id;

    private $name;

    public function __construct(int $id = 0)
    {
        $this->id = isset(self::ROLES[$id]) ? $id : 0;
        $this->name = isset(self::ROLES[$id]) ? self::ROLES[$id] : '';
        $this->createTime = Core::$container->get('time');
        $this->status = self::STATUS_NORMAL;
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->name);
        unset($this->createTime);
        unset($this->status);
    }

    public function setId(int $id) : void
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

    public function isPublisher() : bool
    {
        return $this->getId() == self::PUBLISHER;
    }

    public function isAuditor() : bool
    {
        return $this->getId() == self::AUDITOR;
    }
}

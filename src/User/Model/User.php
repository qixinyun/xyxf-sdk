<?php
namespace Sdk\User\Model;

use Marmot\Core;
use Marmot\Framework\Classes\Server;
use Marmot\Common\Model\IObject;
use Marmot\Common\Model\Object;

use Sdk\Common\Model\IEnableAble;
use Sdk\Common\Model\IOperatAble;
use Sdk\Common\Model\EnableAbleTrait;
use Sdk\Common\Model\OperatAbleTrait;
use Sdk\Common\Adapter\IEnableAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;

abstract class User implements IObject, IEnableAble, IOperatAble
{
    use Object, EnableAbleTrait, OperatAbleTrait;

    const GENDER = array(
        "GENDER_NULL" => 0,
        "GENDER_MALE" => 1,
        "GENDER_FEMALE" => 2
    );
    /**
     * [$id 主键Id]
     * @var [int]
     */
    protected $id;
    /**
     * [$cellphone 手机号]
     * @var [string]
     */
    protected $cellphone;
    /**
     * [$realName 真实姓名]
     * @var [string]
     */
    protected $realName;
    /**
     * [$userName 用户名]
     * @var [string]
     */
    protected $userName;
    /**
     * [$password 密码]
     * @var [string]
     */
    protected $password;
    /**
     * [$oldPassword 旧密码]
     * @var [string]
     */
    protected $oldPassword;
    /**
     * [$avatar 头像]
     * @var [array]
     */
    protected $avatar;
    /**
     * [$gender 性别]
     * @var [int]
     */
    protected $gender;
    /**
     * [$identify 登录标识]
     * @var [string]
     */
    private $identify;

    public function __construct(int $id = 0)
    {
        $this->id = $id;
        $this->cellphone = '';
        $this->realName = '';
        $this->userName = '';
        $this->password = '';
        $this->oldPassword = '';
        $this->avatar = array();
        $this->gender = self::GENDER['GENDER_MALE'];
        $this->identify = '';
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->status = IEnableAble::STATUS['ENABLED'];
        $this->statusTime = 0;
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->cellphone);
        unset($this->realName);
        unset($this->userName);
        unset($this->password);
        unset($this->oldPassword);
        unset($this->avatar);
        unset($this->gender);
        unset($this->identify);
        unset($this->createTime);
        unset($this->updateTime);
        unset($this->status);
        unset($this->statusTime);
    }

    public function setId($id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setCellphone(string $cellphone) : void
    {
        $this->cellphone = is_numeric($cellphone) ? $cellphone : '';
    }

    public function getCellphone() : string
    {
        return $this->cellphone;
    }

    public function setRealName(string $realName) : void
    {
        $this->realName = $realName;
    }

    public function getRealName() : string
    {
        return $this->realName;
    }

    public function setUserName(string $userName) : void
    {
        $this->userName = $userName;
    }

    public function getUserName() : string
    {
        return $this->userName;
    }

    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function setOldPassword(string $oldPassword) : void
    {
        $this->oldPassword = $oldPassword;
    }

    public function getOldPassword() : string
    {
        return $this->oldPassword;
    }
    
    public function setAvatar(array $avatar) : void
    {
        $this->avatar = $avatar;
    }

    public function getAvatar() : array
    {
        return $this->avatar;
    }

    public function setGender(int $gender) : void
    {
        $this->gender = $gender;
    }

    public function getGender() : int
    {
        return $this->gender;
    }

    public function setIdentify(string $identify) : void
    {
        $this->identify = $identify;
    }

    public function getIdentify() : string
    {
        return $this->identify;
    }
    /**
     * [generateIdentify 生成登录标识]
     * @return [string]  [返回类型]
     */
    public function generateIdentify() : string
    {
        $this->identify = md5(serialize(Server::get('marmot')).Core::$container->get('time'));

        return $this->identify;
    }

    /**
     * 登录
     * @return [bool]
     */
    public function signIn() : bool
    {
        return $this->getRepository()->signIn($this);
    }
    /**
     * 注册
     * @return [bool]
     */
    public function signUp() : bool
    {
        return $this->getRepository()->signUp($this);
    }
    /**
     * 忘记密码
     * @return [bool]
     */
    public function resetPassword() : bool
    {
        return $this->getRepository()->resetPassword($this);
    }
    /**
     * 修改密码
     * @return [bool]
     */
    public function updatePassword() : bool
    {
        return $this->getRepository()->updatePassword($this);
    }
    /**
     * 修改手机号
     * @return [bool]
     */
    public function updateCellphone() : bool
    {
        return $this->getRepository()->updateCellphone($this);
    }
    /**
     * 启用禁用
     * @return [bool]
     */
    protected function getIEnableAbleAdapter() : IEnableAbleAdapter
    {
        return $this->getRepository();
    }
    /**
     * 新增编辑
     * @return [bool]
     */
    protected function getIOperatAbleAdapter() : IOperatAbleAdapter
    {
        return $this->getRepository();
    }

    abstract protected function getRepository();
}

<?php
namespace Sdk\User\Model;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Sdk\Common\Model\IEnableAble;

class UserTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(User::class)
        ->getMockForAbstractClass();
    }

    public function tearDown()
    {
        unset($this->stub);
    }

    /**
     * User 公共用户类,测试构造函数
     */
    public function testUserConstructor()
    {
        $this->assertEquals(0, $this->stub->getId());
        $this->assertEmpty($this->stub->getCellphone());
        $this->assertEmpty($this->stub->getRealName());
        $this->assertEmpty($this->stub->getUserName());
        $this->assertEmpty($this->stub->getPassword());
        $this->assertEmpty($this->stub->getOldPassword());
        $this->assertEquals(array(), $this->stub->getAvatar());
        $this->assertEquals(User::GENDER['GENDER_MALE'], $this->stub->getGender());
        $this->assertEquals(IEnableAble::STATUS['ENABLED'], $this->stub->getStatus());
        $this->assertEquals(0, $this->stub->getCreateTime());
        $this->assertEquals(0, $this->stub->getUpdateTime());
        $this->assertEquals(0, $this->stub->getStatusTime());
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 User setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $this->stub->setId(1);
        $this->assertEquals(1, $this->stub->getId());
    }

    /**
     * 设置 User setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetIdWrongTypeButNumeric()
    {
        $this->stub->setId('1');
        $this->assertTrue(is_int($this->stub->getId()));
        $this->assertEquals(1, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end

    //Cellphone 测试 ---------------------------------------------------------- start
    /**
     * 设置 User setCellphone() 正确的传参类型,期望传值正确
     */
    public function testSetCellphoneCorrectType()
    {
        $this->stub->setCellphone('13232434343');
        $this->assertEquals('13232434343', $this->stub->getCellphone());
    }

    /**
     * 设置 User setCellphone() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetCellphoneWrongType()
    {
        $this->stub->setCellphone(array(1, 2, 3));
    }
    //Cellphone 测试 ----------------------------------------------------------   end

    //RealName 测试 ---------------------------------------------------------- start
    /**
     * 设置 User setRealName() 正确的传参类型,期望传值正确
     */
    public function testSetRealNameCorrectType()
    {
        $this->stub->setRealName('string');
        $this->assertEquals('string', $this->stub->getRealName());
    }

    /**
     * 设置 User setRealName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetRealNameWrongType()
    {
        $this->stub->setRealName(array(1, 2, 3));
    }
    //RealName 测试 ----------------------------------------------------------   end

    //UserName 测试 ---------------------------------------------------------- start
    /**
     * 设置 User setUserName() 正确的传参类型,期望传值正确
     */
    public function testSetUserNameCorrectType()
    {
        $this->stub->setUserName('string');
        $this->assertEquals('string', $this->stub->getUserName());
    }

    /**
     * 设置 User setUserName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetUserNameWrongType()
    {
        $this->stub->setUserName(array(1, 2, 3));
    }
    //UserName 测试 ----------------------------------------------------------   end

    //Password 测试 ---------------------------------------------------------- start
    /**
     * 设置 User setPassword() 正确的传参类型,期望传值正确
     */
    public function testSetPasswordCorrectType()
    {
        $this->stub->setPassword('string');
        $this->assertEquals('string', $this->stub->getPassword());
    }

    /**
     * 设置 User setPassword() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetPasswordWrongType()
    {
        $this->stub->setPassword(array(1, 2, 3));
    }
    //Password 测试 ----------------------------------------------------------   end

    //OldPassword 测试 ---------------------------------------------------------- start
    /**
     * 设置 User setOldPassword() 正确的传参类型,期望传值正确
     */
    public function testSetOldPasswordCorrectType()
    {
        $this->stub->setOldPassword('string');
        $this->assertEquals('string', $this->stub->getOldPassword());
    }

    /**
     * 设置 User setOldPassword() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetOldPasswordWrongType()
    {
        $this->stub->setOldPassword(array(1, 2, 3));
    }
    //OldPassword 测试 ----------------------------------------------------------   end

    //Avatar 测试 ---------------------------------------------------------- start
    /**
     * 设置 User setAvatar() 正确的传参类型,期望传值正确
     */
    public function testSetAvatarCorrectType()
    {
        $this->stub->setAvatar(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->stub->getAvatar());
    }

    /**
     * 设置 User setAvatar() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetAvatarWrongType()
    {
        $this->stub->setAvatar('string');
    }
    //Avatar 测试 ----------------------------------------------------------   end

    //Gender 测试 ---------------------------------------------------------- start
    /**
     * 设置 User setGender() 正确的传参类型,期望传值正确
     */
    public function testSetGenderCorrectType()
    {
        $this->stub->setGender(User::GENDER['GENDER_MALE']);
        $this->assertEquals(User::GENDER['GENDER_MALE'], $this->stub->getGender());
    }

    /**
     * 设置 User setGender() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetGenderWrongType()
    {
        $this->stub->setGender('string');
    }
    //Gender 测试 ----------------------------------------------------------   end
}

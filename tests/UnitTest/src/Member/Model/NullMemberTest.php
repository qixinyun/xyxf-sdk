<?php
namespace Sdk\Member\Model;

use PHPUnit\Framework\TestCase;
use Marmot\Core;

class NullMemberTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = NullMember::getInstance();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        unset($this->stub);
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function testExtendsMember()
    {
        $this->assertInstanceof('Sdk\Member\Model\Member', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Interfaces\INull', $this->stub);
    }
    public function testUpdatePassword()
    {
        $result = $this->stub->updatePassword();

        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }

    public function testSignIn()
    {
        $result = $this->stub->signIn();

        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }

    public function testSignUp()
    {
        $result = $this->stub->signUp();

        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }

    public function testResetPassword()
    {
        $result = $this->stub->resetPassword();

        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }

    public function testUpdateCellphone()
    {
        $result = $this->stub->updateCellphone();

        $this->assertFalse($result);
        $this->assertEquals(RESOURCE_NOT_EXIST, Core::getLastError()->getId());
    }
}

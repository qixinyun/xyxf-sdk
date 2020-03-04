<?php
namespace Sdk\MemberAccount\Model;

use PHPUnit\Framework\TestCase;
use Marmot\Core;

class NullMemberAccountTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = NullMemberAccount::getInstance();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        unset($this->stub);
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function testExtendsMemberAccount()
    {
        $this->assertInstanceof('Sdk\MemberAccount\Model\MemberAccount', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Interfaces\INull', $this->stub);
    }
}

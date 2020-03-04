<?php
namespace Sdk\Enterprise\Model;

use PHPUnit\Framework\TestCase;
use Marmot\Core;

class NullUnAuditedEnterpriseTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = NullUnAuditedEnterprise::getInstance();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        unset($this->stub);
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function testExtendsEnterprise()
    {
        $this->assertInstanceof('Sdk\Enterprise\Model\UnAuditedEnterprise', $this->stub);
    }

    public function testImplementsNull()
    {
        $this->assertInstanceof('Marmot\Interfaces\INull', $this->stub);
    }
}

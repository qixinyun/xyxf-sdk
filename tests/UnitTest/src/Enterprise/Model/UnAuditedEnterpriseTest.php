<?php
namespace Sdk\Enterprise\Model;

use Sdk\Enterprise\Repository\UnAuditedEnterpriseRepository;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class UnAuditedEnterpriseTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(UnAuditedEnterprise::class)
            ->setMethods([
                'getRepository'
            ])->getMock();

        $this->childStub = new Class extends UnAuditedEnterprise{
            public function getRepository() : UnAuditedEnterpriseRepository
            {
                return parent::getRepository();
            }
        };
    }

    public function tearDown()
    {
        unset($this->stub);
        unset($this->childStub);
    }

    public function testGetRepository()
    {
        $this->assertInstanceOf(
            'Sdk\Enterprise\Repository\UnAuditedEnterpriseRepository',
            $this->childStub->getRepository()
        );
    }

    public function testExtendsEnterpriseCommon()
    {
        $this->assertInstanceOf('Sdk\Enterprise\Model\Enterprise', $this->stub);
    }

    //rejectReason 测试 ---------------------------------------------------------- start
    /**
     * 设置 UnAuditedEnterprise setRejectReason() 正确的传参类型,期望传值正确
     */
    public function testSetRejectReasonCorrectType()
    {
        $this->stub->setRejectReason('string');
        $this->assertEquals('string', $this->stub->getRejectReason());
    }

    /**
     * 设置 UnAuditedEnterprise setRejectReason() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetRejectReasonWrongType()
    {
        $this->stub->setRejectReason(array(1, 2, 3));
    }
    //rejectReason 测试 ----------------------------------------------------------   end
}

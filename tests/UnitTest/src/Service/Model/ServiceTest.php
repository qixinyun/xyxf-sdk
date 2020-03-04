<?php
namespace Sdk\Service\Model;

use Sdk\Service\Repository\ServiceRepository;
use Sdk\Enterprise\Model\Enterprise;
use Sdk\ServiceCategory\Model\ServiceCategory;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Marmot\Core;

class ServiceTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(Service::class)
            ->setMethods([
                'getRepository'
            ])->getMock();

        $this->childStub = new Class extends Service{
            public function getRepository() : ServiceRepository
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
            'Sdk\Service\Repository\ServiceRepository',
            $this->childStub->getRepository()
        );
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 Service setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $this->stub->setId(1);
        $this->assertEquals(1, $this->stub->getId());
    }

    /**
     * 设置 Service setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetIdWrongTypeButNumeric()
    {
        $this->stub->setId('1');
        $this->assertEquals(1, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end

    //title 测试 ---------------------------------------------------------- start
    /**
     * 设置 Service setTitle() 正确的传参类型,期望传值正确
     */
    public function testSetTitleCorrectType()
    {
        $this->stub->setTitle('Service');
        $this->assertEquals('Service', $this->stub->getTitle());
    }

    /**
     * 设置 Service setTitle() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetTitleWrongType()
    {
        $this->stub->setTitle(array(1, 2, 3));
    }
    //title 测试 ----------------------------------------------------------   end
    
    //detail 测试 ---------------------------------------------------------- start
    /**
     * 设置 Service setDetail() 正确的传参类型,期望传值正确
     */
    public function testSetDetailCorrectType()
    {
        $this->stub->setDetail(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->stub->getDetail());
    }

    /**
     * 设置 Service setDetail() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetDetailWrongType()
    {
        $this->stub->setDetail('string');
    }
    //detail 测试 ----------------------------------------------------------   end
    
    //cover 测试 ---------------------------------------------------------- start
    /**
     * 设置 Service setCover() 正确的传参类型,期望传值正确
     */
    public function testSetCoverCorrectType()
    {
        $this->stub->setCover(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->stub->getCover());
    }

    /**
     * 设置 Service setCover() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetCoverWrongType()
    {
        $this->stub->setCover('string');
    }
    //cover 测试 ----------------------------------------------------------   end

    //minPrice 测试 ---------------------------------------------------------- start
    /**
     * 设置 Service setMinPrice() 正确的传参类型,期望传值正确
     */
    public function testSetMinPriceCorrectType()
    {
        $this->stub->setMinPrice(1.01);
        $this->assertEquals(1.01, $this->stub->getMinPrice());
    }

    /**
     * 设置 Service setMinPrice() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetMinPriceWrongTypeButNumeric()
    {
        $this->stub->setMinPrice('1');
        $this->assertEquals(1, $this->stub->getMinPrice());
    }
    //minPrice 测试 ----------------------------------------------------------   end

    //price 测试 ---------------------------------------------------------- start
    /**
     * 设置 Service setPrice() 正确的传参类型,期望传值正确
     */
    public function testSetPriceCorrectType()
    {
        $this->stub->setPrice(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->stub->getPrice());
    }

    /**
     * 设置 Service setPrice() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetPriceWrongType()
    {
        $this->stub->setPrice('string');
    }
    //price 测试 ----------------------------------------------------------   end

    //MaxPrice 测试 ---------------------------------------------------------- start
    /**
     * 设置 Service setMaxPrice() 正确的传参类型,期望传值正确
     */
    public function testSetMaxPriceCorrectType()
    {
        $this->stub->setMaxPrice(10000.01);
        $this->assertEquals(10000.01, $this->stub->getMaxPrice());
    }

    /**
     * 设置 Service setMaxPrice() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetMaxpriceWrongTypeButNumeric()
    {
        $this->stub->setMaxPrice('1');
        $this->assertEquals(1, $this->stub->getMaxPrice());
    }
    //MaxPrice 测试 ----------------------------------------------------------   end
    
    //contract 测试 ---------------------------------------------------------- start
    /**
     * 设置 Service setContract() 正确的传参类型,期望传值正确
     */
    public function testSetContractCorrectType()
    {
        $this->stub->setContract(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->stub->getContract());
    }

    /**
     * 设置 Service setContract() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetContractWrongType()
    {
        $this->stub->setContract('string');
    }
    //contract 测试 ----------------------------------------------------------   end
    
    //serviceObjects 测试 ---------------------------------------------------------- start
    /**
     * 设置 Service setServiceObjects() 正确的传参类型,期望传值正确
     */
    public function testSetServiceObjectsCorrectType()
    {
        $this->stub->setServiceObjects(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->stub->getServiceObjects());
    }

    /**
     * 设置 Service setServiceObjects() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetServiceObjectsWrongType()
    {
        $this->stub->setServiceObjects('string');
    }
    //serviceObjects 测试 ----------------------------------------------------------   end
    
    //volume 测试 ---------------------------------------------------------- start
    /**
     * 设置 Service setVolume() 正确的传参类型,期望传值正确
     */
    public function testSetVolumeCorrectType()
    {
        $this->stub->setVolume(1);
        $this->assertEquals(1, $this->stub->getVolume());
    }

    /**
     * 设置 Service setVolume() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetVolumeWrongTypeButNumeric()
    {
        $this->stub->setVolume('1');
        $this->assertEquals(1, $this->stub->getVolume());
    }
    //volume 测试 ----------------------------------------------------------   end

    //rejectReason 测试 ---------------------------------------------------------- start
    /**
     * 设置 Service setRejectReason() 正确的传参类型,期望传值正确
     */
    public function testSetRejectReasonCorrectType()
    {
        $this->stub->setRejectReason('string');
        $this->assertEquals('string', $this->stub->getRejectReason());
    }

    /**
     * 设置 Service setRejectReason() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetRejectReasonWrongType()
    {
        $this->stub->setRejectReason(array(1, 2, 3));
    }
    //rejectReason 测试 ----------------------------------------------------------   end
    
    //serviceCategory 测试 -------------------------------------------------------- start
    /**
     * 设置 Service setServiceCategory() 正确的传参类型,期望传值正确
     */
    public function testSetServiceCategoryCorrectType()
    {
        $object = new ServiceCategory();
        $this->stub->setServiceCategory($object);
        $this->assertSame($object, $this->stub->getServiceCategory());
    }

    /**
     * 设置 Service setServiceCategory() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetServiceCategoryType()
    {
        $this->stub->setServiceCategory(array(1,2,3));
    }
    //serviceCategory 测试 -------------------------------------------------------- end

    //enterprise 测试 -------------------------------------------------------- start
    /**
     * 设置 Service setEnterprise() 正确的传参类型,期望传值正确
     */
    public function testSetEnterpriseCorrectType()
    {
        $object = new Enterprise();
        $this->stub->setEnterprise($object);
        $this->assertSame($object, $this->stub->getEnterprise());
    }

    /**
     * 设置 Service setEnterprise() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetEnterpriseType()
    {
        $this->stub->setEnterprise(array(1,2,3));
    }
    //enterprise 测试 -------------------------------------------------------- end
    
    public function testOnShelfFailure()
    {
        $repository = $this->prophesize(ServiceRepository::class);
        $repository->onShelf(Argument::exact($this->stub))->shouldBeCalledTimes(0)->willReturn(false);

        $result = $this->stub->onShelf();
        $this->assertFalse($result);
    }

    public function testOffStockSuccess()
    {
        $repository = $this->prophesize(ServiceRepository::class);
        $repository->offStock(Argument::exact($this->stub))->shouldBeCalledTimes(1)->willReturn(true);

        $this->stub->expects($this->exactly(1))
            ->method('getRepository')
            ->willReturn($repository->reveal());

        $result = $this->stub->offStock();
        $this->assertTrue($result);
    }
}

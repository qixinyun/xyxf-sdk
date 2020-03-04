<?php
namespace Sdk\PolicyInterpretation\Model;

use Sdk\PolicyInterpretation\Repository\PolicyInterpretationRepository;
use Sdk\Crew\Model\Crew;
use Sdk\Policy\Model\Policy;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Marmot\Core;

class PolicyInterpretationTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(PolicyInterpretation::class)
            ->setMethods([
                'getRepository'
            ])->getMock();

        $this->childStub = new Class extends PolicyInterpretation{
            public function getRepository() : PolicyInterpretationRepository
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
            'Sdk\PolicyInterpretation\Repository\PolicyInterpretationRepository',
            $this->childStub->getRepository()
        );
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 PolicyInterpretation setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $this->stub->setId(1);
        $this->assertEquals(1, $this->stub->getId());
    }

    /**
     * 设置 PolicyInterpretation setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetIdWrongTypeButNumeric()
    {
        $this->stub->setId('1');
        $this->assertEquals(1, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end

    //policy 测试 ---------------------------------------------------------- start
    /**
     * 设置 PolicyInterpretation setPolicy() 正确的传参类型,期望传值正确
     */
    public function testSetPolicyCorrectType()
    {
        $object = new Policy();
        $this->stub->setPolicy($object);
        $this->assertEquals($object, $this->stub->getPolicy());
    }
    /**
     * 设置 PolicyInterpretation setPolicy() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetPolicyWrongType()
    {
        $this->stub->setPolicy(array(1,2,3));
    }
    //policy 测试 ---------------------------------------------------------- end

    //conver 测试 ------------------------------------------------------- start
     /**
     * 设置 PolicyInterpretation setCover() 正确的传参类型,期望传值正确
     */
    public function testSetCoverCorrectType()
    {
        $this->stub->setCover(array(1,2,3));
        $this->assertEquals(array(1,2,3), $this->stub->getCover());
    }

    /**
     * 设置 PolicyInterpretation setCover() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetCoverWrongType()
    {
        $this->stub->setCover('string');
    }
    //conver 测试 ------------------------------------------------------- end
    
    //title 测试 ---------------------------------------------------------- start
    /**
     * 设置 PolicyInterpretation setTitle() 正确的传参类型,期望传值正确
     */
    public function testSetTitleCorrectType()
    {
        $this->stub->setTitle('string');
        $this->assertEquals('string', $this->stub->getTitle());
    }

    /**
     * 设置 PolicyInterpretation setTitle() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetTitleWrongType()
    {
        $this->stub->setTitle(array(1, 2, 3));
    }
    //title 测试 ----------------------------------------------------------   end

    //detail 测试 ------------------------------------------------------- start
     /**
      * 设置 Policy setDetail() 正确的传参类型,期望传值正确
      */
    public function testSetDetailCorrectType()
    {
        $this->stub->setDetail(array());
        $this->assertEquals(array(), $this->stub->getDetail());
    }

    /**
     * 设置 Policy setDetail() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetDetailWrongType()
    {
        $this->stub->setDetail('detail');
    }
    //detail 测试 -------------------------------------------------------   end
    
    //description 测试 ------------------------------------------------------- start
    /**
     * 设置 Policy setDescription() 正确的传参类型,期望传值正确
     */
    public function testSetDescriptionCorrectType()
    {
        $this->stub->setDescription('string');
        $this->assertEquals('string', $this->stub->getDescription());
    }

    /**
     * 设置 Policy setDescription() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetDescriptionWrongType()
    {
        $this->stub->setDescription(array(1,2,3));
    }
    //description 测试 -------------------------------------------------------   end

    //attachments 测试 ------------------------------------------------------- start
     /**
     * 设置 Policy setAttachments() 正确的传参类型,期望传值正确
     */
    public function testSetAttachmentsCorrectType()
    {
        $this->stub->setAttachments(array(1,2,3));
        $this->assertEquals(array(1,2,3), $this->stub->getAttachments());
    }

    /**
     * 设置 Policy setAttachments() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetAttachmentsWrongType()
    {
        $this->stub->setAttachments('string');
    }
    //attachments 测试 ------------------------------------------------------- end

    //crew 测试 -------------------------------------------------------- start
    /**
     * 设置 Crew setCrew() 正确的传参类型,期望传值正确
     */
    public function testSetCrewCorrectType()
    {
        $object = new Crew();
        $this->stub->setCrew($object);
        $this->assertEquals($object, $this->stub->getCrew());
    }

    /**
     * 设置 Crew setCrew() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetCrewType()
    {
        $this->stub->setCrew(array(1,2,3));
    }
    //crew 测试 -------------------------------------------------------- end
}

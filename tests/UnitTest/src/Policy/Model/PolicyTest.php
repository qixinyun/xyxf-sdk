<?php
namespace Sdk\Policy\Model;

use Sdk\Policy\Repository\PolicyRepository;

use Sdk\DispatchDepartment\Model\DispatchDepartment;

use Sdk\Label\Model\Label;

use Sdk\Crew\Model\Crew;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Marmot\Core;

class PolicyTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(Policy::class)
            ->setMethods([
                'getRepository'
            ])->getMock();

        $this->childStub = new Class extends Policy{
            public function getRepository() : PolicyRepository
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
            'Sdk\Policy\Repository\PolicyRepository',
            $this->childStub->getRepository()
        );
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 Policy setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {
        $this->stub->setId(1);
        $this->assertEquals(1, $this->stub->getId());
    }

    /**
     * 设置 Policy setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetIdWrongTypeButNumeric()
    {
        $this->stub->setId('1');
        $this->assertEquals(1, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end
    
    //title 测试 ---------------------------------------------------------- start
    /**
     * 设置 Policy setTitle() 正确的传参类型,期望传值正确
     */
    public function testSetTitleCorrectType()
    {
        $this->stub->setTitle('string');
        $this->assertEquals('string', $this->stub->getTitle());
    }

    /**
     * 设置 Policy setTitle() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetTitleWrongType()
    {
        $this->stub->setTitle(array(1, 2, 3));
    }
    //title 测试 ----------------------------------------------------------   end
    
    //number
    // 测试 ---------------------------------------------------------- start
    /**
     * 设置 Policy setNumber() 正确的传参类型,期望传值正确
     */
    public function testSetNumberCorrectType()
    {
        $this->stub->setNumber('string');
        $this->assertEquals('string', $this->stub->getNumber());
    }

    /**
     * 设置 Policy setNumber() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetNumberWrongType()
    {
        $this->stub->setNumber(array(1, 2, 3));
    }
    //number
    // 测试 ----------------------------------------------------------   end
    
    //applicableObjects 测试 ------------------------------------------------------- start
    /**
    * 设置 Policy setApplicableObjects() 正确的传参类型,期望传值正确
    */
    public function testSetApplicableObjectsCorrectType()
    {
        $this->stub->setApplicableObjects(array(1,2,3));
        $this->assertEquals(array(1,2,3), $this->stub->getApplicableObjects());
    }

    /**
    * 设置 Policy setApplicableObjects() 错误的传参类型,期望期望抛出TypeError exception
    *
    * @expectedException TypeError
    */
    public function testSetApplicableObjectsWrongType()
    {
        $this->stub->setApplicableObjects('string');
    }
    //applicableObjects 测试 ------------------------------------------------------- end

    //dispatchDepartment 测试 ------------------------------------------------------- start
    /**
    * 设置 Policy addDispatchDepartments() 正确的传参类型,期望传值正确
    */
    public function testAddDispatchDepartmentCorrectType()
    {
        $dispatchDepartment = new DispatchDepartment();
        $this->stub->addDispatchDepartment($dispatchDepartment);
        $this->assertEquals(array($dispatchDepartment), $this->stub->getDispatchDepartments());
    }

    /**
    * 设置 Policy addDispatchDepartments() 错误的传参类型,期望期望抛出TypeError exception
    *
    * @expectedException TypeError
    */
    public function testAddDispatchDepartmentsWrongType()
    {
        $this->stub->addDispatchDepartment('string');
    }
    //dispatchDepartment 测试 ------------------------------------------------------- end

    //applicableIndustries 测试 ------------------------------------------------------- start
    /**
    * 设置 Policy setApplicableIndustries() 正确的传参类型,期望传值正确
    */
    public function testSetApplicableIndustriesCorrectType()
    {
        $this->stub->setApplicableIndustries(array(1,2,3));
        $this->assertEquals(array(1,2,3), $this->stub->getApplicableIndustries());
    }

     /**
      * 设置 Policy setApplicableIndustries() 错误的传参类型,期望期望抛出TypeError exception
      *
      * @expectedException TypeError
      */
    public function testSetApplicableIndustriesWrongType()
    {
        $this->stub->setApplicableIndustries('string');
    }
     //applicableIndustries 测试 ------------------------------------------------------- end

    //level 测试 ------------------------------------------------------- start
     /**
     * 设置 Policy setLevel() 正确的传参类型,期望传值正确
     */
    public function testSetevelCorrectType()
    {
        $object = new PolicyCategory(0, '');
        $this->stub->setLevel($object);
        $this->assertSame($object, $this->stub->getLevel());
    }

    /**
     * 设置 Policy setLevel() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetLevelWrongType()
    {
        $this->stub->setLevel('string');
    }
    //level 测试 ------------------------------------------------------- end

    //classifies 测试 ------------------------------------------------------- start
     /**
     * 设置 Policy setClassifies() 正确的传参类型,期望传值正确
     */
    public function testSetClassifiesCorrectType()
    {
        $this->stub->setClassifies(array(1,2,3));
        $this->assertEquals(array(1,2,3), $this->stub->getClassifies());
    }

    /**
     * 设置 Policy setClassifies() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetClassifiesWrongType()
    {
        $this->stub->setClassifies('string');
    }
    //classifies 测试 ------------------------------------------------------- end

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

    //image 测试 ------------------------------------------------------- start
     /**
     * 设置 Policy setImage() 正确的传参类型,期望传值正确
     */
    public function testSetImageCorrectType()
    {
        $this->stub->setImage(array(1,2,3));
        $this->assertEquals(array(1,2,3), $this->stub->getImage());
    }

    /**
     * 设置 Policy setImage() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetImageWrongType()
    {
        $this->stub->setImage('string');
    }
    //image 测试 ------------------------------------------------------- end

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

    //labels 测试 ------------------------------------------------------- start
    /**
    * 设置 Policy addLabels() 正确的传参类型,期望传值正确
    */
    public function testAddLabelCorrectType()
    {
        $label = new Label();
        $this->stub->addLabel($label);
        $this->assertEquals(array($label), $this->stub->getLabels());
    }

    /**
    * 设置 Policy addLabels() 错误的传参类型,期望期望抛出TypeError exception
    *
    * @expectedException TypeError
    */
    public function testAddLabelsWrongType()
    {
        $this->stub->addLabel('string');
    }
    //labels 测试 ------------------------------------------------------- end

    //admissibleAddress 测试 ------------------------------------------------------- start
    /**
    * 设置 Policy setAdmissibleAddress() 正确的传参类型,期望传值正确
    */
    public function testSetAdmissibleAddressCorrectType()
    {
        $this->stub->setAdmissibleAddress(array(1,2,3));
        $this->assertEquals(array(1,2,3), $this->stub->getAdmissibleAddress());
    }

    /**
    * 设置 Policy setAdmissibleAddress() 错误的传参类型,期望期望抛出TypeError exception
    *
    * @expectedException TypeError
    */
    public function testSetAdmissibleAddressWrongType()
    {
        $this->stub->setAdmissibleAddress('string');
    }
    //admissibleAddress 测试 ------------------------------------------------------- end

    //processingFlow 测试 ------------------------------------------------------- start
    /**
    * 设置 Policy setProcessingFlow() 正确的传参类型,期望传值正确
    */
    public function testSetProcessingFlowCorrectType()
    {
        $this->stub->setProcessingFlow(array(1,2,3));
        $this->assertEquals(array(1,2,3), $this->stub->getProcessingFlow());
    }

    /**
    * 设置 Policy setProcessingFlow() 错误的传参类型,期望期望抛出TypeError exception
    *
    * @expectedException TypeError
    */
    public function testSetProcessingFlowWrongType()
    {
        $this->stub->setProcessingFlow('string');
    }
    //processingFlow 测试 ------------------------------------------------------- end

    //crew 测试 -------------------------------------------------------- start
    /**
     * 设置 Policy setCrew() 正确的传参类型,期望传值正确
     */
    public function testSetCrewCorrectType()
    {
        $object = new Crew();
        $this->stub->setCrew($object);
        $this->assertSame($object, $this->stub->getCrew());
    }

    /**
     * 设置 Policy setCrew() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetCrewType()
    {
        $this->stub->setCrew(array(1,2,3));
    }
    //crew 测试 -------------------------------------------------------- end
}

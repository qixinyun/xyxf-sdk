<?php
namespace Sdk\Enterprise\Model;

use Sdk\Member\Model\Member;

use Sdk\Enterprise\Repository\EnterpriseRepository;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class EnterpriseTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(Enterprise::class)
            ->setMethods([
                'getRepository'
            ])->getMock();

        $this->childStub = new Class extends Enterprise{
            public function getRepository() : EnterpriseRepository
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
            'Sdk\Enterprise\Repository\EnterpriseRepository',
            $this->childStub->getRepository()
        );
    }

    //id 测试 ---------------------------------------------------------- start
    /**
     * 设置 EnterpriseCommon setId() 正确的传参类型,期望传值正确
     */
    public function testSetIdCorrectType()
    {

        $this->stub->setId(1);
        $this->assertEquals(1, $this->stub->getId());
    }

    /**
     * 设置 EnterpriseCommon setId() 错误的传参类型.但是传参是数值,期望返回类型正确,值正确.
     */
    public function testSetIdWrongTypeButNumeric()
    {
        $this->stub->setId('1');
        $this->assertEquals(1, $this->stub->getId());
    }
    //id 测试 ----------------------------------------------------------   end
    
    //name 测试 ---------------------------------------------------------- start
    /**
     * 设置 EnterpriseCommon setName() 正确的传参类型,期望传值正确
     */
    public function testSetNameCorrectType()
    {
        $this->stub->setName('string');
        $this->assertEquals('string', $this->stub->getName());
    }

    /**
     * 设置 EnterpriseCommon setName() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetNameWrongType()
    {
        $this->stub->setName(array(1, 2, 3));
    }
    //name 测试 ----------------------------------------------------------   end
    
    //unifiedSocialCreditCode 测试 ---------------------------------------------------------- start
    /**
     * 设置 EnterpriseCommon setUnifiedSocialCreditCode() 正确的传参类型,期望传值正确
     */
    public function testSetUnifiedSocialCreditCodeCorrectType()
    {
        $this->stub->setUnifiedSocialCreditCode('string');
        $this->assertEquals('string', $this->stub->getUnifiedSocialCreditCode());
    }

    /**
     * 设置 EnterpriseCommon setUnifiedSocialCreditCode() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetUnifiedSocialCreditCodeWrongType()
    {
        $this->stub->setUnifiedSocialCreditCode(array(1, 2, 3));
    }
    //unifiedSocialCreditCode 测试 ----------------------------------------------------------   end

    //logo 测试 ---------------------------------------------------------- start
    /**
     * 设置 EnterpriseCommon setLogo() 正确的传参类型,期望传值正确
     */
    public function testSetLogoCorrectType()
    {
        $this->stub->setLogo(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->stub->getLogo());
    }

    /**
     * 设置 EnterpriseCommon setLogo() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetLogoWrongType()
    {
        $this->stub->setLogo('string');
    }
    //logo 测试 ----------------------------------------------------------   end

    //contactsInfo 测试 ---------------------------------------------------------- start
    /**
     * 设置 EnterpriseCommon setContactsInfo() 正确的传参类型,期望传值正确
     */
    public function testSetContactsInfoCorrectType()
    {
        $contactsInfo = new ContactsInfo();
        $this->stub->setContactsInfo($contactsInfo);
        $this->assertEquals($contactsInfo, $this->stub->getContactsInfo());
    }

    /**
     * 设置 EnterpriseCommon setContactsInfo() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetContactsInfoWrongType()
    {
        $this->stub->setContactsInfo(array(1, 2, 3));
    }
    //contactsInfo 测试 ----------------------------------------------------------   end

    //businessLicense 测试 ---------------------------------------------------------- start
    /**
     * 设置 EnterpriseCommon setBusinessLicense() 正确的传参类型,期望传值正确
     */
    public function testSetBusinessLicenseCorrectType()
    {
        $this->stub->setBusinessLicense(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->stub->getBusinessLicense());
    }

    /**
     * 设置 EnterpriseCommon setBusinessLicense() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetBusinessLicenseWrongType()
    {
        $this->stub->setBusinessLicense('string');
    }
    //businessLicense 测试 ----------------------------------------------------------   end

    //setPowerAttorney 测试 ---------------------------------------------------------- start
    /**
     * 设置 EnterpriseCommon setPowerAttorney() 正确的传参类型,期望传值正确
     */
    public function testSetPowerAttorneyCorrectType()
    {
        $this->stub->setPowerAttorney(array(1, 2, 3));
        $this->assertEquals(array(1, 2, 3), $this->stub->getPowerAttorney());
    }

    /**
     * 设置 EnterpriseCommon setPowerAttorney() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetPowerAttorneyWrongType()
    {
        $this->stub->setPowerAttorney('string');
    }
    //setPowerAttorney 测试 ----------------------------------------------------------   end

    //legalPersonInfo 测试 ---------------------------------------------------------- start
    /**
     * 设置 EnterpriseCommon setLegalPersonInfo() 正确的传参类型,期望传值正确
     */
    public function testSetLegalPersonInfoCorrectType()
    {
        $legalPersonInfo = new LegalPersonInfo();
        $this->stub->setLegalPersonInfo($legalPersonInfo);
        $this->assertEquals($legalPersonInfo, $this->stub->getLegalPersonInfo());
    }

    /**
     * 设置 EnterpriseCommon setLegalPersonInfo() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetLegalPersonInfoWrongType()
    {
        $this->stub->setLegalPersonInfo(array(1, 2, 3));
    }
    //legalPersonInfo 测试 ----------------------------------------------------------   end

    //member 测试 ---------------------------------------------------------- start
    /**
     * 设置 EnterpriseCommon setMember() 正确的传参类型,期望传值正确
     */
    public function testSetMemberCorrectType()
    {
        $member = new Member();
        $this->stub->setMember($member);
        $this->assertEquals($member, $this->stub->getMember());
    }

    /**
     * 设置 EnterpriseCommon setMember() 错误的传参类型,期望期望抛出TypeError exception
     *
     * @expectedException TypeError
     */
    public function testSetMemberWrongType()
    {
        $this->stub->setMember(array(1, 2, 3));
    }
    //member 测试 ----------------------------------------------------------   end
}

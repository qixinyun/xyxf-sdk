<?php
namespace Sdk\Enterprise\Translator;

use Sdk\Enterprise\Model\NullUnAuditedEnterprise;
use Sdk\Enterprise\Model\UnAuditedEnterprise;
use Sdk\Enterprise\Model\ContactsInfo;
use Sdk\Enterprise\Model\LegalPersonInfo;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Sdk\Member\Translator\MemberRestfulTranslator;
use Sdk\Member\Model\Member;

class UnAuditedEnterpriseRestfulTranslatorTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(
            UnAuditedEnterpriseRestfulTranslator::class
        )
            ->setMethods(['getMemberRestfulTranslator'])
            ->getMock();

        $this->childStub =
        new class extends UnAuditedEnterpriseRestfulTranslator {
            public function getMemberRestfulTranslator() : MemberRestfulTranslator
            {
                return parent::getMemberRestfulTranslator();
            }
        };
    }

    public function testGetMemberRestfulTranslator()
    {
        $this->assertInstanceOf(
            'Sdk\Member\Translator\MemberRestfulTranslator',
            $this->childStub->getMemberRestfulTranslator()
        );
    }

    public function testArrayToObjectIncorrectObject()
    {
        $result = $this->stub->arrayToObject(array(), new UnAuditedEnterprise());
        $this->assertInstanceOf('Sdk\Enterprise\Model\UnAuditedEnterprise', $result);
    }

    public function setMethods(UnAuditedEnterprise $expectObject, array $attributes, array $relationships)
    {
        $enterprise = new EnterpriseRestfulTranslatorTest();

        $expectObject = $enterprise->setMethods($expectObject, $attributes, $relationships);

        if (isset($attributes['rejectReason'])) {
            $expectObject->setRejectReason($attributes['rejectReason']);
        }
        
        return $expectObject;
    }

    public function testArrayToObjectCorrectObject()
    {
        $unAuditedEnterprise = \Sdk\Enterprise\Utils\UnAuditedEnterpriseMockFactory::generateUnAuditedEnterpriseArray();

        $data =  $unAuditedEnterprise['data'];
        $relationships = $data['relationships'];

        $member = new Member($relationships['member']['data']['id']);
        $memberRestfulTranslator = $this->prophesize(MemberRestfulTranslator::class);
        $memberRestfulTranslator->arrayToObject(Argument::exact($relationships['member']))
            ->shouldBeCalledTimes(1)->willReturn($member);

        $this->stub->expects($this->exactly(1))
            ->method('getMemberRestfulTranslator')
            ->willReturn($memberRestfulTranslator->reveal());

        $actual = $this->stub->arrayToObject($unAuditedEnterprise);

        $expectObject = new UnAuditedEnterprise();

        $expectObject->setId($data['id']);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        $expectObject = $this->setMethods($expectObject, $attributes, $relationships);

        $this->assertEquals($expectObject, $actual);
    }

    public function testArrayToObjects()
    {
        $result = $this->stub->arrayToObjects(array());
        $this->assertEquals(array(0,array()), $result);
    }

    public function testArrayToObjectsOneCorrectObject()
    {
        $unAuditedEnterprise = \Sdk\Enterprise\Utils\UnAuditedEnterpriseMockFactory::generateUnAuditedEnterpriseArray();

        $data =  $unAuditedEnterprise['data'];
        $relationships = $data['relationships'];

        $member = new Member($relationships['member']['data']['id']);
        $memberRestfulTranslator = $this->prophesize(MemberRestfulTranslator::class);
        $memberRestfulTranslator->arrayToObject(Argument::exact($relationships['member']))
            ->shouldBeCalledTimes(1)->willReturn($member);

        $this->stub->expects($this->exactly(1))
            ->method('getMemberRestfulTranslator')
            ->willReturn($memberRestfulTranslator->reveal());

        $actual = $this->stub->arrayToObjects($unAuditedEnterprise);

        $expectArray = array();

        $expectObject = new UnAuditedEnterprise();

        $expectObject->setId($data['id']);

        $attributes = isset($data['attributes']) ? $data['attributes'] : '';

        $expectObject = $this->setMethods($expectObject, $attributes, $relationships);

        $expectArray = [1, [$data['id']=>$expectObject]];

        $this->assertEquals($expectArray, $actual);
    }

    /**
     * 如果传参错误对象, 期望返回空数组
     */
    public function testObjectToArrayIncorrectObject()
    {
        $result = $this->stub->objectToArray(null);
        $this->assertEquals(array(), $result);
    }
    /**
     * 传参正确对象, 返回对应数组
     */
    public function testObjectToArrayCorrectObject()
    {
        $unAuditedEnterprise =
            \Sdk\Enterprise\Utils\UnAuditedEnterpriseMockFactory::generateUnAuditedEnterpriseObject(1, 1);

        $actual = $this->stub->objectToArray($unAuditedEnterprise, array(
            'name',
            'unifiedSocialCreditCode',
            'logo',
            'businessLicense',
            'powerAttorney',
            'contactsName',
            'contactsCellphone',
            'contactsArea',
            'contactsAddress',
            'legalPersonName',
            'legalPersonCardId',
            'legalPersonPositivePhoto',
            'legalPersonReversePhoto',
            'legalPersonHandheldPhoto',
            'rejectReason',
            'member'
        ));

        $expectedArray = array(
            'data'=>array(
                'type'=>'unAuditedEnterprises'
            )
        );

        $expectedArray['data']['attributes'] = array(
            'name' => $unAuditedEnterprise->getName(),
            'unifiedSocialCreditCode' => $unAuditedEnterprise->getUnifiedSocialCreditCode(),
            'logo' => $unAuditedEnterprise->getLogo(),
            'businessLicense' => $unAuditedEnterprise->getBusinessLicense(),
            'powerAttorney' => $unAuditedEnterprise->getPowerAttorney(),
            'contactsName' => $unAuditedEnterprise->getContactsInfo()->getName(),
            'contactsCellphone' => $unAuditedEnterprise->getContactsInfo()->getCellphone(),
            'contactsArea' => $unAuditedEnterprise->getContactsInfo()->getArea(),
            'contactsAddress' => $unAuditedEnterprise->getContactsInfo()->getAddress(),
            'legalPersonName' => $unAuditedEnterprise->getLegalPersonInfo()->getName(),
            'legalPersonCardId' => $unAuditedEnterprise->getLegalPersonInfo()->getCardId(),
            'legalPersonPositivePhoto' => $unAuditedEnterprise->getLegalPersonInfo()->getPositivePhoto(),
            'legalPersonReversePhoto' => $unAuditedEnterprise->getLegalPersonInfo()->getReversePhoto(),
            'legalPersonHandheldPhoto' => $unAuditedEnterprise->getLegalPersonInfo()->getHandheldPhoto(),
            'rejectReason' => $unAuditedEnterprise->getRejectReason()
        );

        $this->assertEquals($expectedArray, $actual);
    }
}

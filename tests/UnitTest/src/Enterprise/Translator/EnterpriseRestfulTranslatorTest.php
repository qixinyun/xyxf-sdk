<?php
namespace Sdk\Enterprise\Translator;

use Sdk\Enterprise\Model\NullEnterprise;
use Sdk\Enterprise\Model\EnterpriseCommon;
use Sdk\Enterprise\Model\Enterprise;
use Sdk\Enterprise\Model\ContactsInfo;
use Sdk\Enterprise\Model\LegalPersonInfo;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Sdk\Member\Translator\MemberRestfulTranslator;
use Sdk\Member\Model\Member;

class EnterpriseRestfulTranslatorTest extends TestCase
{
    private $stub;
    private $childStub;

    public function setUp()
    {
        $this->stub = $this->getMockBuilder(
            EnterpriseRestfulTranslator::class
        )
            ->setMethods(['getMemberRestfulTranslator'])
            ->getMock();

        $this->childStub =
        new class extends EnterpriseRestfulTranslator {
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
        $result = $this->stub->arrayToObject(array(), new Enterprise());
        $this->assertInstanceOf('Sdk\Enterprise\Model\Enterprise', $result);
    }

    public function setMethods(Enterprise $expectObject, array $attributes, array $relationships)
    {
        if (isset($attributes['name'])) {
            $expectObject->setName($attributes['name']);
        }
        if (isset($attributes['unifiedSocialCreditCode'])) {
            $expectObject->setUnifiedSocialCreditCode($attributes['unifiedSocialCreditCode']);
        }
        if (isset($attributes['logo'])) {
            $expectObject->setLogo($attributes['logo']);
        }
        if (isset($attributes['businessLicense'])) {
            $expectObject->setBusinessLicense($attributes['businessLicense']);
        }
        if (isset($attributes['powerAttorney'])) {
            $expectObject->setPowerAttorney($attributes['powerAttorney']);
        }

        $contactsName = isset($attributes['contactsName'])
        ? $attributes['contactsName']
        : '';
        $contactsCellphone = isset($attributes['contactsCellphone'])
        ? $attributes['contactsCellphone']
        : '';
        $contactsArea = isset($attributes['contactsArea'])
        ? $attributes['contactsArea']
        : '';
        $contactsAddress = isset($attributes['contactsAddress'])
        ? $attributes['contactsAddress']
        : '';
        $expectObject->setContactsInfo(
            new ContactsInfo(
                $contactsName,
                $contactsCellphone,
                $contactsArea,
                $contactsAddress
            )
        );

        $legalPersonName = isset($attributes['legalPersonName'])
        ? $attributes['legalPersonName']
        : '';
        $legalPersonCardId = isset($attributes['legalPersonCardId'])
        ? $attributes['legalPersonCardId']
        : '';
        $legalPersonPositivePhoto = isset($attributes['legalPersonPositivePhoto'])
        ? $attributes['legalPersonPositivePhoto']
        : array();
        $legalPersonReversePhoto = isset($attributes['legalPersonReversePhoto'])
        ? $attributes['legalPersonReversePhoto']
        : array();
        $legalPersonHandheldPhoto = isset($attributes['legalPersonHandheldPhoto'])
        ? $attributes['legalPersonHandheldPhoto']
        : array();
        $expectObject->setLegalPersonInfo(
            new LegalPersonInfo(
                $legalPersonName,
                $legalPersonCardId,
                $legalPersonPositivePhoto,
                $legalPersonReversePhoto,
                $legalPersonHandheldPhoto
            )
        );
        if (isset($attributes['createTime'])) {
            $expectObject->setCreateTime($attributes['createTime']);
        }
        if (isset($attributes['updateTime'])) {
            $expectObject->setUpdateTime($attributes['updateTime']);
        }
        if (isset($attributes['status'])) {
            $expectObject->setStatus($attributes['status']);
        }
        if (isset($attributes['statusTime'])) {
            $expectObject->setStatusTime($attributes['statusTime']);
        }
        if (isset($relationships['member']['data'])) {
            $expectObject->setMember(new Member($relationships['member']['data']['id']));
        }

        return $expectObject;
    }

    public function testArrayToObjectCorrectObject()
    {
        $enterprise = \Sdk\Enterprise\Utils\EnterpriseMockFactory::generateEnterpriseArray();
        
        $data =  $enterprise['data'];
        $relationships = $data['relationships'];

        $member = new Member($relationships['member']['data']['id']);
        $memberRestfulTranslator = $this->prophesize(MemberRestfulTranslator::class);
        $memberRestfulTranslator->arrayToObject(Argument::exact($relationships['member']))
            ->shouldBeCalledTimes(1)->willReturn($member);

        $this->stub->expects($this->exactly(1))
            ->method('getMemberRestfulTranslator')
            ->willReturn($memberRestfulTranslator->reveal());

        $actual = $this->stub->arrayToObject($enterprise);

        $expectObject = new Enterprise();

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
        $enterprise = \Sdk\Enterprise\Utils\EnterpriseMockFactory::generateEnterpriseArray();

        $data =  $enterprise['data'];
        $relationships = $data['relationships'];

        $member = new Member($relationships['member']['data']['id']);
        $memberRestfulTranslator = $this->prophesize(MemberRestfulTranslator::class);
        $memberRestfulTranslator->arrayToObject(Argument::exact($relationships['member']))
            ->shouldBeCalledTimes(1)->willReturn($member);

        $this->stub->expects($this->exactly(1))
            ->method('getMemberRestfulTranslator')
            ->willReturn($memberRestfulTranslator->reveal());

        $actual = $this->stub->arrayToObjects($enterprise);

        $expectArray = array();

        $expectObject = new Enterprise();

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
        $enterprise = \Sdk\Enterprise\Utils\EnterpriseMockFactory::generateEnterpriseObject(new Enterprise(), 1, 1);

        $actual = $this->stub->objectToArray($enterprise, array(
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
            'member'
        ));

        $expectedArray = array(
            'data'=>array(
                'type'=>'enterprises'
            )
        );

        $expectedArray['data']['attributes'] = array(
            'name' => $enterprise->getName(),
            'unifiedSocialCreditCode' => $enterprise->getUnifiedSocialCreditCode(),
            'logo' => $enterprise->getLogo(),
            'businessLicense' => $enterprise->getBusinessLicense(),
            'powerAttorney' => $enterprise->getPowerAttorney(),
            'contactsName' => $enterprise->getContactsInfo()->getName(),
            'contactsCellphone' => $enterprise->getContactsInfo()->getCellphone(),
            'contactsArea' => $enterprise->getContactsInfo()->getArea(),
            'contactsAddress' => $enterprise->getContactsInfo()->getAddress(),
            'legalPersonName' => $enterprise->getLegalPersonInfo()->getName(),
            'legalPersonCardId' => $enterprise->getLegalPersonInfo()->getCardId(),
            'legalPersonPositivePhoto' => $enterprise->getLegalPersonInfo()->getPositivePhoto(),
            'legalPersonReversePhoto' => $enterprise->getLegalPersonInfo()->getReversePhoto(),
            'legalPersonHandheldPhoto' => $enterprise->getLegalPersonInfo()->getHandheldPhoto()
        );

        $expectedArray['data']['relationships']['member']['data'] = array(
            array(
                'type' => 'members',
                'id' => $enterprise->getMember()->getId()
            )
        );
        
        $this->assertEquals($expectedArray, $actual);
    }
}

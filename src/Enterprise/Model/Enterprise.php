<?php
namespace Sdk\Enterprise\Model;

use Marmot\Core;
use Marmot\Common\Model\Object;
use Marmot\Common\Model\IObject;

use Sdk\Common\Model\IOperatAble;
use Sdk\Common\Model\OperatAbleTrait;
use Sdk\Common\Adapter\IOperatAbleAdapter;

use Sdk\Member\Model\Member;

use Sdk\Enterprise\Repository\EnterpriseRepository;

class Enterprise implements IOperatAble, IObject
{
    use OperatAbleTrait, Object;
    /**
     * [$id ID]
     * @var [int]
     */
    private $id;
    /**
     * [$id 企业名称]
     * @var [string]
     */
    private $name;
    /**
     * [$id 统一社会信用代码]
     * @var [string]
     */
    private $unifiedSocialCreditCode;
    /**
     * [$id logo]
     * @var [array]
     */
    private $logo;
    /**
     * [$id 联系人信息]
     * @var [ContactsInfo]
     */
    private $contactsInfo;
    /**
     * [$id 营业执照]
     * @var [int]
     */
    private $businessLicense;
    /**
     * [$id 授权委托书]
     * @var [array]
     */
    private $powerAttorney;
    /**
     * [$id 法人身份信息]
     * @var [LegalPersonInfo]
     */
    private $legalPersonInfo;
    /**
     * [$id 关联账户]
     * @var [Member]
     */
    private $member;

    private $repository;

    public function __construct(int $id = 0)
    {
        $this->id = !empty($id) ? $id : 0;
        $this->name = '';
        $this->unifiedSocialCreditCode = '';
        $this->logo = array();
        $this->contactsInfo = new ContactsInfo();
        $this->businessLicense = array();
        $this->powerAttorney = array();
        $this->legalPersonInfo = new LegalPersonInfo();
        $this->member = Core::$container->has('user') ? Core::$container->get('user') : new Member();
        $this->statusTime = 0;
        $this->createTime = 0;
        $this->updateTime = 0;
        $this->status = 0;
        $this->repository = new EnterpriseRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->name);
        unset($this->unifiedSocialCreditCode);
        unset($this->logo);
        unset($this->contactsInfo);
        unset($this->businessLicense);
        unset($this->powerAttorney);
        unset($this->legalPersonInfo);
        unset($this->member);
        unset($this->statusTime);
        unset($this->createTime);
        unset($this->updateTime);
        unset($this->status);
        unset($this->repository);
    }

    public function setId($id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setUnifiedSocialCreditCode(string $unifiedSocialCreditCode) : void
    {
        $this->unifiedSocialCreditCode = $unifiedSocialCreditCode;
    }

    public function getUnifiedSocialCreditCode() : string
    {
        return $this->unifiedSocialCreditCode;
    }

    public function setLogo(array $logo) : void
    {
        $this->logo = $logo;
    }

    public function getLogo() : array
    {
        return $this->logo;
    }

    public function setContactsInfo(ContactsInfo $contactsInfo) : void
    {
        $this->contactsInfo = $contactsInfo;
    }

    public function getContactsInfo() : ContactsInfo
    {
        return $this->contactsInfo;
    }

    public function setBusinessLicense(array $businessLicense) : void
    {
        $this->businessLicense = $businessLicense;
    }

    public function getBusinessLicense() : array
    {
        return $this->businessLicense;
    }

    public function setPowerAttorney(array $powerAttorney) : void
    {
        $this->powerAttorney = $powerAttorney;
    }

    public function getPowerAttorney() : array
    {
        return $this->powerAttorney;
    }

    public function setLegalPersonInfo(LegalPersonInfo $legalPersonInfo) : void
    {
        $this->legalPersonInfo = $legalPersonInfo;
    }

    public function getLegalPersonInfo() : LegalPersonInfo
    {
        return $this->legalPersonInfo;
    }

    public function setMember(Member $member) : void
    {
        $this->member = $member;
    }

    public function getMember() : Member
    {
        return $this->member;
    }

    public function setStatus(int $status) : void
    {
        $this->status = $status;
    }

    protected function getRepository()
    {
        return $this->repository;
    }

    protected function getIOperatAbleAdapter() : IOperatAbleAdapter
    {
        return $this->getRepository();
    }
}

<?php
namespace Sdk\Member\Adapter\Member;

use Marmot\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sdk\Member\Model\Member;
use Sdk\Member\Model\NullMember;
use Sdk\Member\Translator\MemberRestfulTranslator;

use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\EnableAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;

class MemberRestfulAdapter extends GuzzleAdapter implements IMemberAdapter
{
    use FetchAbleRestfulAdapterTrait,
        AsyncFetchAbleRestfulAdapterTrait,
        OperatAbleRestfulAdapterTrait,
        CommonMapErrorsTrait,
        EnableAbleRestfulAdapterTrait;

    private $translator;

    private $resource;

    const SCENARIOS = [
        'MEMBER_LIST'=>[
            'fields'=>[
                'members'=>'cellphone,realName,nickName,gender,createTime,updateTime,status'
            ]
        ],
        'MEMBER_FETCH_ONE'=>[
            'fields'=>[]
        ]
    ];

    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct(
            $uri,
            $authKey
        );
        $this->translator = new MemberRestfulTranslator();
        $this->scenario = array();
        $this->resource = 'members';
    }

    protected function getResource()
    {
        return $this->resource;
    }

    protected function getTranslator() : IRestfulTranslator
    {
        return $this->translator;
    }

    public function scenario($scenario) : void
    {
        $this->scenario = isset(self::SCENARIOS[$scenario]) ? self::SCENARIOS[$scenario] : array();
    }

    protected function getMapErrors() : array
    {
        $mapError = [
            10 => CELLPHONE_NOT_EXIST,
            100 => CELLPHONE_EXIST,
            109 => STATUS_DISABLED
        ];

        $commonMapErrors = $this->commonMapErrors();

        return $mapError+$commonMapErrors;
    }

    public function fetchOne($id)
    {
        return $this->fetchOneAction($id, NullMember::getInstance());
    }

    public function signUp(Member $member) : bool
    {
        return $this->addAction($member);
    }

    protected function addAction(Member $member) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $member,
            array(
                'cellphone','password'
            )
        );

        $this->post(
            $this->getResource().'/signUp',
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($member);
            return true;
        }

        return false;
    }

    public function signIn(Member $member) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $member,
            array(
                'cellphone','password'
            )
        );
        $this->post(
            $this->getResource().'/signIn',
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($member);
            return true;
        }
        return false;
    }

    public function resetPassword(Member $member) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $member,
            array(
                'cellphone',
                'password'
            )
        );

        $this->patch(
            $this->resource.'/resetPassword',
            $data
        );
        if ($this->isSuccess()) {
            $this->translateToObject($member);
            return true;
        }

        return false;
    }

    public function updatePassword(Member $member) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $member,
            array(
                'oldPassword',
                'password'
            )
        );

        $this->patch(
            $this->getResource().'/'.$member->getId().'/updatePassword',
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($member);
            return true;
        }

        return false;
    }

    public function updateCellphone(Member $member) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $member,
            array(
                'cellphone'
            )
        );

        $this->patch(
            $this->getResource().'/'.$member->getId().'/updateCellphone',
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($member);
            return true;
        }

        return false;
    }

    protected function editAction(Member $member) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $member,
            array(
                'nickName',
                'gender',
                'avatar',
                'birthday',
                'area',
                'address',
                'briefIntroduction'
            )
        );

        $this->patch(
            $this->getResource().'/'.$member->getId(),
            $data
        );
        if ($this->isSuccess()) {
            $this->translateToObject($member);
            return true;
        }

        return false;
    }
}

<?php
namespace Sdk\Enterprise\Adapter\Enterprise;

use Marmot\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;

use Sdk\Enterprise\Model\Enterprise;
use Sdk\Enterprise\Model\NullEnterprise;
use Sdk\Enterprise\Translator\EnterpriseRestfulTranslator;

class EnterpriseRestfulAdapter extends GuzzleAdapter implements IEnterpriseAdapter
{
    use CommonMapErrorsTrait,
        FetchAbleRestfulAdapterTrait,
        OperatAbleRestfulAdapterTrait,
        AsyncFetchAbleRestfulAdapterTrait;

    private $translator;

    private $resource;

    const SCENARIOS = [
        'OA_ENTERPRISE_LIST'=>[
            'fields'=>[
                'enterprises'=>
                    'name,unifiedSocialCreditCode,contactsName,contactsCellphone,updateTime,createTime,member'
            ],
            'include'=>'member'
        ],
        'PORTAL_ENTERPRISE_LIST'=>[
            'fields'=>[],
            'include'=>'member'
        ],
        'ENTERPRISE_FETCH_ONE'=>[
            'fields'=>[],
            'include'=>'member'
        ]
    ];

    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct(
            $uri,
            $authKey
        );
        $this->translator = new EnterpriseRestfulTranslator();
        $this->resource = 'enterprises';
        $this->scenario = array();
    }

    protected function getMapErrors() : array
    {
        return $this->commonMapErrors();
    }

    protected function getTranslator() : IRestfulTranslator
    {
        return $this->translator;
    }

    protected function getResource() : string
    {
        return $this->resource;
    }

    public function scenario($scenario) : void
    {
        $this->scenario = isset(self::SCENARIOS[$scenario]) ? self::SCENARIOS[$scenario] : array();
    }

    public function fetchOne($id)
    {
        return $this->fetchOneAction($id, NullEnterprise::getInstance());
    }
    /**
     * [addAction 认证企业信息]
     * @param Enterprise $enterprise [企业对象]
     * @return [bool]                [返回类型]
     */
    protected function addAction(Enterprise $enterprise) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $enterprise,
            array(
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
            )
        );

        $this->post(
            $this->getResource(),
            $data
        );
        
        if ($this->isSuccess()) {
            $this->translateToObject($enterprise);
            return true;
        }

        return false;
    }
    /**
     * [editAction 编辑企业信息]
     * @param  Enterprise $enterprise [企业对象]
     * @return [bool]                 [返回类型]
     */
    protected function editAction(Enterprise $enterprise) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $enterprise,
            array(
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
            )
        );

        $this->patch(
            $this->getResource().'/'.$enterprise->getId(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($enterprise);
            return true;
        }

        return false;
    }
}

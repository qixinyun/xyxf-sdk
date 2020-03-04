<?php
namespace Sdk\Enterprise\Adapter\Enterprise;

use Marmot\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\ResubmitAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\ApplyAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;

use Sdk\Enterprise\Model\UnAuditedEnterprise;
use Sdk\Enterprise\Model\NullUnAuditedEnterprise;
use Sdk\Enterprise\Translator\UnAuditedEnterpriseRestfulTranslator;

class UnAuditedEnterpriseRestfulAdapter extends GuzzleAdapter implements IUnAuditedEnterpriseAdapter
{
    use CommonMapErrorsTrait,
        FetchAbleRestfulAdapterTrait,
        ResubmitAbleRestfulAdapterTrait,
        ApplyAbleRestfulAdapterTrait,
        AsyncFetchAbleRestfulAdapterTrait;

    private $translator;

    private $resource;

    const SCENARIOS = [
        'OA_UNAUDITEDENTERPRISE_LIST'=>[
            'fields'=>[
                'unAuditedEnterprises'=>
                'name,unifiedSocialCreditCode,contactsName,contactsCellphone,applyStatus,updateTime,createTime,relation'
            ],
            'include'=>'relation'
        ],
        'PORTAL_UNAUDITEDENTERPRISE_LIST'=>[
            'fields'=>[],
            'include'=>'relation'
        ],

        'UNAUDITEDENTERPRISE_FETCH_ONE'=>[
            'fields'=>[],
            'include'=>'relation'
        ]
    ];

    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct(
            $uri,
            $authKey
        );
        $this->translator = new UnAuditedEnterpriseRestfulTranslator();
        $this->resource = 'unAuditedEnterprises';
        $this->scenario = array();
    }

    protected function getMapErrors() : array
    {
        $mapErrors = [
            100 => ENTERPRISE_EXIST
        ];
        $commonMapErrors = $this->commonMapErrors();

        return $mapErrors+$commonMapErrors;
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
        return $this->fetchOneAction($id, NullUnAuditedEnterprise::getInstance());
    }
    /**
     * [resubmitAction 重新认证]
     * @param  UnAuditedEnterprise $unAuditedEnterprise [认证信息对象]
     * @return [bool]                                   [返回类型]
     */
    protected function resubmitAction(UnAuditedEnterprise $unAuditedEnterprise) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $unAuditedEnterprise,
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
            $this->getResource().'/'.$unAuditedEnterprise->getId().'/resubmit',
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($unAuditedEnterprise);
            return true;
        }

        return false;
    }
}

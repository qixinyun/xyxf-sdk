<?php
namespace Sdk\Policy\Adapter\Policy;

use Marmot\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sdk\Policy\Model\Policy;
use Sdk\Policy\Model\NullPolicy;
use Sdk\Policy\Translator\PolicyRestfulTranslator;

use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OnShelfAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;

class PolicyRestfulAdapter extends GuzzleAdapter implements IPolicyAdapter
{
    use CommonMapErrorsTrait,
        FetchAbleRestfulAdapterTrait,
        OperatAbleRestfulAdapterTrait,
        OnShelfAbleRestfulAdapterTrait,
        AsyncFetchAbleRestfulAdapterTrait;

    private $translator;

    private $resource;

    const SCENARIOS = [
            'OA_POLICY_LIST'=>[
                'fields'=>[
                    'policies' => 'title,dispatchDepartments,image,number,level,createTime,updateTime,status'
                ],
                'include'=> 'crew,dispatchDepartments,labels'
            ],
            'PORTAL_POLICY_LIST'=>[
                'fields'=>[],
                'include'=> 'crew,dispatchDepartments,labels'
            ],
            'POLICY_FETCH_ONE'=>[
                'fields'=>[],
                'include'=> 'crew,dispatchDepartments,labels'
            ]
        ];

    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct(
            $uri,
            $authKey
        );
        $this->translator = new PolicyRestfulTranslator();
        $this->resource = 'policies';
        $this->scenario = array();
    }

    protected function getMapErrors() : array
    {
        $commonMapErrors = $this->commonMapErrors();

        return $commonMapErrors;
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
        return $this->fetchOneAction($id, NullPolicy::getInstance());
    }

    protected function addAction(Policy $policy) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $policy,
            array(
                'title',
                'applicableObjects',
                'dispatchDepartments',
                'applicableIndustries',
                'level',
                'classifies',
                'detail',
                'description',
                'image',
                'attachments',
                'labels',
                'processingFlow',
                'admissibleAddress',
                'crew'
            )
        );
        
        $this->post(
            $this->getResource(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($policy);
            return true;
        }

        return false;
    }

    protected function editAction(Policy $policy) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $policy,
            array(
                'title',
                'applicableObjects',
                'dispatchDepartments',
                'applicableIndustries',
                'level',
                'classifies',
                'detail',
                'description',
                'image',
                'attachments',
                'labels',
                'processingFlow',
                'admissibleAddress'
            )
        );
        
        $this->patch(
            $this->getResource().'/'.$policy->getId(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($policy);
            return true;
        }

        return false;
    }
}

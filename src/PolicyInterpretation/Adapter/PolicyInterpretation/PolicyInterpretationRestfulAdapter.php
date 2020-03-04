<?php
namespace Sdk\PolicyInterpretation\Adapter\PolicyInterpretation;

use Marmot\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sdk\PolicyInterpretation\Model\PolicyInterpretation;
use Sdk\PolicyInterpretation\Model\NullPolicyInterpretation;
use Sdk\PolicyInterpretation\Translator\PolicyInterpretationRestfulTranslator;

use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OnShelfAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;

class PolicyInterpretationRestfulAdapter extends GuzzleAdapter implements IPolicyInterpretationAdapter
{
    use CommonMapErrorsTrait,
        FetchAbleRestfulAdapterTrait,
        OperatAbleRestfulAdapterTrait,
        OnShelfAbleRestfulAdapterTrait,
        AsyncFetchAbleRestfulAdapterTrait;

    private $translator;

    private $resource;

    const SCENARIOS = [
            'POLICYINTERPRETATION_LIST'=>[
                'fields'=>[
                    'policyInterpretations'=>
                        'policy,cover,title,detail,description,attachments,crew,createTime,updateTime'
                ],
                'include'=> 'crew,policy,policy.dispatchDepartments,policy.labels'
            ],
            'POLICYINTERPRETATION_FETCH_ONE'=>[
                'fields'=>[],
                'include'=> 'crew,policy,policy.dispatchDepartments,policy.labels'
            ]
        ];

    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct(
            $uri,
            $authKey
        );
        $this->translator = new PolicyInterpretationRestfulTranslator();
        $this->resource = 'policyInterpretations';
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
        return $this->fetchOneAction($id, NullPolicyInterpretation::getInstance());
    }

    protected function addAction(PolicyInterpretation $policyInterpretation) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $policyInterpretation,
            array(
                'policy',
                'cover',
                'title',
                'detail',
                'description',
                'attachments',
                'crew'
            )
        );

        $this->post(
            $this->getResource(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($policyInterpretation);
            return true;
        }

        return false;
    }

    protected function editAction(PolicyInterpretation $policyInterpretation) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $policyInterpretation,
            array(
                'policy',
                'cover',
                'title',
                'detail',
                'description',
                'attachments'
            )
        );
        
        $this->patch(
            $this->getResource().'/'.$policyInterpretation->getId(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($policyInterpretation);
            return true;
        }

        return false;
    }
}

<?php
namespace Sdk\Label\Adapter\Label;

use Marmot\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sdk\Label\Model\Label;
use Sdk\Label\Model\NullLabel;
use Sdk\Label\Translator\LabelRestfulTranslator;

use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;

class LabelRestfulAdapter extends GuzzleAdapter implements ILabelAdapter
{
    use FetchAbleRestfulAdapterTrait,
        OperatAbleRestfulAdapterTrait,
        CommonMapErrorsTrait;

    private $translator;

    private $resource;

    const SCENARIOS = [
            'LABEL_LIST'=>[
                'fields'=>[
                    'labels'=>'name,icon,category,remark,status,createTime,updateTime'
                ],
                'include'=> 'crew'
            ],
            'LABEL_FETCH_ONE'=>[
                'fields'=>[],
                'include'=> 'crew'
            ]
        ];

    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct(
            $uri,
            $authKey
        );
        $this->translator = new LabelRestfulTranslator();
        $this->resource = 'labels';
        $this->scenario = array();
    }

    protected function getMapErrors() : array
    {
        $mapErrors = [
            100 => LABEL_NAME_EXIST
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
        return $this->fetchOneAction($id, NullLabel::getInstance());
    }

    protected function addAction(Label $label) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $label,
            array(
                'name',
                'icon',
                'category',
                'remark',
                'crew'
            )
        );
        
        $this->post(
            $this->getResource(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($label);
            return true;
        }

        return false;
    }

    protected function editAction(Label $label) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $label,
            array(
                'name',
                'icon',
                'category',
                'remark',
            )
        );

        $this->patch(
            $this->getResource().'/'.$label->getId(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($label);
            return true;
        }

        return false;
    }
}

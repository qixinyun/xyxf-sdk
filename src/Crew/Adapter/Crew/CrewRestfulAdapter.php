<?php
namespace Sdk\Crew\Adapter\Crew;

use Marmot\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sdk\Crew\Model\Crew;
use Sdk\Crew\Model\NullCrew;
use Sdk\Crew\Translator\CrewRestfulTranslator;
use Marmot\Core;

use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\EnableAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;

class CrewRestfulAdapter extends GuzzleAdapter implements ICrewAdapter
{
    use FetchAbleRestfulAdapterTrait,
        OperatAbleRestfulAdapterTrait,
        EnableAbleRestfulAdapterTrait,
        AsyncFetchAbleRestfulAdapterTrait,
        CommonMapErrorsTrait;

    private $translator;

    private $resource;

    const SCENARIOS = [
        'CREW_LIST'=>[
            'fields'=>[
                'crews'=>'cellphone,realName,gender,workNumber,createTime,updateTime,status'
            ]
        ],
        'CREW_FETCH_ONE'=>[
            'fields'=>[]
        ]
    ];

    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct(
            $uri,
            $authKey
        );
        $this->translator = new CrewRestfulTranslator();
        $this->scenario = array();
        $this->resource = 'crews';
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
        ];

        $commonMapErrors = $this->commonMapErrors();

        return $mapError+$commonMapErrors;
    }

    public function fetchOne($id)
    {
        return $this->fetchOneAction($id, NullCrew::getInstance());
    }

    public function signIn(Crew $crew) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $crew,
            array(
                'cellphone','password'
            )
        );
        $this->post(
            $this->getResource().'/signIn',
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($crew);
            return true;
        }

        return false;
    }

    public function updatePassword(Crew $crew) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $crew,
            array(
                'oldPassword',
                'password'
            )
        );

        $this->patch(
            $this->getResource().'/'.$crew->getId().'/updatePassword',
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($crew);
            return true;
        }

        return false;
    }

    protected function addAction(Crew $crew) : bool
    {        
        $data = $this->getTranslator()->objectToArray(
            $crew,
            array('realName', 'cellphone', 'password', 'avatar', 'cardId','roles','userGroup')
        );
        $this->post(
            $this->getResource(),
            $data
        );
        
        if ($this->isSuccess()) {
            $this->translateToObject($crew);
            return true;
        }

        return false;
    }

    protected function editAction(Crew $crew) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $crew,
            array('realName', 'cardId', 'avatar','roles')
        );

        $this->patch(
            $this->getResource().'/'.$crew->getId(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($crew);
            return true;
        }

        return false;
    }
}

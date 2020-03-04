<?php
namespace Sdk\NaturalPerson\Adapter\NaturalPerson;

use Marmot\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\ApplyAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;

use Sdk\NaturalPerson\Model\NaturalPerson;
use Sdk\NaturalPerson\Model\NullNaturalPerson;
use Sdk\NaturalPerson\Translator\NaturalPersonRestfulTranslator;

class NaturalPersonRestfulAdapter extends GuzzleAdapter implements INaturalPersonAdapter
{
    use FetchAbleRestfulAdapterTrait,
        OperatAbleRestfulAdapterTrait,
        ApplyAbleRestfulAdapterTrait,
        AsyncFetchAbleRestfulAdapterTrait,
        CommonMapErrorsTrait;

    private $translator;

    private $resource;

    const SCENARIOS = [
        'NATURALPERSON_LIST'=>[
            'fields'=>[],
            'include'=>'member'
        ],
        'NATURALPERSON_FETCH_ONE'=>[
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
        $this->translator = new NaturalPersonRestfulTranslator();
        $this->resource = 'naturalPersons';
        $this->scenario = array();
    }

    protected function getResource() : string
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
        return $this->commonMapErrors();
    }

    public function fetchOne($id)
    {
        return $this->fetchOneAction($id, NullNaturalPerson::getInstance());
    }

    protected function addAction(NaturalPerson $naturalPersons) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $naturalPersons,
            array(
                'realName',
                'cardId',
                'positivePhoto',
                'reversePhoto',
                'handheldPhoto',
                'member'
            )
        );

        $this->post(
            $this->getResource(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($naturalPersons);
            return true;
        }

        return false;
    }

    protected function editAction(NaturalPerson $naturalPersons) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $naturalPersons,
            array(
                'realName',
                'cardId',
                'positivePhoto',
                'reversePhoto',
                'handheldPhoto'
            )
        );

        $this->patch(
            $this->getResource().'/'.$naturalPersons->getId().'/resubmit',
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($naturalPersons);
            return true;
        }

        return false;
    }
}

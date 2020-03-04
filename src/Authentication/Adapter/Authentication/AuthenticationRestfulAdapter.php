<?php
namespace Sdk\Authentication\Adapter\Authentication;

use Marmot\Interfaces\IRestfulTranslator;
use Marmot\Framework\Adapter\Restful\GuzzleAdapter;

use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\OperatAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\ResubmitAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\ApplyAbleRestfulAdapterTrait;
use Sdk\Common\Adapter\AsyncFetchAbleRestfulAdapterTrait;

use Sdk\Authentication\Model\Authentication;
use Sdk\Authentication\Model\NullAuthentication;
use Sdk\Authentication\Translator\AuthenticationRestfulTranslator;

class AuthenticationRestfulAdapter extends GuzzleAdapter implements IAuthenticationAdapter
{
    use CommonMapErrorsTrait,
        FetchAbleRestfulAdapterTrait,
        OperatAbleRestfulAdapterTrait,
        ResubmitAbleRestfulAdapterTrait,
        ApplyAbleRestfulAdapterTrait,
        AsyncFetchAbleRestfulAdapterTrait;

    const SCENARIOS = [
            'AUTHENTICATION_LIST'=>[
                'fields'=>[],
                'include'=>'enterprise,serviceCategory'
            ],
            'AUTHENTICATION_FETCH_ONE'=>[
                'fields'=>[],
                'include'=>'enterprise,serviceCategory'
            ]
        ];

    private $translator;

    private $resource;

    public function __construct(string $uri = '', array $authKey = [])
    {
         parent::__construct(
             $uri,
             $authKey
         );
        $this->translator = new AuthenticationRestfulTranslator();
        $this->resource = 'authentications';
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
        return $this->fetchOneAction($id, NullAuthentication::getInstance());
    }

    protected function addAction(Authentication $authentication) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $authentication,
            array(
                'qualifications',
                'enterprise'
            )
        );
        
        $this->post(
            $this->getResource(),
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($authentication);
            return true;
        }

        return false;
    }
    protected function resubmitAction(Authentication $authentication) : bool
    {
        return $this->editAction($authentication);
    }
    
    protected function editAction(Authentication $authentication) : bool
    {
        $data = $this->getTranslator()->objectToArray(
            $authentication,
            array(
                'qualificationImage'
            )
        );

        $this->patch(
            $this->getResource().'/'.$authentication->getId().'/resubmit',
            $data
        );

        if ($this->isSuccess()) {
            $this->translateToObject($authentication);
            return true;
        }

        return false;
    }
}

<?php
namespace Sdk\MemberAccount\Adapter\MemberAccount;

use Marmot\Framework\Adapter\Restful\GuzzleAdapter;
use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Common\Adapter\CommonMapErrorsTrait;
use Sdk\Common\Adapter\FetchAbleRestfulAdapterTrait;

use Sdk\MemberAccount\Model\NullMemberAccount;
use Sdk\MemberAccount\Model\MemberAccount;

use Sdk\MemberAccount\Translator\MemberAccountRestfulTranslator;

class MemberAccountRestfulAdapter extends GuzzleAdapter implements IMemberAccountAdapter
{
    use CommonMapErrorsTrait, FetchAbleRestfulAdapterTrait;

    const SCENARIOS = [
        'MEMBER_ACCOUNT_FETCH_ONE' => [
            'fields' => [],
            'include' => 'member',
        ],
    ];

    private $translator;

    private $resource;

    public function __construct(string $uri = '', array $authKey = [])
    {
        parent::__construct($uri, $authKey);
        $this->translator = new MemberAccountRestfulTranslator();
        $this->resource = 'memberAccounts';
        $this->scenario = array();
    }

    protected function getMapErrors(): array
    {
        return $this->commonMapErrors();
    }

    protected function getTranslator(): IRestfulTranslator
    {
        return $this->translator;
    }

    protected function getResource(): string
    {
        return $this->resource;
    }

    public function scenario($scenario): void
    {
        $this->scenario = isset(self::SCENARIOS[$scenario]) ? self::SCENARIOS[$scenario] : array();
    }

    public function fetchOne($id)
    {
        return $this->fetchOneAction($id, NullMemberAccount::getInstance());
    }
}

<?php
namespace Sdk\Statistical\Adapter;

use Marmot\Interfaces\IRestfulTranslator;

use Sdk\Statistical\Translator\StatisticalRestfulTranslator;
use Marmot\Core;

trait StatisticalAdaoterTrait
{
    private $translator;

    private $resource;

    public function __construct()
    {
        parent::__construct(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey') : []
        );
        $this->translator = new StatisticalRestfulTranslator();
        $this->resource = 'statisticals';
    }

    protected function getResource() : string
    {
        return $this->resource;
    }

    protected function getTranslator() : IRestfulTranslator
    {
        return $this->translator;
    }
}

<?php
namespace Sdk\Label\Repository;

use Sdk\Common\Repository\FetchRepositoryTrait;
use Sdk\Common\Repository\OperatAbleRepositoryTrait;
use Sdk\Common\Repository\ErrorRepositoryTrait;

use Sdk\Label\Adapter\Label\ILabelAdapter;
use Sdk\Label\Adapter\Label\LabelMockAdapter;
use Sdk\Label\Adapter\Label\LabelRestfulAdapter;

use Marmot\Core;
use Marmot\Framework\Classes\Repository;

class LabelRepository extends Repository implements ILabelAdapter
{
    use FetchRepositoryTrait,
        OperatAbleRepositoryTrait,
        ErrorRepositoryTrait;

    private $adapter;

    const LIST_MODEL_UN = 'LABEL_LIST';
    const FETCH_ONE_MODEL_UN = 'LABEL_FETCH_ONE';

    public function __construct()
    {
        $this->adapter = new LabelRestfulAdapter(
            Core::$container->has('sdk.url') ? Core::$container->get('sdk.url') : '',
            Core::$container->has('sdk.authKey') ? Core::$container->get('sdk.authKey') : []
        );
    }

    public function getActualAdapter() : ILabelAdapter
    {
        return $this->adapter;
    }

    public function getMockAdapter() : ILabelAdapter
    {
        return new LabelMockAdapter();
    }

    public function scenario($scenario)
    {
        $this->getAdapter()->scenario($scenario);
        return $this;
    }
}

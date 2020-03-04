<?php
namespace Sdk\PolicyInterpretation\Adapter\PolicyInterpretation;

use Sdk\Common\Adapter\IFetchAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Adapter\IOnShelfAbleAdapter;

use Marmot\Interfaces\IAsyncAdapter;

use Sdk\PolicyInterpretation\Model\PolicyInterpretation;

interface IPolicyInterpretationAdapter extends IFetchAbleAdapter, IOperatAbleAdapter, IAsyncAdapter, IOnShelfAbleAdapter
{

}

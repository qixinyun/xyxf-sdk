<?php
namespace Sdk\Policy\Adapter\Policy;

use Sdk\Common\Adapter\IFetchAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Adapter\IOnShelfAbleAdapter;

use Marmot\Interfaces\IAsyncAdapter;

interface IPolicyAdapter extends IFetchAbleAdapter, IOperatAbleAdapter, IAsyncAdapter, IOnShelfAbleAdapter
{

}

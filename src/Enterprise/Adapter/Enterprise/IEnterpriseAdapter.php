<?php
namespace Sdk\Enterprise\Adapter\Enterprise;

use Marmot\Interfaces\IAsyncAdapter;

use Sdk\Common\Adapter\IFetchAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;

interface IEnterpriseAdapter extends IFetchAbleAdapter, IOperatAbleAdapter, IAsyncAdapter
{
}

<?php
namespace Sdk\Service\Adapter\Service;

use Marmot\Interfaces\IAsyncAdapter;

use Sdk\Common\Adapter\IFetchAbleAdapter;
use Sdk\Common\Adapter\IModifyStatusAbleAdapter;

interface IServiceAdapter extends IAsyncAdapter, IFetchAbleAdapter, IServiceOperatAdapter, IModifyStatusAbleAdapter
{
}

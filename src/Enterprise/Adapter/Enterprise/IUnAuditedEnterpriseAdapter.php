<?php
namespace Sdk\Enterprise\Adapter\Enterprise;

use Marmot\Interfaces\IAsyncAdapter;

use Sdk\Common\Adapter\IFetchAbleAdapter;
use Sdk\Common\Adapter\IResubmitAbleAdapter;
use Sdk\Common\Adapter\IApplyAbleAdapter;

interface IUnAuditedEnterpriseAdapter extends IFetchAbleAdapter, IResubmitAbleAdapter, IApplyAbleAdapter, IAsyncAdapter
{
}

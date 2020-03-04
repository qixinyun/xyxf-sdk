<?php
namespace Sdk\Service\Adapter\Service;

use Sdk\Common\Adapter\IApplyAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Adapter\IResubmitAbleAdapter;

interface IServiceOperatAdapter extends IOperatAbleAdapter, IResubmitAbleAdapter, IApplyAbleAdapter
{
}

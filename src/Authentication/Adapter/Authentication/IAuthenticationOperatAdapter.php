<?php
namespace Sdk\Authentication\Adapter\Authentication;

use Sdk\Common\Adapter\IApplyAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Adapter\IResubmitAbleAdapter;

interface IAuthenticationOperatAdapter extends IOperatAbleAdapter, IResubmitAbleAdapter, IApplyAbleAdapter
{
}

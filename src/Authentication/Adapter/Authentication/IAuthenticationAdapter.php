<?php
namespace Sdk\Authentication\Adapter\Authentication;

use Marmot\Interfaces\IAsyncAdapter;
use Sdk\Common\Adapter\IFetchAbleAdapter;

interface IAuthenticationAdapter extends IFetchAbleAdapter, IAuthenticationOperatAdapter, IAsyncAdapter
{
}

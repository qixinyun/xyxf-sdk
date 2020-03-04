<?php
namespace Sdk\Crew\Adapter\Crew;

use Sdk\Common\Adapter\IFetchAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Common\Adapter\IEnableAbleAdapter;
use Sdk\Crew\Model\Crew;

use Marmot\Interfaces\IAsyncAdapter;

interface ICrewAdapter extends IAsyncAdapter, IFetchAbleAdapter, IOperatAbleAdapter, IEnableAbleAdapter
{
    public function signIn(Crew $crew);

    public function updatePassword(Crew $crew);
}

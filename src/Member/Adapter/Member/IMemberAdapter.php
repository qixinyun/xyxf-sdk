<?php
namespace Sdk\Member\Adapter\Member;

use Sdk\Common\Adapter\IFetchAbleAdapter;
use Sdk\Common\Adapter\IEnableAbleAdapter;
use Sdk\Common\Adapter\IOperatAbleAdapter;
use Sdk\Member\Model\Member;

use Marmot\Interfaces\IAsyncAdapter;

interface IMemberAdapter extends IAsyncAdapter, IFetchAbleAdapter, IOperatAbleAdapter, IEnableAbleAdapter
{
    public function signIn(Member $member);

    public function signUp(Member $member);

    public function updatePassword(Member $member);

    public function resetPassword(Member $member);

    public function updateCellphone(Member $member);
}

<?php
namespace Sdk\Common\Model;

interface IResubmitAble
{
    public function resubmit() : bool;
}

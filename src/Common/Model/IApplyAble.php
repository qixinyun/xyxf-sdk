<?php
namespace Sdk\Common\Model;

interface IApplyAble
{
    const APPLY_STATUS = array(
        'PENDING' => 0,
        'APPROVE' => 2,
        'REJECT' => -2
    );

    public function approve() : bool;

    public function reject() : bool;
}

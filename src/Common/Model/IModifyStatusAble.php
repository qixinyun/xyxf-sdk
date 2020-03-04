<?php
namespace Sdk\Common\Model;

interface IModifyStatusAble
{
    const STATUS = array(
        'NORMAL' => 0,
        'REVOKED' => -2,
        'CLOSED' => -4,
        'DELETED' => -6
    );

    public function revoke() : bool;
    
    public function close() : bool;

    public function deletes() : bool;
}

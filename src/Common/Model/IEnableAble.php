<?php
namespace Sdk\Common\Model;

interface IEnableAble
{
    const STATUS = array(
        'ENABLED' => 0 ,
        'DISABLED' => -2
    );

    public function enable() : bool;
    
    public function disable() : bool;
}

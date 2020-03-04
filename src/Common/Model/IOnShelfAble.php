<?php
namespace Sdk\Common\Model;

interface IOnShelfAble
{
    const STATUS = array(
        'ONSHELF' => 0 ,
        'OFFSTOCK' => -2
    );

    public function onShelf() : bool;
    
    public function offStock() : bool;
}

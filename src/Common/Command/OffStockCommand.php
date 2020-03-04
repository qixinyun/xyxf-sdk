<?php
namespace Sdk\Common\Command;

use Marmot\Interfaces\ICommand;

abstract class OffStockCommand implements ICommand
{
    public $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}

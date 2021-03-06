<?php
namespace Sdk\Common\Command;

use Marmot\Interfaces\ICommand;

abstract class DisableCommand implements ICommand
{
    public $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}

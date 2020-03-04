<?php
namespace Sdk\Common\Command;

use Marmot\Interfaces\ICommand;

abstract class DeleteCommand implements ICommand
{
    public $id;

    public function __construct(
        int $id = 0
    ) {
        $this->id = $id;
    }
}

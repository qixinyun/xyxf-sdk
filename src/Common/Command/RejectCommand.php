<?php
namespace Sdk\Common\Command;

use Marmot\Interfaces\ICommand;

abstract class RejectCommand implements ICommand
{
    public $rejectReason;

    public $id;

    public function __construct(
        string $rejectReason,
        int $id
    ) {
        $this->rejectReason = $rejectReason;
        $this->id = $id;
    }
}

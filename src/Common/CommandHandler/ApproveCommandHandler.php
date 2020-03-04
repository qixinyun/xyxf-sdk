<?php
namespace Sdk\Common\CommandHandler;

use Sdk\Common\Model\IApplyAble;
use Sdk\Common\Command\ApproveCommand;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

abstract class ApproveCommandHandler implements ICommandHandler
{
    abstract protected function fetchIApplyObject($id) : IApplyAble;

    public function execute(ICommand $command)
    {
        return $this->executeAction($command);
    }

    protected function executeAction(ApproveCommand $command)
    {
        $this->approveAble = $this->fetchIApplyObject($command->id);

        return $this->approveAble->approve();
    }
}

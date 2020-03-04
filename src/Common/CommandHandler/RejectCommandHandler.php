<?php
namespace Sdk\Common\CommandHandler;

use Sdk\Common\Model\IApplyAble;
use Sdk\Common\Command\RejectCommand;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

abstract class RejectCommandHandler implements ICommandHandler
{
    abstract protected function fetchIApplyObject($id) : IApplyAble;

    public function execute(ICommand $command)
    {
        return $this->executeAction($command);
    }

    protected function executeAction(RejectCommand $command)
    {
        $this->rejectAble = $this->fetchIApplyObject($command->id);

        $this->rejectAble->setRejectReason($command->rejectReason);
        
        return $this->rejectAble->reject();
    }
}

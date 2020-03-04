<?php
namespace Sdk\Common\CommandHandler;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

use Sdk\Common\Model\IModifyStatusAble;
use Sdk\Common\Command\CloseCommand;

abstract class CloseCommandHandler implements ICommandHandler
{
    abstract protected function fetchIModifyStatusObject($id) : IModifyStatusAble;

    public function execute(ICommand $command)
    {
        return $this->executeAction($command);
    }

    protected function executeAction(CloseCommand $command)
    {
        $this->closeAble = $this->fetchIModifyStatusObject($command->id);
        return $this->closeAble->close();
    }
}

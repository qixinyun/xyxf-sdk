<?php
namespace Sdk\Common\CommandHandler;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

use Sdk\Common\Model\IModifyStatusAble;
use Sdk\Common\Command\DeleteCommand;

abstract class DeleteCommandHandler implements ICommandHandler
{
    abstract protected function fetchIModifyStatusObject($id) : IModifyStatusAble;

    public function execute(ICommand $command)
    {
        return $this->executeAction($command);
    }

    protected function executeAction(DeleteCommand $command)
    {
        $this->deleteAble = $this->fetchIModifyStatusObject($command->id);
        return $this->deleteAble->deletes();
    }
}

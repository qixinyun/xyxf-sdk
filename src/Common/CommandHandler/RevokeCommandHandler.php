<?php
namespace Sdk\Common\CommandHandler;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

use Sdk\Common\Model\IModifyStatusAble;
use Sdk\Common\Command\RevokeCommand;

abstract class RevokeCommandHandler implements ICommandHandler
{
    abstract protected function fetchIModifyStatusObject($id) : IModifyStatusAble;

    public function execute(ICommand $command)
    {
        return $this->executeAction($command);
    }

    protected function executeAction(RevokeCommand $command)
    {
        $this->revokeAble = $this->fetchIModifyStatusObject($command->id);
        return $this->revokeAble->revoke();
    }
}

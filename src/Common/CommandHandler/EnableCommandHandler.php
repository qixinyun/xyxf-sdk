<?php
namespace Sdk\Common\CommandHandler;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

use Sdk\Common\Model\IEnableAble;
use Sdk\Common\Command\EnableCommand;

abstract class EnableCommandHandler implements ICommandHandler
{
    abstract protected function fetchIEnableObject($id) : IEnableAble;

    public function execute(ICommand $command)
    {
        return $this->executeAction($command);
    }

    protected function executeAction(EnableCommand $command)
    {
        $this->enableAble = $this->fetchIEnableObject($command->id);
        return $this->enableAble->enable();
    }
}

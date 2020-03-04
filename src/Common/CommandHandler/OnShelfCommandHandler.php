<?php
namespace Sdk\Common\CommandHandler;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

use Sdk\Common\Model\IOnShelfAble;
use Sdk\Common\Command\OnShelfCommand;

abstract class OnShelfCommandHandler implements ICommandHandler
{
    abstract protected function fetchIOnShelfObject($id) : IOnShelfAble;

    public function execute(ICommand $command)
    {
        return $this->executeAction($command);
    }

    protected function executeAction(OnShelfCommand $command)
    {
        $this->onShelfAble = $this->fetchIOnShelfObject($command->id);
        return $this->onShelfAble->onShelf();
    }
}

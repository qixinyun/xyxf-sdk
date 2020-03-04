<?php
namespace Sdk\Common\CommandHandler;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

use Sdk\Common\Model\IOnShelfAble;
use Sdk\Common\Command\OffStockCommand;

abstract class OffStockCommandHandler implements ICommandHandler
{
    abstract protected function fetchIOnShelfObject($id) : IOnShelfAble;

    public function execute(ICommand $command)
    {
        return $this->executeAction($command);
    }

    protected function executeAction(OffStockCommand $command)
    {
        $this->onShelfAble = $this->fetchIOnShelfObject($command->id);
        return $this->onShelfAble->offStock();
    }
}

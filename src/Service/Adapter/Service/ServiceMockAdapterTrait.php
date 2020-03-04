<?php
namespace Sdk\Service\Adapter\Service;

trait ServiceMockAdapterTrait
{
    public function onShelf(Service $service): bool
    {
        unset($service);
        return true;
    }

    public function offStock(Service $service): bool
    {
        unset($service);
        return true;
    }
}

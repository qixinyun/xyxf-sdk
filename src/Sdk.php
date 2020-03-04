<?php
namespace Sdk;

use Marmot\Interfaces\Application\ISdk;

define('SDKS_ROOT', dirname(__FILE__) . DIRECTORY_SEPARATOR);

class Sdk implements ISdk
{
    public function initErrorConfig() : void
    {
        include_once SDKS_ROOT.'errorConfig.php';
    }

    public function getErrorDescriptions() : array
    {
        return include_once SDKS_ROOT.'./errorDescriptionConfig.php';
    }

    public function initConfig() : void
    {
        include_once SDKS_ROOT.'config.php';
    }
}

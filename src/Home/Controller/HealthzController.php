<?php
namespace Sdk\Home\Controller;

use Marmot\Basecode\Classes\Controller;

/**
 * @codeCoverageIgnore
 */
class HealthzController extends Controller
{

    public function healthz()
    {
        echo "ok";
        return true;
    }
}

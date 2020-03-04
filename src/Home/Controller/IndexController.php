<?php
namespace Sdk\Home\Controller;

use Marmot\Basecode\Classes\Controller;

class IndexController extends Controller
{

    /**
     * @codeCoverageIgnore
     */
    public function index()
    {
        var_dump("Hello World sdk Sample Code");
        return true;
    }
}

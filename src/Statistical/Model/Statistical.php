<?php
namespace Sdk\Statistical\Model;

class Statistical
{
    private $id;

    private $result;

    public function __construct()
    {
        $this->result = array();
    }

    public function __destruct()
    {
        unset($this->result);
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setResult(array $result) : void
    {
        $this->result = $result;
    }

    public function getResult() : array
    {
        return $this->result;
    }
}

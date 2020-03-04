<?php
namespace Sdk\Common\Model;

abstract class Category
{
    private $id;

    private $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->name);
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }
}

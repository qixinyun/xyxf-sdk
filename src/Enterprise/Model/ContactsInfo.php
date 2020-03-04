<?php
namespace Sdk\Enterprise\Model;

class ContactsInfo
{
    private $name;

    private $cellphone;

    private $area;

    private $address;

    public function __construct(
        string $name = '',
        string $cellphone = '',
        string $area = '',
        string $address = ''
    ) {
        $this->name = $name;
        $this->cellphone = $cellphone;
        $this->area = $area;
        $this->address = $address;
    }

    public function __destruct()
    {
        unset($this->name);
        unset($this->cellphone);
        unset($this->area);
        unset($this->address);
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getCellphone() : string
    {
        return $this->cellphone;
    }

    public function getArea() : string
    {
        return $this->area;
    }

    public function getAddress() : string
    {
        return $this->address;
    }
}

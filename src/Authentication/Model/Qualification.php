<?php
namespace Sdk\Authentication\Model;

use Sdk\ServiceCategory\Model\ServiceCategory;

class Qualification
{
    private $serviceCategory;

    private $image;

    public function __construct()
    {
        $this->serviceCategory = new ServiceCategory();
        $this->image = array();
    }

    public function __destruct()
    {
        unset($this->serviceCategory);
        unset($this->image);
    }

    public function setServiceCategory(ServiceCategory $serviceCategory): void
    {
        $this->serviceCategory = $serviceCategory;
    }

    public function getServiceCategory(): ServiceCategory
    {
        return $this->serviceCategory;
    }

    public function setImage(array $image): void
    {
        $this->image = $image;
    }

    public function getImage(): array
    {
        return $this->image;
    }
}

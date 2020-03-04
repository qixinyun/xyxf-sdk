<?php
namespace Sdk\Crew\Model;

use Sdk\Crew\Repository\CrewRepository;
use Sdk\User\Model\User;

class Crew extends User
{
    /**
     * [$workNumber 工号]
     * @var [string]
     */
    private $workNumber;
    /**
     * [$repository]
     * @var [Object]
     */
    private $repository;

    public function __construct(int $id = 0)
    {
        parent::__construct($id);
        $this->workNumber = '';
        $this->repository = new CrewRepository();
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->workNumber);
        unset($this->repository);
    }

    public function setWorkNumber(string $workNumber) : void
    {
        $this->workNumber = $workNumber;
    }

    public function getWorkNumber() : string
    {
        return $this->workNumber;
    }
    
    protected function getRepository() : CrewRepository
    {
        return $this->repository;
    }
}

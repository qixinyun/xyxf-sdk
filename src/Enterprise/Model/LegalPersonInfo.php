<?php
namespace Sdk\Enterprise\Model;

class LegalPersonInfo
{
    private $name;

    private $cardId;

    private $positivePhoto;

    private $reversePhoto;

    private $handheldPhoto;

    public function __construct(
        string $name = '',
        string $cardId = '',
        array $positivePhoto = array(),
        array $reversePhoto = array(),
        array $handHeldPhoto = array()
    ) {
        $this->name = $name;
        $this->cardId = $cardId;
        $this->positivePhoto = $positivePhoto;
        $this->reversePhoto = $reversePhoto;
        $this->handheldPhoto = $handHeldPhoto;
    }

    public function __destruct()
    {
        unset($this->name);
        unset($this->cardId);
        unset($this->positivePhoto);
        unset($this->reversePhoto);
        unset($this->handheldPhoto);
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getCardId() : string
    {
        return $this->cardId;
    }

    public function getPositivePhoto() : array
    {
        return $this->positivePhoto;
    }

    public function getReversePhoto() : array
    {
        return $this->reversePhoto;
    }

    public function getHandheldPhoto() : array
    {
        return $this->handheldPhoto;
    }
}

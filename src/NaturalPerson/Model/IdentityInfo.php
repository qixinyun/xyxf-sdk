<?php
namespace Sdk\NaturalPerson\Model;

/**
 * 身份信息,包含:
 * 身份证号 $cardId
 * 身份证正面照片 $positivePhoto
 * 身份证反面照片 $reversePhoto
 * 手持身份证正面照片  $handheldPhoto
 */
class IdentityInfo
{
    private $cardId;

    private $positivePhoto;

    private $reversePhoto;

    private $handheldPhoto;

    public function __construct(
        string $cardId = '',
        array $positivePhoto = array(),
        array $reversePhoto = array(),
        array $handHeldPhoto = array()
    ) {
        $this->cardId = $cardId;
        $this->positivePhoto = $positivePhoto;
        $this->reversePhoto = $reversePhoto;
        $this->handheldPhoto = $handHeldPhoto;
    }

    public function __destruct()
    {
        unset($this->cardId);
        unset($this->positivePhoto);
        unset($this->reversePhoto);
        unset($this->handheldPhoto);
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

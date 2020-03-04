<?php
namespace Sdk\Common\Utils;

trait RandomTokenTrait
{
    private static function random(int $length = 10)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    private static function randomNumber(int $length = 6)
    {
        $pool = '0123456789';
        return substr(str_shuffle(str_repeat($pool, 6)), 0, $length);
    }
}

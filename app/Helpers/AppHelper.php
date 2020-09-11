<?php
/**
 * Created by PhpStorm.
 * User: dinhln
 * Date: 7/7/20
 * Time: 11:03
 */

namespace App\Helpers;


class AppHelper
{
    public static function isBase64($s)
    {
        return (bool)preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $s);
    }
}
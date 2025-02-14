<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cookie;

class CookieHelper
{
    public static function createHttpOnlyCookie($name, $value, $minutes)
    {
        return Cookie::make($name, $value, $minutes, '/', null, true, true, false, 'Strict');
    }

    public static function getHttpCookie($name)
    {
        return Cookie::get($name);
    }
}

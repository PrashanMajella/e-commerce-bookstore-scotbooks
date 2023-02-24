<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Cookie;

class Session {

    /**
     * Summary of setCookieSessionEnd
     * @return void
     */
    public static function setCookieSessionEnd($boolean = true): void
    {
        Cookie::queue('session_end', $boolean, 1);
    }
}

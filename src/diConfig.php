<?php
declare(strict_types=1);

use corbomite\di\Di;
use buzzingpixel\cookieapi\CookieApi;
use buzzingpixel\cookieapi\CookieApiTwigExtension;

return [
    CookieApi::class => function () {
        return new CookieApi($_COOKIE);
    },
    CookieApiTwigExtension::class => function () {
        return new CookieApiTwigExtension(Di::get(CookieApi::class));
    }
];

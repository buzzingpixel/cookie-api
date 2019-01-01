<?php
declare(strict_types=1);

use buzzingpixel\cookieapi\CookieApi;

return [
    CookieApi::class => function () {
        return new CookieApi($_COOKIE);
    }
];

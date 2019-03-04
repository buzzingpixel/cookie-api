<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

use buzzingpixel\cookieapi\CookieApi;
use Psr\Container\ContainerInterface;
use buzzingpixel\cookieapi\CookieApiTwigExtension;

return [
    CookieApi::class => static function () {
        return new CookieApi(
            $_COOKIE,
            getenv('ENCRYPTION_KEY')
        );
    },
    CookieApiTwigExtension::class => static function (ContainerInterface $di) {
        return new CookieApiTwigExtension($di->get(CookieApi::class));
    }
];

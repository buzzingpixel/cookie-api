<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\cookieapi;

use Twig_Function;
use Twig_Extension;

class CookieApiTwigExtension extends Twig_Extension
{
    private $cookieApi;

    public function __construct(CookieApi $cookieApi)
    {
        $this->cookieApi = $cookieApi;
    }

    public function getFunctions()
    {
        return [
            new Twig_Function('makeCookie', [$this->cookieApi, 'makeCookie']),
            new Twig_Function('retrieveCookie', [$this->cookieApi, 'retrieveCookie']),
            new Twig_Function('saveCookie', [$this->cookieApi, 'saveCookie']),
            new Twig_Function('deleteCookie', [$this->cookieApi, 'deleteCookie']),
            new Twig_Function('deleteCookieByName', [$this->cookieApi, 'deleteCookieByName']),
        ];
    }
}

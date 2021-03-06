<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\cookieapi\interfaces;

use DateTimeInterface;

interface CookieApiInterface
{
    public function makeCookie(
        string $name,
        string $value,
        DateTimeInterface $expire = null,
        string $path = '/',
        string $domain = '',
        bool $secure = false,
        bool $httpOnly = true
    ): CookieInterface;

    /**
     * Retrieves a cookie by name
     * @param string $name
     * @return CookieInterface|null
     */
    public function retrieveCookie(string $name): ?CookieInterface;

    /**
     * Saves a cookie
     * @param CookieInterface $cookie
     */
    public function saveCookie(CookieInterface $cookie);

    /**
     * Deletes a cookie
     * @param CookieInterface $cookie
     */
    public function deleteCookie(CookieInterface $cookie);

    /**
     * Deletes a cookie by name
     * @param string $name
     */
    public function deleteCookieByName(string $name);
}

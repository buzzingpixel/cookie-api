<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\cookieapi\interfaces;

use DateTime;
use buzzingpixel\cookieapi\EncryptionKeyException;

interface CookieApiInterface
{
    /**
     * CookieApiInterface constructor
     * @param array $cookies
     * @param string $encryptionKey
     * @throws EncryptionKeyException
     */
    public function __construct(array &$cookies, string $encryptionKey);

    public function makeCookie(
        string $name,
        string $value,
        DateTime $expire = null,
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

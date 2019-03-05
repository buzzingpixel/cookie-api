<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\cookieapi\interfaces;

use DateTime;
use DateTimeInterface;

interface CookieInterface
{
    /**
     * CookieInterface constructor
     * @param string $name Required
     * @param string $value Required
     * @param DateTimeInterface|null $expire Optional
     * @param string $path Optional
     * @param string $domain Optional
     * @param bool $secure Optional
     * @param bool $httpOnly Optional
     */
    public function __construct(
        string $name,
        string $value,
        ?DateTimeInterface $expire = null,
        string $path = '/',
        string $domain = '',
        bool $secure = false,
        bool $httpOnly = true
    );

    /**
     * Gets the cookie's name
     * @return string
     */
    public function name(): string;

    /**
     * Returns a new CookieInterface with the new name
     * @param string $name
     * @return CookieInterface
     */
    public function withName(string $name): CookieInterface;

    /**
     * Returns the cookie's value.
     * @return string
     */
    public function value(): string;

    /**
     * Returns a new CookieInterface with the new value
     * @param string $value
     * @return CookieInterface
     */
    public function withValue(string $value): CookieInterface;

    /**
     * Returns the expiration DateTime of the cookie. If no DateTime was ever
     * set, a default future value should be specified.
     * @return DateTimeInterface
     */
    public function expire(): DateTimeInterface;

    /**
     * Returns a new CookieInterface with the new expire
     * @param DateTimeInterface $expire
     * @return CookieInterface
     */
    public function withExpire(DateTimeInterface $expire): CookieInterface;

    /**
     * Returns the cookie's path.
     * @return string
     */
    public function path(): string;

    /**
     * Returns a new CookieInterface with the new path
     * @param string $path
     * @return CookieInterface
     */
    public function withPath(string $path): CookieInterface;

    /**
     * Returns the cookie's domain.
     * @return string
     */
    public function domain(): string;

    /**
     * Returns a new CookieInterface with the new domain
     * @param string $domain
     * @return CookieInterface
     */
    public function withDomain(string $domain): CookieInterface;

    /**
     * Returns whether the cookie is secure.
     * @return bool
     */
    public function secure(): bool;

    /**
     * Returns a new CookieInterface with the new secure setting
     * @param bool $secure
     * @return CookieInterface
     */
    public function withSecure(bool $secure): CookieInterface;

    /**
     * Returns whether the cookie is http only.
     * be set.
     * @return bool
     */
    public function httpOnly(): bool;

    /**
     * Returns a new CookieInterface with the new http only setting
     * @param bool $httpOnly
     * @return CookieInterface
     */
    public function withHttpOnly(bool $httpOnly): CookieInterface;
}

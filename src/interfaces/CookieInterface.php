<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\cookieapi\interfaces;

use DateTime;

interface CookieInterface
{
    /**
     * CookieInterface constructor
     * @param string $name Required
     * @param string $value Required
     * @param DateTime|null $expire Optional
     * @param string $path Optional
     * @param string $domain Optional
     * @param bool $secure Optional
     * @param bool $httpOnly Optional
     */
    public function __construct(
        string $name,
        string $value,
        ?DateTime $expire = null,
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
     * Returns the cookie's value.
     * @return string
     */
    public function value(): string;

    /**
     * Returns the expiration DateTime of the cookie. If no DateTime was ever
     * set, a default future value should be specified.
     * @return DateTime
     */
    public function expire(): DateTime;

    /**
     * Returns the cookie's path.
     * @return string
     */
    public function path(): string;

    /**
     * Returns the cookie's domain.
     * @return string
     */
    public function domain(): string;

    /**
     * Returns whether the cookie is secure.
     * be set.
     * @return bool
     */
    public function secure(): bool;

    /**
     * Returns whether the cookie is http only.
     * be set.
     * @return bool
     */
    public function httpOnly(): bool;
}

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
     * Returns the cookie's value. If incoming string, value will be set.
     * @param string|null $val
     * @return string
     */
    public function value(?string $val = null): string;

    /**
     * Returns the expiration DateTime of the cookie. If no DateTime was ever
     * set, a default future value should be specified. If incoming DateTime
     * object, expire will be set
     * @param DateTime|null $expire
     * @return DateTime
     */
    public function expire(?DateTime $expire = null): DateTime;

    /**
     * Returns the cookie's path. If incoming string, value will be set.
     * @param string|null $val
     * @return string
     */
    public function path(?string $path = null): string;

    /**
     * Returns the cookie's domain. If incoming string, value will be set.
     * @param string|null $val
     * @return string
     */
    public function domain(?string $domain = null): string;

    /**
     * Returns whether the cookie is secure. If incoming boolean, value will
     * be set.
     * @param bool|null $secure
     * @return bool
     */
    public function secure(?bool $secure = null): bool;

    /**
     * Returns whether the cookie is http only. If incoming boolean, value will
     * be set.
     * @param bool|null $httpOnly
     * @return bool
     */
    public function httpOnly(?bool $httpOnly = null): bool;
}

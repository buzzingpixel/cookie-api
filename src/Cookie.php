<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\cookieapi;

use DateTime;
use buzzingpixel\cookieapi\interfaces\CookieInterface;

class Cookie implements CookieInterface
{
    public function __construct(
        string $name,
        string $value,
        ?DateTime $expire = null,
        string $path = '/',
        string $domain = '',
        bool $secure = false,
        bool $httpOnly = true
    ) {
        if (! $expire) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $expire = new DateTime();
            $expire->setTimestamp(strtotime('+20 years'));
        }

        $this->name = $name;
        $this->value = $value;
        $this->expire = $expire;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->httpOnly = $httpOnly;
    }

    private $name;

    public function name(): string
    {
        return $this->name;
    }

    private $value;

    public function value(): string
    {
        return $this->value;
    }

    private $expire;

    public function expire(): DateTime
    {
        return $this->expire;
    }

    private $path;

    public function path(): string
    {
        return $this->path;
    }

    private $domain;

    public function domain(): string
    {
        return $this->domain;
    }

    private $secure = false;

    public function secure(): bool
    {
        return $this->secure;
    }

    private $httpOnly = true;

    public function httpOnly(): bool
    {
        return $this->httpOnly;
    }
}

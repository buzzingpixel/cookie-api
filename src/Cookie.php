<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\cookieapi;

use DateTimeZone;
use LogicException;
use DateTimeImmutable;
use DateTimeInterface;
use buzzingpixel\cookieapi\interfaces\CookieInterface;

class Cookie implements CookieInterface
{
    private $isInitialized = false;

    public function __construct(
        string $name,
        string $value,
        ?DateTimeInterface $expire = null,
        string $path = '/',
        string $domain = '',
        bool $secure = false,
        bool $httpOnly = true
    ) {
        if ($this->isInitialized) {
            throw new LogicException('Cookie can only be initialized once');
        }

        if ($expire) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $expire = (new DateTimeImmutable())
                ->setTimestamp($expire->getTimestamp())
                ->setTimezone(
                    new DateTimeZone($expire->getTimezone()->getName())
                );
        }

        if (! $expire) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $expire = (new DateTimeImmutable())
                ->setTimestamp(strtotime('+20 years'));
        }

        $this->name = $name;
        $this->value = $value;
        $this->expire = $expire;
        $this->path = $path;
        $this->domain = $domain;
        $this->secure = $secure;
        $this->httpOnly = $httpOnly;

        $this->isInitialized = true;
    }

    final public function __set($name, $value)
    {
        throw new LogicException('Setting properties is not allowed');
    }

    final public function __unset($name)
    {
        throw new LogicException('Setting properties is not allowed');
    }

    final public function offsetSet()
    {
        throw new LogicException('Setting properties is not allowed');
    }

    final public function offsetUnset()
    {
        throw new LogicException('Setting properties is not allowed');
    }

    private $name;

    public function name(): string
    {
        return $this->name;
    }

    public function withName(string $name): CookieInterface
    {
        $clone = clone $this;
        $clone->name = $name;
        return $clone;
    }

    private $value;

    public function value(): string
    {
        return $this->value;
    }

    public function withValue(string $value): CookieInterface
    {
        $clone = clone $this;
        $clone->value = $value;
        return $clone;
    }

    private $expire;

    public function expire(): DateTimeInterface
    {
        return $this->expire;
    }

    public function withExpire(DateTimeInterface $expire): CookieInterface
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $expire = (new DateTimeImmutable())
            ->setTimestamp($expire->getTimestamp())
            ->setTimezone(
                new DateTimeZone($expire->getTimezone()->getName())
            );

        $clone = clone $this;
        $clone->expire = $expire;
        return $clone;
    }

    private $path;

    public function path(): string
    {
        return $this->path;
    }

    public function withPath(string $path): CookieInterface
    {
        $clone = clone $this;
        $clone->path = $path;
        return $clone;
    }

    private $domain;

    public function domain(): string
    {
        return $this->domain;
    }

    public function withDomain(string $domain): CookieInterface
    {
        $clone = clone $this;
        $clone->domain = $domain;
        return $clone;
    }

    private $secure = false;

    public function secure(): bool
    {
        return $this->secure;
    }

    public function withSecure(bool $secure): CookieInterface
    {
        $clone = clone $this;
        $clone->secure = $secure;
        return $clone;
    }

    private $httpOnly = true;

    public function httpOnly(): bool
    {
        return $this->httpOnly;
    }

    public function withHttpOnly(bool $httpOnly): CookieInterface
    {
        $clone = clone $this;
        $clone->httpOnly = $httpOnly;
        return $clone;
    }
}

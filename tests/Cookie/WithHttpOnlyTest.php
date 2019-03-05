<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\tests\Cookie;

use PHPUnit\Framework\TestCase;
use buzzingpixel\cookieapi\Cookie;

class WithHttpOnlyTest extends TestCase
{
    public function test()
    {
        $cookie = new Cookie(
            'TestName',
            'TestValue',
            null,
            'PathTest',
            'DomainTest',
            true,
            false
        );

        $newCookie = $cookie->withHttpOnly(true);

        self::assertEquals('TestName', $cookie->name());

        self::assertEquals('TestName', $newCookie->name());

        self::assertFalse($cookie->httpOnly());

        self::assertTrue($newCookie->httpOnly());
    }
}

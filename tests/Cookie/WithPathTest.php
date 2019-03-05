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

class WithPathTest extends TestCase
{
    public function test()
    {
        $cookie = new Cookie(
            'TestName',
            'TestValue',
            null,
            'PathTest'
        );

        $newCookie = $cookie->withPath('newPath');

        self::assertEquals('TestName', $cookie->name());

        self::assertEquals('TestName', $newCookie->name());

        self::assertEquals('PathTest', $cookie->path());

        self::assertEquals('newPath', $newCookie->path());
    }
}

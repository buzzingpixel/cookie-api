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

class WithNameTest extends TestCase
{
    public function test()
    {
        $cookie = new Cookie(
            'TestName',
            'TestValue'
        );

        $newCookie = $cookie->withName('NewName');

        self::assertEquals('TestName', $cookie->name());

        self::assertEquals('NewName', $newCookie->name());
    }
}

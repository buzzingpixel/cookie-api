<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\tests\Cookie;

use DateTime;
use PHPUnit\Framework\TestCase;
use buzzingpixel\cookieapi\Cookie;

class BasicTest extends TestCase
{
    public function test()
    {
        $cookie = new Cookie(
            'TestName',
            'TestValue'
        );

        /** @noinspection PhpUnhandledExceptionInspection */
        $testDateTime = new DateTime();
        $testDateTime->setTimestamp(strtotime('+20 years'));

        self::assertEquals('TestName', $cookie->name());

        self::assertEquals('TestValue', $cookie->value());

        self::assertEquals(
            $testDateTime->getTimestamp(),
            $cookie->expire()->getTimestamp()
        );

        self::assertEquals('/', $cookie->path());

        self::assertEquals('', $cookie->domain());

        self::assertFalse($cookie->secure());

        self::assertTrue($cookie->httpOnly());
    }
}

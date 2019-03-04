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

class CookieWithPathTest extends TestCase
{
    public function test()
    {
        $testPath = '/test/path';

        /** @noinspection PhpUnhandledExceptionInspection */
        $testDateTime = new DateTime();
        $testDateTime->setTimestamp(strtotime('+5 years'));

        $cookie = new Cookie(
            'TestName',
            'TestValue',
            $testDateTime,
            $testPath
        );

        self::assertEquals('TestName', $cookie->name());

        self::assertEquals('TestValue', $cookie->value());

        self::assertEquals(
            $testDateTime->getTimestamp(),
            $cookie->expire()->getTimestamp()
        );

        self::assertEquals($testPath, $cookie->path());

        self::assertEquals('', $cookie->domain());

        self::assertFalse($cookie->secure());

        self::assertTrue($cookie->httpOnly());
    }
}

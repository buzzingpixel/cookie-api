<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\tests\Cookie;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use buzzingpixel\cookieapi\Cookie;

class WithExpireTest extends TestCase
{
    public function test()
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $dateTime = (new DateTimeImmutable())
            ->setTimestamp(strtotime('+5 years'));

        /** @noinspection PhpUnhandledExceptionInspection */
        $newDateTime = (new DateTimeImmutable())
            ->setTimestamp(strtotime('+10 years'));

        $cookie = new Cookie(
            'TestName',
            'TestValue',
            $dateTime
        );

        $newCookie = $cookie->withExpire($newDateTime);

        self::assertEquals('TestName', $cookie->name());

        self::assertEquals('TestName', $newCookie->name());

        self::assertEquals(
            $dateTime->getTimestamp(),
            $cookie->expire()->getTimestamp()
        );

        self::assertEquals(
            $newDateTime->getTimestamp(),
            $newCookie->expire()->getTimestamp()
        );
    }
}

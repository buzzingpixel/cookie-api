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
use buzzingpixel\cookieapi\CookieApi;
use buzzingpixel\cookieapi\PhpFunctions;

class MakeCookieBasicTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function test()
    {
        $cookies = [];

        $phpFunctions = $this->createMock(PhpFunctions::class);

        $phpFunctions->expects(self::once())
            ->method('strLen')
            ->with(self::equalTo('qwerty'))
            ->willReturn(10);

        $phpFunctions->expects(self::once())
            ->method('getSodiumCryptoSecretBoxKeyBytes')
            ->willReturn(10);

        /** @noinspection PhpParamsInspection */
        $cookieApi = new CookieApi($cookies, 'qwerty', $phpFunctions);

        $cookie = $cookieApi->makeCookie(
            'TestCookieName',
            'TestCookieValue'
        );

        /** @noinspection PhpUnhandledExceptionInspection */
        $testDateTime = new DateTime();
        $testDateTime->setTimestamp(strtotime('+20 years'));

        self::assertEquals('TestCookieName', $cookie->name());

        self::assertEquals('TestCookieValue', $cookie->value());

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

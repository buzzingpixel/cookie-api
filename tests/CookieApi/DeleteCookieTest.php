<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\tests\Cookie;

use PHPUnit\Framework\TestCase;
use buzzingpixel\cookieapi\CookieApi;
use buzzingpixel\cookieapi\PhpFunctions;
use buzzingpixel\cookieapi\interfaces\CookieInterface;

class DeleteCookieTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function test()
    {
        $cookies = [
            'cookieName' => 'foo',
        ];

        $phpFunctions = $this->createMock(PhpFunctions::class);

        $phpFunctions->expects(self::once())
            ->method('strLen')
            ->with(self::equalTo('zxcv'))
            ->willReturn(6);

        $phpFunctions->expects(self::once())
            ->method('getSodiumCryptoSecretBoxKeyBytes')
            ->willReturn(6);

        $phpFunctions->expects(self::once())
            ->method('setCookie')
            ->with(
                self::equalTo('cookieName'),
                self::equalTo(''),
                self::equalTo(-1)
            );

        /** @noinspection PhpParamsInspection */
        $cookieApi = new CookieApi($cookies, 'zxcv', $phpFunctions);

        $cookieMock = $this->createMock(CookieInterface::class);

        $cookieMock->expects(self::once())
            ->method('name')
            ->willReturn('cookieName');

        /** @noinspection PhpParamsInspection */
        $cookieApi->deleteCookie($cookieMock);

        self::assertEmpty($cookies);
    }
}

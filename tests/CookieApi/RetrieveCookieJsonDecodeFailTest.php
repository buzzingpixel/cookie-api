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

class RetrieveCookieJsonDecodeFailTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function test()
    {
        $cookies = [
            'foo' => 'bar',
        ];

        $phpFunctions = $this->createMock(PhpFunctions::class);

        $phpFunctions->expects(self::once())
            ->method('strLen')
            ->with(self::equalTo('12'))
            ->willReturn(2);

        $phpFunctions->expects(self::once())
            ->method('getSodiumCryptoSecretBoxKeyBytes')
            ->willReturn(2);

        $phpFunctions->expects(self::once())
            ->method('jsonDecode')
            ->with(
                self::equalTo('bar'),
                self::equalTo(true)
            )
            ->willReturn(false);

        /** @noinspection PhpParamsInspection */
        $cookieApi = new CookieApi($cookies, '12', $phpFunctions);

        self::assertNull($cookieApi->retrieveCookie('foo'));
    }
}

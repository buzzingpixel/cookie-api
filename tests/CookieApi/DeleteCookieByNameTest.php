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

class DeleteCookieByNameTest extends TestCase
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
            ->with(self::equalTo('baz'))
            ->willReturn(6);

        $phpFunctions->expects(self::once())
            ->method('getSodiumCryptoSecretBoxKeyBytes')
            ->willReturn(6);

        $phpFunctions->expects(self::once())
            ->method('setCookie')
            ->with(
                self::equalTo('foo'),
                self::equalTo(''),
                self::equalTo(-1)
            );

        /** @noinspection PhpParamsInspection */
        $cookieApi = new CookieApi($cookies, 'baz', $phpFunctions);

        $cookieApi->deleteCookieByName('foo');

        self::assertEmpty($cookies);
    }
}

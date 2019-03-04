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

class RetrieveCookieNoExpireTimeTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function test()
    {
        $currentTimestamp = time();

        $cookieVal = [
            'nonce' => 'nonceVal',
            'value' => 'valueValue',
            // 'expire' => 123456,
            'path' => '/pathValue',
            'domain' => '/domainValue',
            'secure' => true,
            'httpOnly' => false,
        ];

        $cookies = [
            'foo' => 'baz',
        ];

        $phpFunctions = $this->createMock(PhpFunctions::class);

        $phpFunctions->expects(self::once())
            ->method('strLen')
            ->with(self::equalTo('poiuytrewq'))
            ->willReturn(2);

        $phpFunctions->expects(self::once())
            ->method('getSodiumCryptoSecretBoxKeyBytes')
            ->willReturn(2);

        $phpFunctions->expects(self::once())
            ->method('jsonDecode')
            ->with(
                self::equalTo('baz'),
                self::equalTo(true)
            )
            ->willReturn($cookieVal);

        $phpFunctions->expects(self::once())
            ->method('time')
            ->willReturn($currentTimestamp);

        $phpFunctions->expects(self::at(4))
            ->method('base64Decode')
            ->with(self::equalTo('valueValue'))
            ->willReturn('base64DecodeCookieValue');

        $phpFunctions->expects(self::at(5))
            ->method('base64Decode')
            ->with(self::equalTo('nonceVal'))
            ->willReturn('base64DecodeNonceValue');

        $phpFunctions->expects(self::once())
            ->method('sodiumCryptoSecretBoxOpen')
            ->with(
                self::equalTo('base64DecodeCookieValue'),
                self::equalTo('base64DecodeNonceValue'),
                self::equalTo('poiuytrewq')
            )
            ->willReturn('sodiumCryptoSecretBoxOpenValueReturn');

        /** @noinspection PhpParamsInspection */
        $cookieApi = new CookieApi($cookies, 'poiuytrewq', $phpFunctions);

        $cookie = $cookieApi->retrieveCookie('foo');

        self::assertInstanceOf(CookieInterface::class, $cookie);

        self::assertEquals('foo', $cookie->name());

        self::assertEquals('sodiumCryptoSecretBoxOpenValueReturn', $cookie->value());

        self::assertEquals($currentTimestamp, $cookie->expire()->getTimestamp());

        self::assertEquals('/pathValue', $cookie->path());

        self::assertEquals('/domainValue', $cookie->domain());

        self::assertTrue($cookie->secure());

        self::assertFalse($cookie->httpOnly());
    }
}

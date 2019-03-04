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

class RetrieveCookieNoValuesTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function test()
    {
        $currentTimestamp = time();

        $cookieVal = [
            'foo' => 'bar',
            // 'nonce' => 'nonceVal',
            // 'value' => 'valueValue',
            // 'expire' => 123456,
            // 'path' => '/pathValue',
            // 'domain' => '/domainValue',
            // 'secure' => true,
            // 'httpOnly' => false,
        ];

        $cookies = [
            'baz' => 'foo',
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
                self::equalTo('foo'),
                self::equalTo(true)
            )
            ->willReturn($cookieVal);

        $phpFunctions->expects(self::once())
            ->method('time')
            ->willReturn($currentTimestamp);

        $phpFunctions->expects(self::at(4))
            ->method('base64Decode')
            ->with(self::equalTo(''))
            ->willReturn('base64DecodeCookieValue');

        $phpFunctions->expects(self::at(5))
            ->method('base64Decode')
            ->with(self::equalTo(''))
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

        $cookie = $cookieApi->retrieveCookie('baz');

        self::assertInstanceOf(CookieInterface::class, $cookie);

        self::assertEquals('baz', $cookie->name());

        self::assertEquals('sodiumCryptoSecretBoxOpenValueReturn', $cookie->value());

        self::assertEquals($currentTimestamp, $cookie->expire()->getTimestamp());

        self::assertEquals('', $cookie->path());

        self::assertEquals('', $cookie->domain());

        self::assertFalse($cookie->secure());

        self::assertTrue($cookie->httpOnly());
    }
}

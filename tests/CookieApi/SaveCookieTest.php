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
use buzzingpixel\cookieapi\interfaces\CookieInterface;

class SaveCookieTest extends TestCase
{
    /**
     * @throws \Throwable
     */
    public function test()
    {
        $dateTime = new DateTime();
        $dateTime->setTimestamp(1234567);

        $cookies = [];

        $phpFunctions = $this->createMock(PhpFunctions::class);

        $phpFunctions->expects(self::once())
            ->method('strLen')
            ->with(self::equalTo('12'))
            ->willReturn(5);

        $phpFunctions->expects(self::once())
            ->method('getSodiumCryptoSecretBoxKeyBytes')
            ->willReturn(5);

        $phpFunctions->expects(self::once())
            ->method('getSodiumCryptoSecretBoxNOnceBytes')
            ->willReturn(9);

        $phpFunctions->expects(self::once())
            ->method('randomBytes')
            ->with(self::equalTo(9))
            ->willReturn('nonceRandomBytes');

        $phpFunctions->expects(self::at(4))
            ->method('base64Encode')
            ->with(self::equalTo('nonceRandomBytes'))
            ->willReturn('base64EncodeNonceRandomBytes');

        $phpFunctions->expects(self::once())
            ->method('sodiumCryptoSecretBox')
            ->with(
                self::equalTo('cookieValue'),
                self::equalTo('nonceRandomBytes'),
                '12'
            )
            ->willReturn('base64EncodeSecretBoxCookieValue');

        $phpFunctions->expects(self::at(6))
            ->method('base64Encode')
            ->with(self::equalTo('base64EncodeSecretBoxCookieValue'))
            ->willReturn('base64EncodeCookieValue');

        $phpFunctions->expects(self::once())
            ->method('jsonEncode')
            ->with(self::equalTo([
                'nonce' => 'base64EncodeNonceRandomBytes',
                'value' => 'base64EncodeCookieValue',
                'expire' => $dateTime->getTimestamp(),
                'path' => 'cookiePath',
                'domain' => 'cookieDomain',
                'secure' => true,
                'httpOnly' => false,
            ]))
            ->willReturn('jsonEncodedSaveValue');

        $phpFunctions->expects(self::once())
            ->method('setCookie')
            ->with(
                self::equalTo('cookieName'),
                self::equalTo('jsonEncodedSaveValue'),
                self::equalTo($dateTime->getTimestamp()),
                self::equalTo('cookiePath'),
                self::equalTo('cookieDomain'),
                self::equalTo(true),
                self::equalTo(false)
            );

        /** @noinspection PhpParamsInspection */
        $cookieApi = new CookieApi($cookies, '12', $phpFunctions);

        $cookieMock = $this->createMock(CookieInterface::class);

        $cookieMock->method('name')->willReturn('cookieName');

        $cookieMock->method('value')->willReturn('cookieValue');

        $cookieMock->method('expire')->willReturn($dateTime);

        $cookieMock->method('path')->willReturn('cookiePath');

        $cookieMock->method('domain')->willReturn('cookieDomain');

        $cookieMock->method('secure')->willReturn(true);

        $cookieMock->method('httpOnly')->willReturn(false);

        /** @noinspection PhpParamsInspection */
        $cookieApi->saveCookie($cookieMock);

        self::assertEquals($cookies['cookieName'], 'jsonEncodedSaveValue');
    }
}

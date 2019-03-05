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
use buzzingpixel\cookieapi\EncryptionKeyException;

class WrongKeyBytesLengthTest extends TestCase
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
            ->with(self::equalTo('12'))
            ->willReturn(2);

        $phpFunctions->expects(self::once())
            ->method('getSodiumCryptoSecretBoxKeyBytes')
            ->willReturn(3);

        $exception = null;

        try {
            /** @noinspection PhpParamsInspection */
            new CookieApi($cookies, '12', $phpFunctions);
        } catch (EncryptionKeyException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(EncryptionKeyException::class, $exception);
    }
}

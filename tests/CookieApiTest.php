<?php
declare(strict_types=1);

namespace buzzingpixel\tests;

use PHPUnit\Framework\TestCase;
use buzzingpixel\cookieapi\CookieApi;

class CookieApiTest extends TestCase
{
    private function getCookieArray(): array
    {
        return [
            'TestCookie1' => json_encode([
                'value' => 'Test Value 1',
                'expire' => 2177537058,
                'path' => '/asdf/test',
                'domain' => 'buzzingpixel.com',
                'secure' => false,
                'httpOnly' => true,
            ]),
            'TestCookie2' => json_encode([
                'value' => 'Test Value 2',
                'expire' => 2177037058,
                'path' => '/',
                'domain' => '',
                'secure' => true,
                'httpOnly' => false,
            ]),
            'TestCookie3' => 'asdf',
        ];
    }

    public function testMakeCookie()
    {
        $cookieActual = $this->getCookieArray();

        $cookieApi = new CookieApi($cookieActual);

        $testCookie = $cookieApi->makeCookie('TestCookie', 'TestValue');

        self::assertEquals($testCookie->name(), 'TestCookie');
        self::assertEquals($testCookie->value(), 'TestValue');
    }

    public function testRetrieveCookie()
    {
        $cookieActual = $this->getCookieArray();

        $cookieApi = new CookieApi($cookieActual);

        $cookieNull = $cookieApi->retrieveCookie('sdf');
        self::assertNull($cookieNull);

        $cookie1 = $cookieApi->retrieveCookie('TestCookie1');
        self::assertEquals('TestCookie1', $cookie1->name());
        self::assertEquals('Test Value 1', $cookie1->value());
        self::assertEquals(2177537058, $cookie1->expire()->getTimestamp());
        self::assertEquals('/asdf/test', $cookie1->path());
        self::assertEquals('buzzingpixel.com', $cookie1->domain());
        self::assertFalse($cookie1->secure());
        self::assertTrue($cookie1->httpOnly());

        $cookie2 = $cookieApi->retrieveCookie('TestCookie2');
        self::assertEquals('TestCookie2', $cookie2->name());
        self::assertEquals('Test Value 2', $cookie2->value());
        self::assertEquals(2177037058, $cookie2->expire()->getTimestamp());
        self::assertEquals('/', $cookie2->path());
        self::assertIsString($cookie2->domain());
        self::assertEquals('', $cookie2->domain());
        self::assertTrue($cookie2->secure());
        self::assertFalse($cookie2->httpOnly());

        $cookie3 = $cookieApi->retrieveCookie('TestCookie3');
        self::assertNull($cookie3);
    }
}

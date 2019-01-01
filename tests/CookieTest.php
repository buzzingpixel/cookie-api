<?php
declare(strict_types=1);

namespace buzzingpixel\tests;

use PHPUnit\Framework\TestCase;
use buzzingpixel\cookieapi\Cookie;

class CookieTest extends TestCase
{
    public function testCookieEntityNoArgs()
    {
        self::expectException('ArgumentCountError');
        new Cookie();
    }

    public function testCookieEntity1Args()
    {
        self::expectException('ArgumentCountError');
        new Cookie('TestName');
    }

    public function testCookieEntityDefaultValues()
    {
        $expire = new \DateTime();
        $expire->setTimestamp(strtotime('+20 years'));

        $cookie = new Cookie('TestName', 'TestValue');

        self::assertEquals('TestName', $cookie->name());
        self::assertEquals('TestValue', $cookie->value());
        self::assertEquals($expire->getTimestamp(), $cookie->expire()->getTimestamp());
        self::assertEquals('/', $cookie->path());
        self::assertIsString($cookie->domain());
        self::assertEquals('', $cookie->domain());
        self::assertFalse($cookie->secure());
        self::assertTrue($cookie->httpOnly());
    }

    public function testCookieEntityValues()
    {
        $expire = new \DateTime();
        $expire->setTimestamp(strtotime('+10 years'));

        $cookie = new Cookie('TestName', 'TestValue');

        self::assertEquals('Thingy', $cookie->value('Thingy'));
        self::assertEquals('Thingy', $cookie->value());

        self::assertEquals($expire->getTimestamp(), $cookie->expire($expire)->getTimestamp());
        self::assertEquals($expire->getTimestamp(), $cookie->expire()->getTimestamp());

        self::assertEquals('/asdf/thing', $cookie->path('/asdf/thing'));
        self::assertEquals('/asdf/thing', $cookie->path());

        self::assertEquals('buzzingpixel.com', $cookie->domain('buzzingpixel.com'));
        self::assertEquals('buzzingpixel.com', $cookie->domain());

        self::assertTrue($cookie->secure(true));
        self::assertTrue($cookie->secure());
        self::assertFalse($cookie->secure(false));
        self::assertFalse($cookie->secure());

        self::assertTrue($cookie->httpOnly(true));
        self::assertTrue($cookie->httpOnly());
        self::assertFalse($cookie->httpOnly(false));
        self::assertFalse($cookie->httpOnly());
    }
}

<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\tests\Cookie;

use PHPUnit\Framework\TestCase;
use buzzingpixel\cookieapi\Cookie;

class WithDomainTest extends TestCase
{
    public function test()
    {
        $cookie = new Cookie(
            'TestName',
            'TestValue',
            null,
            'PathTest',
            'DomainTest'
        );

        $newCookie = $cookie->withDomain('newDomain');

        self::assertEquals('TestName', $cookie->name());

        self::assertEquals('TestName', $newCookie->name());

        self::assertEquals('DomainTest', $cookie->domain());

        self::assertEquals('newDomain', $newCookie->domain());
    }
}

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
use buzzingpixel\cookieapi\Cookie;

class IsInitializedExceptionTest extends TestCase
{
    public function test()
    {
        $cookie = new Cookie(
            'TestName',
            'TestValue'
        );

        $exception = null;

        try {
            $cookie->__construct('Foo', 'Bar');
        } catch (\LogicException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(\LogicException::class, $exception);
    }
}

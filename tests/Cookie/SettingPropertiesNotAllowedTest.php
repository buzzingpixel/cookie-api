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

class SettingPropertiesNotAllowedTest extends TestCase
{
    public function test()
    {
        $cookie = new Cookie(
            'TestName',
            'TestValue'
        );

        $exception = null;

        try {
            $cookie->someProp = 'asdf';
        } catch (\LogicException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(\LogicException::class, $exception);

        /**********************************************************************/

        $exception = null;

        try {
            $cookie->isInitialized = false;
        } catch (\LogicException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(\LogicException::class, $exception);

        /**********************************************************************/

        $exception = null;

        try {
            $cookie->__set('asdf', 'val');
        } catch (\LogicException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(\LogicException::class, $exception);

        /**********************************************************************/

        $exception = null;

        try {
            $cookie->__set('value', 'val');
        } catch (\LogicException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(\LogicException::class, $exception);

        /**********************************************************************/

        $exception = null;

        try {
            $cookie->__unset('value');
        } catch (\LogicException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(\LogicException::class, $exception);

        /**********************************************************************/

        $exception = null;

        try {
            unset($cookie->value);
        } catch (\LogicException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(\LogicException::class, $exception);

        /**********************************************************************/

        $exception = null;

        try {
            $cookie->offsetSet(2);
        } catch (\LogicException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(\LogicException::class, $exception);

        /**********************************************************************/

        $exception = null;

        try {
            $cookie->offsetUnset(2);
        } catch (\LogicException $e) {
            $exception = $e;
        }

        self::assertInstanceOf(\LogicException::class, $exception);
    }
}

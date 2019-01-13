<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

/**
 * This file is for testing purposes only
 */

use corbomite\di\Di;
use buzzingpixel\cookieapi\CookieApi;

define('APP_BASE_PATH', dirname(__DIR__));

require_once APP_BASE_PATH . '/vendor/autoload.php';

putenv('ENCRYPTION_KEY=1234567890qwertyuiopasdfghjklzxc');

$cookieApi = Di::get(CookieApi::class);

// $cookieApi->saveCookie($cookieApi->makeCookie('testCookie', 'testValue'));

// var_dump($cookieApi->retrieveCookie('testCookie'));
// die;

// $cookieApi->saveCookie($cookieApi->makeCookie('newCookie2', 'newVal'));

var_dump($cookieApi->retrieveCookie('newCookie2'));
die;

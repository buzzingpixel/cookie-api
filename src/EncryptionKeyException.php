<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\cookieapi;

use Throwable;
use Exception;

class EncryptionKeyException extends Exception
{
    public function __construct(
        string $message = 'ENCRYPTION_KEY environment variable must be defined and must be exactly ' .
        SODIUM_CRYPTO_SECRETBOX_KEYBYTES .
        ' characters in length',
        int $code = 500,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

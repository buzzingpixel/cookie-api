<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\cookieapi;

use function strlen;
use function setcookie;
use function json_decode;
use function json_encode;
use function random_bytes;
use function base64_decode;
use function base64_encode;
use function sodium_crypto_secretbox;
use function sodium_crypto_secretbox_open;

class PhpFunctions
{
    public function setCookie(
        $name,
        $value = '',
        $expire = 0,
        $path = '',
        $domain = '',
        $secure = false,
        $httpOnly = false
    ) {
        return setcookie(
            $name,
            $value,
            $expire,
            $path,
            $domain,
            $secure,
            $httpOnly
        );
    }

    public function strLen($str)
    {
        return strlen($str);
    }

    public function jsonEncode($value, $options = 0, $depth = 512)
    {
        return json_encode($value, $options, $depth);
    }

    public function jsonDecode(
        $json,
        $assoc = false,
        $depth = 512,
        $options = 0
    ) {
        return json_decode($json, $assoc, $depth, $options);
    }

    public function base64Encode($data)
    {
        return base64_encode($data);
    }

    public function base64Decode($data, $strict = null)
    {
        if ($strict !== null) {
            return base64_decode($data, $strict);
        }

        return base64_decode($data);
    }

    public function randomBytes($length)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return random_bytes($length);
    }

    public function getSodiumCryptoSecretBoxKeyBytes()
    {
        return SODIUM_CRYPTO_SECRETBOX_KEYBYTES;
    }

    public function getSodiumCryptoSecretBoxNOnceBytes()
    {
        return SODIUM_CRYPTO_SECRETBOX_NONCEBYTES;
    }

    public function sodiumCryptoSecretBox(
        string $plaintext,
        string $nonce,
        string $key
    ) {
        return sodium_crypto_secretbox($plaintext, $nonce, $key);
    }

    public function sodiumCryptoSecretBoxOpen(
        string $cipherText,
        string $nonce,
        string $key
    ) {
        return sodium_crypto_secretbox_open($cipherText, $nonce, $key);
    }
}

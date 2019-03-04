<?php
declare(strict_types=1);

/**
 * @author TJ Draper <tj@buzzingpixel.com>
 * @copyright 2019 BuzzingPixel, LLC
 * @license Apache-2.0
 */

namespace buzzingpixel\cookieapi;

use DateTime;
use Throwable;
use buzzingpixel\cookieapi\interfaces\CookieInterface;
use buzzingpixel\cookieapi\interfaces\CookieApiInterface;

class CookieApi implements CookieApiInterface
{
    private $cookies;
    private $encryptionKey;

    public function __construct(array &$cookies, string $encryptionKey)
    {
        $this->encryptionKey = $encryptionKey;

        if (! $this->encryptionKey ||
            strlen($this->encryptionKey) !== SODIUM_CRYPTO_SECRETBOX_KEYBYTES
        ) {
            throw new EncryptionKeyException();
        }

        $this->cookies = $cookies;
    }

    public function makeCookie(
        string $name,
        string $value,
        DateTime $expire = null,
        string $path = '/',
        string $domain = '',
        bool $secure = false,
        bool $httpOnly = true
    ): CookieInterface {
        return new Cookie(
            $name,
            $value,
            $expire,
            $path,
            $domain,
            $secure,
            $httpOnly
        );
    }

    public function retrieveCookie(string $name): ?CookieInterface
    {
        $cookieActual = $this->cookies[$name] ?? null;

        if (! $cookieActual) {
            return null;
        }

        $cookieDecode = json_decode($cookieActual, true);

        if (! $cookieDecode) {
            return null;
        }

        $cookieExpireTimeStamp = $cookieDecode['expire'] ?? time();

        /** @noinspection PhpUnhandledExceptionInspection */
        $dateTime = new DateTime();
        $dateTime->setTimestamp($cookieExpireTimeStamp);

        try {
            $value = base64_decode($cookieDecode['value'] ?? '');
            $nonce = base64_decode($cookieDecode['nonce'] ?? '');
            $value = sodium_crypto_secretbox_open(
                $value,
                $nonce,
                $this->encryptionKey
            );
        } catch (Throwable $e) {
            $value = '';
        }

        $cookieModel = $this->makeCookie(
            $name,
            (string) $value,
            $dateTime,
            (string) ($cookieDecode['path'] ?? ''),
            (string) ($cookieDecode['domain'] ?? ''),
            (bool) ($cookieDecode['secure'] ?? false),
            (bool) ($cookieDecode['httpOnly'] ?? true)
        );

        return $cookieModel;
    }

    public function saveCookie(CookieInterface $cookie): void
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

        $saveValue = json_encode([
            'nonce' => base64_encode($nonce),
            'value' => base64_encode(sodium_crypto_secretbox(
                $cookie->value(),
                $nonce,
                $this->encryptionKey
            )),
            'expire' => $cookie->expire()->getTimestamp(),
            'path' => $cookie->path(),
            'domain' => $cookie->domain(),
            'secure' => $cookie->secure(),
            'httpOnly' => $cookie->httpOnly(),
        ]);

        setcookie(
            $cookie->name(),
            $saveValue,
            $cookie->expire()->getTimestamp(),
            $cookie->path(),
            $cookie->domain(),
            $cookie->secure(),
            $cookie->httpOnly()
        );

        $this->cookies[$cookie->name()] = $saveValue;
    }

    public function deleteCookie(CookieInterface $cookie): void
    {
        $this->deleteCookieByName($cookie->name());
    }

    public function deleteCookieByName(string $name): void
    {
        unset($this->cookies[$name]);
        setcookie($name, '', -1);
    }
}

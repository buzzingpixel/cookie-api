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
    private $phpFunctions;

    /**
     * CookieApi constructor
     * @param array &$cookies
     * @param string $encryptionKey
     * @param PhpFunctions $phpFunctions
     * @throws EncryptionKeyException
     */
    public function __construct(
        array &$cookies,
        string $encryptionKey,
        PhpFunctions $phpFunctions
    ) {
        $this->cookies = &$cookies;
        $this->phpFunctions = $phpFunctions;
        $this->encryptionKey = $encryptionKey;

        $keyBytes = $this->phpFunctions->getSodiumCryptoSecretBoxKeyBytes();

        if (! $encryptionKey ||
            $this->phpFunctions->strLen($encryptionKey) !== $keyBytes
        ) {
            throw new EncryptionKeyException();
        }
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

        $cookieDecode = $this->phpFunctions->jsonDecode($cookieActual, true);

        if (! $cookieDecode) {
            return null;
        }

        $cookieExpireTimeStamp = $cookieDecode['expire'] ??
            $this->phpFunctions->time();

        /** @noinspection PhpUnhandledExceptionInspection */
        $dateTime = new DateTime();
        $dateTime->setTimestamp($cookieExpireTimeStamp);

        try {
            $value = $this->phpFunctions->base64Decode(
                $cookieDecode['value'] ?? ''
            );

            $nonce = $this->phpFunctions->base64Decode(
                $cookieDecode['nonce'] ?? ''
            );

            $value = $this->phpFunctions->sodiumCryptoSecretBoxOpen(
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
        $nonceBytes = $this->phpFunctions->getSodiumCryptoSecretBoxNOnceBytes();

        $nonce = $this->phpFunctions->randomBytes($nonceBytes);

        $nonceBase64 = $this->phpFunctions->base64Encode($nonce);

        $secretBox = $this->phpFunctions->sodiumCryptoSecretBox(
            $cookie->value(),
            $nonce,
            $this->encryptionKey
        );

        $secretBoxBase64 = $this->phpFunctions->base64Encode($secretBox);

        $saveValue = $this->phpFunctions->jsonEncode([
            'nonce' => $nonceBase64,
            'value' => $secretBoxBase64,
            'expire' => $cookie->expire()->getTimestamp(),
            'path' => $cookie->path(),
            'domain' => $cookie->domain(),
            'secure' => $cookie->secure(),
            'httpOnly' => $cookie->httpOnly(),
        ]);

        $this->phpFunctions->setCookie(
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
        $this->phpFunctions->setCookie($name, '', -1);
    }
}

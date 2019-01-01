<?php
declare(strict_types=1);

namespace buzzingpixel\cookieapi;

use DateTime;

class CookieApi
{
    private $cookies;

    public function __construct(array $cookies)
    {
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
    ): Cookie {
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

    public function retrieveCookie(string $name): ?Cookie
    {
        $cookieActual = $this->cookies[$name] ?? null;

        if (! $cookieActual) {
            return null;
        }

        $cookieDecode = json_decode($cookieActual, true);

        $cookieExpireTimeStamp = $cookieDecode['expire'] ?? time();

        $dateTime = new DateTime();
        $dateTime->setTimestamp($cookieExpireTimeStamp);

        $cookieModel = $this->makeCookie(
            $name,
            $cookieDecode['value'] ?? '',
            $dateTime,
            $cookieDecode['path'] ?? '',
            $cookieDecode['domain'] ?? '',
            (bool) ($cookieDecode['secure'] ?? false),
            (bool) ($cookieDecode['httpOnly'] ?? true)
        );

        return $cookieModel;
    }

    public function saveCookie(Cookie $cookie): void
    {
        setcookie(
            $cookie->name(),
            json_encode([
                'value' => $cookie->value(),
                'expire' => $cookie->expire()->getTimestamp(),
                'path' => $cookie->path(),
                'domain' => $cookie->domain(),
                'secure' => $cookie->secure(),
                'httpOnly' => $cookie->httpOnly(),
            ]),
            $cookie->expire()->getTimestamp(),
            $cookie->path(),
            $cookie->domain(),
            $cookie->secure(),
            $cookie->httpOnly()
        );
    }

    public function deleteCookie(Cookie $cookie): void
    {
        $this->deleteCookieByName($cookie->name());
    }

    public function deleteCookieByName(string $name): void
    {
        unset($this->cookies[$name]);
        setcookie($name, '', -1);
    }
}

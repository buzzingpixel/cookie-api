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
        $cookie = $this->cookies[$name] ?? null;

        if (! $cookie) {
            return null;
        }

        $cookieDecode = json_decode($cookie, true);

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

    public function saveCookie(CookieModel $cookieModel): void
    {
        setcookie(
            $cookieModel->name,
            json_encode([
                'value' => $cookieModel->value,
                'expire' => $cookieModel->expire->getTimestamp(),
                'path' => $cookieModel->path,
                'domain' => $cookieModel->domain,
                'secure' => $cookieModel->secure,
                'httpOnly' => $cookieModel->httpOnly,
            ]),
            $cookieModel->expire->getTimestamp(),
            $cookieModel->path,
            $cookieModel->domain,
            $cookieModel->secure,
            $cookieModel->httpOnly
        );
    }

    public function deleteCookie(CookieModel $cookieModel): void
    {
        $this->deleteCookieByName($cookieModel->name);
    }

    public function deleteCookieByName(string $name): void
    {
        unset($this->cookies[$name]);
        setcookie($name, '', -1);
    }
}

<?php

declare(strict_types=1);

namespace Core\Cookies;

use Core\Interfaces\Cookie;
use Core\Interfaces\CookieConfig;
use \Exception;

class CookiesNative implements Cookie
{

    use CookieConfigTrait;
    use CookieTrait;

    public function __construct(CookieConfig $cookieConfig)
    {
        $this->loadConfig($cookieConfig);
    }

    public function delete(string $name): bool
    {
        if (!$this->has($name)) {
            return false;
        }
        unset($_COOKIE[$name]);
        setcookie($name, '', [
            'expires' => -1,
            'path' => $this->path
        ]);
        return true;
    }

    public function get(string $name, string|null $default = null): string|null
    {
        if (isset($_COOKIE[$name])) {
            return $_COOKIE[$name];
        }
        return $default;
    }

    public function has(string $name): bool
    {
        if (isset($_COOKIE[$name])) {
            return true;
        }
        return false;
    }

    public function set(string $name, string $value): bool
    {
        if (empty($name)) {
            throw new Exception("CookiesNative::set() name is empty");
        }
        if (empty($value)) {
            throw new Exception("CookiesNative::set() value is empty");
        }
        return setcookie($name, $value, [
            'expires' => time() + $this->time,
            'path' => $this->path,
            'secure' => $this->isSecure,
            'domain' => $this->domain,
            'samesite' => $this->sameSite,
        ]);
    }

}

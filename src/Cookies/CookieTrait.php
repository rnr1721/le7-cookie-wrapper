<?php

declare(strict_types=1);

namespace Core\Cookies;

use Core\Interfaces\Cookie;
use Core\Interfaces\CookieConfig;

trait CookieTrait
{

    public function setDomain(string $domain): Cookie
    {
        $this->domain = $domain;
        return $this;
    }

    public function setHttpOnly(bool $httpOnly): Cookie
    {
        $this->httpOnly = $httpOnly;
        return $this;
    }

    public function setPath(string $path): Cookie
    {
        $this->path = $path;
        return $this;
    }

    public function setSecue(bool $secure): Cookie
    {
        $this->isSecure = $secure;
        return $this;
    }

    public function setTime(int $time): Cookie
    {
        $this->time = $time;
        return $this;
    }

    public function setSameSite(string $sameSite): Cookie
    {
        $this->sameSite = $sameSite;
        return $this;
    }

    public function loadConfig(CookieConfig $cookieConfig): void
    {
        $this->domain = $cookieConfig->getDomain();
        $this->httpOnly = $cookieConfig->getHttpOnly();
        $this->isSecure = $cookieConfig->getSecue();
        $this->path = $cookieConfig->getPath();
        $this->time = $cookieConfig->getTime();
        $this->sameSite = $cookieConfig->getSameSite();
    }

}

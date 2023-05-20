<?php

declare(strict_types=1);

namespace Core\Cookies;

use Core\Interfaces\CookieInterface;
use Core\Interfaces\CookieConfigInterface;

trait CookieTrait
{

    public function setDomain(string $domain): CookieInterface
    {
        $this->domain = $domain;
        return $this;
    }

    public function setHttpOnly(bool $httpOnly): CookieInterface
    {
        $this->httpOnly = $httpOnly;
        return $this;
    }

    public function setPath(string $path): CookieInterface
    {
        $this->path = $path;
        return $this;
    }

    public function setSecue(bool $secure): CookieInterface
    {
        $this->isSecure = $secure;
        return $this;
    }

    public function setTime(int $time): CookieInterface
    {
        $this->time = $time;
        return $this;
    }

    public function setSameSite(string $sameSite): CookieInterface
    {
        $this->sameSite = $sameSite;
        return $this;
    }

    public function loadConfig(CookieConfigInterface $cookieConfig): void
    {
        $this->domain = $cookieConfig->getDomain();
        $this->httpOnly = $cookieConfig->getHttpOnly();
        $this->isSecure = $cookieConfig->getSecue();
        $this->path = $cookieConfig->getPath();
        $this->time = $cookieConfig->getTime();
        $this->sameSite = $cookieConfig->getSameSite();
    }

}

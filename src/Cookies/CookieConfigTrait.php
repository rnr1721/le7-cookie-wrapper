<?php

declare(strict_types=1);

namespace Core\Cookies;

trait CookieConfigTrait
{

    private string $domain = '';
    private bool $httpOnly = false;
    private string $path = '';
    private bool $isSecure = false;
    private int $time = 0;
    private string $sameSite = 'Lax';

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getHttpOnly(): bool
    {
        return $this->httpOnly;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getSecue(): bool
    {
        return $this->isSecure;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function getSameSite(): string
    {
        return $this->sameSite;
    }

    public function setParams(array $params) : void
    {
        foreach ($params as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
    
}

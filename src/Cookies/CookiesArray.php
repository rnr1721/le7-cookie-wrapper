<?php

declare(strict_types=1);

namespace Core\Cookies;

use Core\Interfaces\CookieInterface;
use Core\Interfaces\CookieConfigInterface;
use \Exception;

class CookiesArray implements CookieInterface
{

    use CookieConfigTrait;
    use CookieTrait;

    private array $session = [];

    public function __construct(CookieConfigInterface $cookieConfig)
    {
        $this->loadConfig($cookieConfig);
    }

    public function delete(string $name): bool
    {
        if ($this->has($name)) {
            unset($this->session[$name]);
            return true;
        }
        return false;
    }

    public function get(string $name, string|null $default = null): string|null
    {
        if ($this->has($name)) {
            return $this->session[$name];
        }
        return $default;
    }

    public function has(string $name): bool
    {
        if (isset($this->session[$name])) {
            return true;
        }
        return false;
    }

    public function set(string $name, string $value): bool
    {
        if (empty($name)) {
            throw new Exception("CookiesArray::set() name is empty");
        }
        if (empty($value)) {
            throw new Exception("CookiesArray::set() value is empty");
        }
        $this->session[$name] = $value;
        return true;
    }

}

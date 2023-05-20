<?php

declare(strict_types=1);

namespace Core\Cookies;

use Core\Interfaces\CookieInterface;
use Core\Interfaces\CookieConfigInterface;
use Psr\SimpleCache\CacheInterface;
use \Exception;

class CookiesCache implements CookieInterface
{

    use CookieConfigTrait;
    use CookieTrait;

    private CacheInterface $cache;
    private string $browserId;

    public function __construct(
            CookieConfigInterface $cookieConfig,
            CacheInterface $cache,
            string $browserId
    )
    {
        $this->loadConfig($cookieConfig);
        $this->cache = $cache;
        $this->browserId = $browserId;
    }

    public function delete(string $name): bool
    {
        if ($this->has($name)) {
            $result = $this->cache->get($this->browserId);
            if (isset($result[$name])) {
                unset($result[$name]);
                $this->cache->set($this->browserId, $result);
                return true;
            }
        }
        return false;
    }

    public function get(string $name, string|null $default = null): string|null
    {
        if ($this->has($name)) {
            $result = $this->cache->get($this->browserId);
            if (isset($result[$name])) {
                return $result[$name];
            }
        }
        return $default;
    }

    public function has(string $name): bool
    {
        $result = $this->cache->get($this->browserId);
        if ($result && is_array($result)) {
            if (isset($result[$name])) {
                return true;
            }
        }
        return false;
    }

    public function set(string $name, string $value): bool
    {
        if (empty($name)) {
            throw new Exception("CookiesCache::set() name is empty");
        }
        if (empty($value)) {
            throw new Exception("CookiesCache::set() value is empty");
        }
        $result = $this->cache->get($this->browserId);
        if (!is_array($result)) {
            $result = [];
        }
        $result[$name] = $value;
        return $this->cache->set($this->browserId, $result);
    }

}

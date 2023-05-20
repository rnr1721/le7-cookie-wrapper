<?php

declare(strict_types=1);

namespace Core\Session;

use Core\Interfaces\SessionInterface;
use function session_cache_expire,
             session_cache_limiter,
             session_start,
             session_destroy,
             session_unset,
             session_set_cookie_params,
             ini_set;

class SessionNative implements SessionInterface
{

    private ?string $path = null;

    public function __construct(
            bool $autostart = false,
            string|int|null $cacheExpire = null,
            ?string $cacheLimiter = null,
            ?string $path = null
    )
    {

        if ($cacheExpire !== null) {
            session_cache_expire(intval($cacheExpire));
        }

        if ($cacheLimiter !== null) {
            session_cache_limiter($cacheLimiter);
        }

        if ($autostart) {
            if (!$this->isStarted()) {
                $this->start();
            }
        }
        $this->path = $path;
    }

    public function clear(): void
    {
        if ($this->isStarted()) {
            session_unset();
        }
    }

    public function delete(string $key): bool
    {
        if ($this->isStarted() && $this->has($key)) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }

    public function destroy(): bool
    {
        if ($this->isStarted()) {
            return session_destroy();
        }
        return false;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        if ($this->isStarted()) {
            if ($this->has($key)) {
                return $_SESSION[$key] ?? $default;
            }
        }
        return $default;
    }

    public function has(string $key): bool
    {
        if ($this->isStarted()) {
            if (isset($_SESSION[$key])) {
                return true;
            }
        }
        return false;
    }

    public function isStarted(): bool
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return true;
        }
        return false;
    }

    public function set(string $key, mixed $value): self
    {
        if ($this->isStarted()) {
            $_SESSION[$key] = $value;
        }
        return $this;
    }

    public function start(): bool
    {
        if (!$this->isStarted()) {
            return session_start();
        }
        return false;
    }

    public function applyParams(array $params = []): void
    {
        // Set session cookie params
        $allowed = [
            'lifetime',
            'path',
            'domain',
            'secure',
            'httponly',
            'samesite'
        ];
        $insertParams = [];
        foreach ($params as $paramKey => $paramValue) {
            if (in_array($paramKey, $allowed)) {
                $insertParams[$paramKey] = $paramValue;
            }
        }
        session_set_cookie_params($insertParams);
        // Set session store path
        if ($this->path) {
            ini_set('session.save_path', $this->path);
        }
    }

}

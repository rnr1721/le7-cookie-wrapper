<?php

declare(strict_types=1);

namespace Core\Session;

use Core\Interfaces\Session;
use function session_cache_expire,
             session_cache_limiter,
             session_start,
             session_destroy,
             session_unset;

class SessionNative implements Session
{

    public function __construct(
            bool $autostart = false,
            string|int|null $cacheExpire = null,
            ?string $cacheLimiter = null
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

}

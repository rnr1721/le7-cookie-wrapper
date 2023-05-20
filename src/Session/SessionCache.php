<?php

declare(strict_types=1);

namespace Core\Session;

use Core\Interfaces\SessionInterface;
use Psr\SimpleCache\CacheInterface;
use function array_key_exists;

class SessionCache implements SessionInterface
{

    private ?int $ttl = null;
    private CacheInterface $cache;
    private string $sessionId;

    public function __construct(
            string $sessionId,
            CacheInterface $cache,
            int|null $cacheTtl = null,
            bool $autostart = false
    )
    {
        $this->ttl = $cacheTtl;
        $this->sessionId = $sessionId;
        $this->cache = $cache;
        if ($autostart) {
            if (!$this->isStarted()) {
                $this->start();
            }
        }
    }

    public function clear(): void
    {
        if ($this->isStarted()) {
            $this->cache->set($this->sessionId, [], $this->ttl);
        }
    }

    public function delete(string $key): bool
    {
        if ($this->isStarted() && $this->has($key)) {
            $session = $this->cache->get($this->sessionId);
            unset($session[$key]);
            $this->cache->set($this->sessionId, $session, $this->ttl);
            return true;
        }
        return false;
    }

    public function destroy(): bool
    {
        if ($this->isStarted()) {
            $this->cache->delete($this->sessionId);
            return true;
        }
        return false;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        if ($this->isStarted()) {
            if ($this->has($key)) {
                $result = $this->cache->get($this->sessionId);
                return $result[$key];
            }
        }
        return $default;
    }

    public function has(string $key): bool
    {
        if ($this->cache->has($this->sessionId)) {
            $session = $this->cache->get($this->sessionId);
            return array_key_exists($key, $session);
        }
        return false;
    }

    public function isStarted(): bool
    {
        if ($this->cache->has($this->sessionId)) {
            return true;
        }
        return false;
    }

    public function set(string $key, mixed $value): self
    {
        if ($this->isStarted()) {
            $result = $this->cache->get($this->sessionId);
            $result[$key] = $value;
            $this->cache->set($this->sessionId, $result, $this->ttl);
        }
        return $this;
    }

    public function start(): bool
    {
        if (!$this->isStarted()) {
            $this->cache->set($this->sessionId, [], $this->ttl);
            return true;
        }
        return false;
    }

    public function applyParams(array $params = []): void
    {
        // Do nothing
    }

}

<?php

declare(strict_types=1);

namespace Core\Session;

use Core\Interfaces\Session;
use function array_key_exists;

class SessionArray implements Session
{

    private bool $started = false;
    private array $session = [];

    public function __construct(bool $autostart = false)
    {
        if ($autostart) {
            if (!$this->isStarted()) {
                $this->start();
            }
        }
    }

    public function clear(): void
    {
        if ($this->isStarted()) {
            $this->session = [];
        }
    }

    public function delete(string $key): bool
    {
        if ($this->isStarted() && $this->has($key)) {
            unset($this->session[$key]);
            return true;
        }
        return false;
    }

    public function destroy(): bool
    {
        if ($this->isStarted()) {
            $this->clear();
            $this->started = false;
            return true;
        }
        return false;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        if ($this->isStarted()) {
            if ($this->has($key)) {
                return $this->session[$key];
            }
        }
        return $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->session);
    }

    public function isStarted(): bool
    {
        return $this->started;
    }

    public function set(string $key, mixed $value): self
    {
        if ($this->isStarted()) {
            $this->session[$key] = $value;
        }
        return $this;
    }

    public function start(): bool
    {
        if (!$this->isStarted()) {
            $this->started = true;
            return true;
        }
        return false;
    }

    public function applyParams(array $params = []): void
    {
        //Do nothing
    }

}

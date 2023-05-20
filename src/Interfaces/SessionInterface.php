<?php

declare(strict_types=1);

namespace Core\Interfaces;

interface SessionInterface
{

    /**
     * Start the session
     * @return bool
     */
    public function start(): bool;

    /**
     * Is session started?
     * @return bool
     */
    public function isStarted(): bool;

    /**
     * Set the value to session
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function set(string $key, mixed $value): self;

    /**
     * Get the session value by key
     * @param string $key Key of $_SESSION
     * @param mixed $default Default value if not exists
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Is value is set?
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Delete session value by key
     * @param string $key
     * @return bool
     */
    public function delete(string $key): bool;

    /**
     * Clear session
     * @return void
     */
    public function clear(): void;

    /**
     * Destroy the session
     * @return bool
     */
    public function destroy(): bool;

    /**
     * Set params as key=>value array:
     * - lifetime
     * - path
     * - domain
     * - secure
     * - httponly
     * - samesite
     * @param array $params
     * @return void
     */
    public function applyParams(array $params = []): void;
}

<?php

declare(strict_types=1);

namespace Core\Interfaces;

interface Cookie extends CookieConfig
{

    /**
     * Get cookie or default if not exists
     * @param string $name Cookie name
     * @param string|null $default Default value if not exists
     * @return string|null
     */
    public function get(string $name, string|null $default = null): string|null;

    /**
     * Set cookie value by name
     * @param string $name Cookie name
     * @param string $value Value
     * @return bool
     */
    public function set(string $name, string $value): bool;

    /**
     * If cookie exists
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * Delete cookie by name
     * @param string $name
     * @return bool
     */
    public function delete(string $name): bool;

    /**
     * Set time to overwrite defaults
     * @param int $time
     * @return self
     */
    public function setTime(int $time): self;

    /**
     * Set cookie path
     * @return self
     */
    public function setPath(string $path): self;

    /**
     * Set cookie Domain
     * @return self
     */
    public function setDomain(string $domain): self;

    /**
     * Set is secure
     * @return self
     */
    public function setSecue(bool $secure): self;

    /**
     * Set HTTP only
     * @return self
     */
    public function setHttpOnly(bool $httpOnly): self;

    /**
     * Set sameSite attribute
     * @param string $sameSite
     * @return self
     */
    public function setSameSite(string $sameSite): self;

    /**
     * Load cookie config
     * @param CookieConfig $cookieConfig
     */
    public function loadConfig(CookieConfig $cookieConfig): void;
}

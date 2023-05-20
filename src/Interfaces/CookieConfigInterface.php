<?php

declare(strict_types=1);

namespace Core\Interfaces;

interface CookieConfigInterface
{

    /**
     * Get cookie time
     * @return int
     */
    public function getTime(): int;

    /**
     * Get cookie path
     * @return string
     */
    public function getPath(): string;

    /**
     * Get cookie Domain
     * @return string
     */
    public function getDomain(): string;

    /**
     * Get is secure
     * @return bool
     */
    public function getSecue(): bool;

    /**
     * Get HTTP only
     * @return bool
     */
    public function getHttpOnly(): bool;
    
    /**
     * Get SameSite attribute
     * @return string
     */
    public function getSameSite():string;
    
    /**
     * Set params from array
     * @param array $params
     * @return void
     */
    public function setParams(array $params) : void;
}

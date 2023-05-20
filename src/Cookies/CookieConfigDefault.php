<?php

declare(strict_types=1);

namespace Core\Cookies;

use Core\Interfaces\CookieConfigInterface;

class CookieConfigDefault implements CookieConfigInterface
{

    use CookieConfigTrait;

    public function __construct(array $params = [])
    {
        $this->setParams($params);
    }

}

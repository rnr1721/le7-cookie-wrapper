<?php

declare(strict_types=1);

namespace Core\Cookies;

use Core\Interfaces\CookieConfig;

class CookieConfigDefault implements CookieConfig
{

    use CookieConfigTrait;

    public function __construct(array $params = [])
    {
        $this->setParams($params);
    }

}

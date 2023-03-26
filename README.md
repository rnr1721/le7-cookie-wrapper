# le7-cookie-wrapper
Wrapper for session and cookies for le7 PHP MVC framework or any PHP project

## Requirements

- PHP 8.1 or higher.
- Composer 2.0 or higher.

## What it can?

- CRUD for cookies
- CRUD for session variables

There are set of interfaces and adapters for drive variables for
$_SESSION and $_COOKIES:

- Core\Interfaces\Cookie interface - for cookie management
- Core\Interfacrs\Session interface - for session management

## Installation

```shell
composer require rnr1721/le7-cookies
```

## Testing

```shell
composer test
```

### Cookie adapters

- Core\Cookies\CookiesNative - default adapter, for use
- Core\Cookies\CookiesArray - data stored in array, not persistent (for testing)
- Core\Cookies\Cache - data stored in PSR cache (for testing)

You can write own implementation of CORE\Interfaces\Cookie
All of these adapters need config, implementation of Core\Interfaces\CookieConfig

- Core\Cookies\CookieConfigDefault

Of course, you can write own implementation, to load config from some source etc.

How use it?

```php
use Core\Cookies\CookiesConfigDefault;
use Core\Cookies\CookiesNative;

    // This is the default config
    $newConfig = [
        'domain' => '',
        'httpOnly' => false,
        'path' => '',
        'isSecure' => false,
        'time' => 0,
        'sameSite' => 'Lax',
    ];

    // Implementation of Core\Interfaces\CookieConfig
    $config = new CookiesConfigDefault($newConfig);

    // Second case to add params
    // $config->setParams($newConfig);

    // Implementation of Core\Interfaces\Cookie
    $cookies = new CookiesNative($config);

    // Before operations with cookies you can set more concrete params
    // These params will override defaults
    // $cookies->setPath('/');
    // $cookies->setHttpOnly(true);
    // $cookies->setSameSite('Lax');
    // $cookies->setSecure(true);
    // $cookies->setTime(3600);

    $cookies->get('mycookie'); //return cookie value by key;
    $cookies->get('mycookie','default'); //return cookie value by key or default;
    $cookies->has('mycookie'); // return bool if cookie exists or not
    $cookies->delete('mycookie'); // delete cookie 

```

### Session adapters

Also, you can manage your session variables. It implementation of
Core\Interfaces\Session

- Core\Session\SessionNative // Native PHP session management
- Core\Session\SessionArray // Store in array, not persistent, for testing
- Core\Session\SessionCache // Store in cache, not persistent, for testing

of course, you can write own adapter to store session in memcache or Redis etc.

How it use?

```php
use Core\Session\SessionNative;

    $session = new Core\Session\SessionNative();

    // start the session
    $session->start();

    // Set param one with value test1
    $session->set('one', 'test1');

    // get param one or null if not exists
    $session->get('one');

    // get param one or default value if not exists
    $session->get('one','default value');

    // Return bool if param exists or not
    $session->has('one');

    // Delete the param
    $session->delete('one');

    // Return bool if session started or not
    $session->isStarted();

    // Clear session
    $session->clear()

    // Destroy the session
    $session->destroy();

```

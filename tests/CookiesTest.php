<?php

use Core\Interfaces\Cookie;
use Core\Cookies\CookiesArray;
use Core\Cookies\CookiesCache;
use Core\Cookies\CookiesNative;
use Core\Interfaces\CookieConfig;
use Core\Cookies\CookieConfigDefault;
use Core\Cache\SCFactoryGeneric;
use Psr\SimpleCache\CacheInterface;

require_once 'vendor/autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';

class CookiesTest extends PHPUnit\Framework\TestCase
{

    private CookieConfig $cookieParams;
    private string $cacheDir;
    private CacheInterface $cache;

    protected function setUp(): void
    {

        $ds = DIRECTORY_SEPARATOR;

        $factory = new SCFactoryGeneric();
        $cacheDir = getcwd() . $ds . 'tests' . $ds . 'cache';

        if (!file_exists($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }

        $this->cache = $factory->getFileCache($cacheDir);
        $this->cacheDir = $cacheDir;

        $this->cookieParams = new CookieConfigDefault();
    }

    public function testCookiesConfig()
    {
        // Default config
        $config = new CookieConfigDefault();
        $this->assertEquals('', $config->getDomain());
        $this->assertEquals(false, $config->getHttpOnly());
        $this->assertEquals('', $config->getPath());
        $this->assertEquals(false, $config->getSecue());
        $this->assertEquals(0, $config->getTime());
        $this->assertEquals('Lax', $config->getSameSite());
        // Load config
        $newConfig = [
            'domain' => 'example.com',
            'httpOnly' => true,
            'path' => '/',
            'isSecure' => true,
            'time' => 3600,
            'sameSite' => 'Strict',
        ];
        $config->setParams($newConfig);
        $this->assertEquals('example.com', $config->getDomain());
        $this->assertEquals(true, $config->getHttpOnly());
        $this->assertEquals('/', $config->getPath());
        $this->assertEquals(true, $config->getSecue());
        $this->assertEquals(3600, $config->getTime());
        $this->assertEquals('Strict', $config->getSameSite());
    }

    public function testCookiesParams()
    {
        $config = new CookieConfigDefault();
        $cookies = new CookiesNative($config);
        $this->assertEquals('', $cookies->getDomain());
        $this->assertEquals(false, $cookies->getHttpOnly());
        $this->assertEquals('', $cookies->getPath());
        $this->assertEquals(false, $cookies->getSecue());
        $this->assertEquals(0, $cookies->getTime());
        $this->assertEquals('Lax', $cookies->getSameSite());

        $cookies->setDomain('example.com');
        $cookies->setHttpOnly(true);
        $cookies->setPath('/');
        $cookies->setSameSite('Strict');
        $cookies->setSecue(true);
        $cookies->setTime(3600);
        $this->assertEquals('example.com', $cookies->getDomain());
        $this->assertEquals(true, $cookies->getHttpOnly());
        $this->assertEquals('/', $cookies->getPath());
        $this->assertEquals(true, $cookies->getSecue());
        $this->assertEquals(3600, $cookies->getTime());
        $this->assertEquals('Strict', $cookies->getSameSite());
        $this->assertTrue($cookies->set('test', '123'));
        $this->assertEquals('param1', $cookies->get('myparam', 'param1'));
    }

    public function testCookieArray()
    {
        $cookies = new CookiesArray($this->cookieParams);
        $this->getCookiesTest($cookies);
    }

    public function testCookieCache()
    {
        $cookies = new CookiesCache($this->cookieParams, $this->cache, 'usr36');
        $this->getCookiesTest($cookies);
    }

    public function getCookiesTest(Cookie $cookies)
    {
        $this->assertFalse($cookies->has('testcookie'));
        $cookies->set('testcookie', 'NewCookieValue');
        $this->assertEquals('NewCookieValue', $cookies->get('testcookie'));
        $this->assertTrue($cookies->has('testcookie'));
        $cookies->delete('testcookie');
        $this->assertFalse($cookies->has('testcookie'));
        $this->assertTrue($cookies->set('newcookie', 'newcookie'));
    }

    protected function tearDown():void
    {
       $this->cache->clear();
    }
    
}

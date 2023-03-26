<?php

use Core\Interfaces\Session;
use Psr\SimpleCache\CacheInterface;
use Core\Cache\SCFactoryGeneric;

require_once 'vendor/autoload.php';
require_once __DIR__ . '/../vendor/autoload.php';

class SessionTest extends PHPUnit\Framework\TestCase
{
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
    }

    public function testSessionNative()
    {
        $session = new Core\Session\SessionNative();
        $this->defaultSessionTest($session);
    }

    public function testSessionArray()
    {
        $session = new Core\Session\SessionArray();
        $this->defaultSessionTest($session);
    }
    
    public function testSessionCache()
    {
        $session = new Core\Session\SessionCache('uid32', $this->cache);
        $this->defaultSessionTest($session);
        $this->cache->clear();
    }
    
    protected function tearDown():void
    {
       $this->cache->clear();
    }
    
    public function defaultSessionTest(Session $session)
    {
        
        $this->assertFalse($session->isStarted());
        $session->start();
        $this->assertTrue($session->isStarted());
        
        $session->set('one', 'test1');

        $session->set('two', 'test2');
        $this->assertEquals('test1', $session->get('one'));
        $this->assertEquals('test2', $session->get('two'));
        $this->assertEquals('test3', $session->get('three','test3'));
        
        $this->assertTrue($session->has('one'));
        $this->assertFalse($session->has('three'));
        
        $session->delete('two');
        $this->assertFalse($session->has('two'));
        $session->set('two', 'test3');
        $this->assertEquals('test3', $session->get('two'));
        
        $session->clear();
        $this->assertNull($session->get('one'));
        $this->assertNull($session->get('two'));
        $this->assertNull($session->get('three'));
        
        $session->destroy();
        
        $this->assertFalse($session->isStarted());
    }

}

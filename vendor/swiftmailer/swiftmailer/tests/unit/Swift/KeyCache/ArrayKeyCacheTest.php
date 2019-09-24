<?php

class Swift_KeyCache_ArrayKeyCacheTest extends \PHPUnit\Framework\TestCase
{
    private $key1 = 'key1';
    private $key2 = 'key2';

    public function testStringDataCanBeSetAndFetched()
    {
        $is = $this->createKeyCacheInputStream();
        $cache = $this->createCache($is);
        $cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $this->assertEquals('test', $cache->getString($this->key1, 'foo'));
    }

    public function testStringDataCanBeOverwritten()
    {
        $is = $this->createKeyCacheInputStream();
        $cache = $this->createCache($is);
        $cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $cache->setString(
            $this->key1, 'foo', 'whatever', Swift_KeyCache::MODE_WRITE
            );

        $this->assertEquals('whatever', $cache->getString($this->key1, 'foo'));
    }

    public function testStringDataCanBeAppended()
    {
        $is = $this->createKeyCacheInputStream();
        $cache = $this->createCache($is);
        $cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $cache->setString(
            $this->key1, 'foo', 'ing', Swift_KeyCache::MODE_APPEND
            );

        $this->assertEquals('testing', $cache->getString($this->key1, 'foo'));
    }

    public function testHasKeyReturnValue()
    {
        $is = $this->createKeyCacheInputStream();
        $cache = $this->createCache($is);
        $cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );

        $this->assertTrue($cache->hasKey($this->key1, 'foo'));
    }

    public function testNsKeyIsWellPartitioned()
    {
        $is = $this->createKeyCacheInputStream();
        $cache = $this->createCache($is);
        $cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $cache->setString(
            $this->key2, 'foo', 'ing', Swift_KeyCache::MODE_WRITE
            );

        $this->assertEquals('test', $cache->getString($this->key1, 'foo'));
        $this->assertEquals('ing', $cache->getString($this->key2, 'foo'));
    }

    public function testItemKeyIsWellPartitioned()
    {
        $is = $this->createKeyCacheInputStream();
        $cache = $this->createCache($is);
        $cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $cache->setString(
            $this->key1, 'bar', 'ing', Swift_KeyCache::MODE_WRITE
            );

        $this->assertEquals('test', $cache->getString($this->key1, 'foo'));
        $this->assertEquals('ing', $cache->getString($this->key1, 'bar'));
    }

    public function testByteStreamCanBeImported()
    {
        $os = $this->createOutputStream();
        $os->expects($this->at(0))
           ->method('read')
           ->will($this->returnValue('abc'));
        $os->expects($this->at(1))
           ->method('read')
           ->will($this->returnValue('def'));
        $os->expects($this->at(2))
           ->method('read')
           ->will($this->returnValue(false));

        $is = $this->createKeyCacheInputStream();
        $cache = $this->createCache($is);
        $cache->importFromByteStream(
            $this->key1, 'foo', $os, Swift_KeyCache::MODE_WRITE
            );
        $this->assertEquals('abcdef', $cache->getString($this->key1, 'foo'));
    }

    public function testByteStreamCanBeAppended()
    {
        $os1 = $this->createOutputStream();
        $os1->expects($this->at(0))
            ->method('read')
            ->will($this->returnValue('abc'));
        $os1->expects($this->at(1))
            ->method('read')
            ->will($this->returnValue('def'));
        $os1->expects($this->at(2))
            ->method('read')
            ->will($this->returnValue(false));

        $os2 = $this->createOutputStream();
        $os2->expects($this->at(0))
            ->method('read')
            ->will($this->returnValue('xyz'));
        $os2->expects($this->at(1))
            ->method('read')
            ->will($this->returnValue('uvw'));
        $os2->expects($this->at(2))
            ->method('read')
            ->will($this->returnValue(false));

        $is = $this->createKeyCacheInputStream(true);

        $cache = $this->createCache($is);

        $cache->importFromByteStream(
            $this->key1, 'foo', $os1, Swift_KeyCache::MODE_APPEND
            );
        $cache->importFromByteStream(
            $this->key1, 'foo', $os2, Swift_KeyCache::MODE_APPEND
            );

        $this->assertEquals('abcdefxyzuvw', $cache->getString($this->key1, 'foo'));
    }

    public function testByteStreamAndStringCanBeAppended()
    {
        $os = $this->createOutputStream();
        $os->expects($this->at(0))
           ->method('read')
           ->will($this->returnValue('abc'));
        $os->expects($this->at(1))
           ->method('read')
           ->will($this->returnValue('def'));
        $os->expects($this->at(2))
           ->method('read')
           ->will($this->returnValue(false));

        $is = $this->createKeyCacheInputStream(true);

        $cache = $this->createCache($is);

        $cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_APPEND
            );
        $cache->importFromByteStream(
            $this->key1, 'foo', $os, Swift_KeyCache::MODE_APPEND
            );
        $this->assertEquals('testabcdef', $cache->getString($this->key1, 'foo'));
    }

    public function testDataCanBeExportedToByteStream()
    {
        //See acceptance test for more detail
        $is = $this->createInputStream();
        $is->expects($this->atLeastOnce())
           ->method('write');

        $kcis = $this->createKeyCacheInputStream(true);

        $cache = $this->createCache($kcis);

        $cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );

        $cache->exportToByteStream($this->key1, 'foo', $is);
    }

    public function testKeyCanBeCleared()
    {
        $is = $this->createKeyCacheInputStream();
        $cache = $this->createCache($is);

        $cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $this->assertTrue($cache->hasKey($this->key1, 'foo'));
        $cache->clearKey($this->key1, 'foo');
        $this->assertFalse($cache->hasKey($this->key1, 'foo'));
    }

    public function testNsKeyCanBeCleared()
    {
        $is = $this->createKeyCacheInputStream();
        $cache = $this->createCache($is);

        $cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $cache->setString(
            $this->key1, 'bar', 'xyz', Swift_KeyCache::MODE_WRITE
            );
        $this->assertTrue($cache->hasKey($this->key1, 'foo'));
        $this->assertTrue($cache->hasKey($this->key1, 'bar'));
        $cache->clearAll($this->key1);
        $this->assertFalse($cache->hasKey($this->key1, 'foo'));
        $this->assertFalse($cache->hasKey($this->key1, 'bar'));
    }

    private function createCache($is)
    {
        return new Swift_KeyCache_ArrayKeyCache($is);
    }

    private function createKeyCacheInputStream()
    {
        return $this->getMockBuilder('Swift_KeyCache_KeyCacheInputStream')->getMock();
    }

    private function createOutputStream()
    {
        return $this->getMockBuilder('Swift_OutputByteStream')->getMock();
    }

    private function createInputStream()
    {
        return $this->getMockBuilder('Swift_InputByteStream')->getMock();
    }
}

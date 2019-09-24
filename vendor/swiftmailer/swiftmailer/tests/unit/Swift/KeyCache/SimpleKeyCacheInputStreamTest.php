<?php

class Swift_KeyCache_SimpleKeyCacheInputStreamTest extends \PHPUnit\Framework\TestCase
{
    private $nsKey = 'ns1';

    public function testStreamWritesToCacheInAppendMode()
    {
        $cache = $this->getMockBuilder('Swift_KeyCache')->getMock();
        $cache->expects($this->at(0))
              ->method('setString')
              ->with($this->nsKey, 'foo', 'a', Swift_KeyCache::MODE_APPEND);
        $cache->expects($this->at(1))
              ->method('setString')
              ->with($this->nsKey, 'foo', 'b', Swift_KeyCache::MODE_APPEND);
        $cache->expects($this->at(2))
              ->method('setString')
              ->with($this->nsKey, 'foo', 'c', Swift_KeyCache::MODE_APPEND);

        $stream = new Swift_KeyCache_SimpleKeyCacheInputStream();
        $stream->setKeyCache($cache);
        $stream->setNsKey($this->nsKey);
        $stream->setItemKey('foo');

        $stream->write('a');
        $stream->write('b');
        $stream->write('c');
    }

    public function testFlushContentClearsKey()
    {
        $cache = $this->getMockBuilder('Swift_KeyCache')->getMock();
        $cache->expects($this->once())
              ->method('clearKey')
              ->with($this->nsKey, 'foo');

        $stream = new Swift_KeyCache_SimpleKeyCacheInputStream();
        $stream->setKeyCache($cache);
        $stream->setNsKey($this->nsKey);
        $stream->setItemKey('foo');

        $stream->flushBuffers();
    }

    public function testClonedStreamStillReferencesSameCache()
    {
        $cache = $this->getMockBuilder('Swift_KeyCache')->getMock();
        $cache->expects($this->at(0))
              ->method('setString')
              ->with($this->nsKey, 'foo', 'a', Swift_KeyCache::MODE_APPEND);
        $cache->expects($this->at(1))
              ->method('setString')
              ->with($this->nsKey, 'foo', 'b', Swift_KeyCache::MODE_APPEND);
        $cache->expects($this->at(2))
              ->method('setString')
              ->with('test', 'bar', 'x', Swift_KeyCache::MODE_APPEND);

        $stream = new Swift_KeyCache_SimpleKeyCacheInputStream();
        $stream->setKeyCache($cache);
        $stream->setNsKey($this->nsKey);
        $stream->setItemKey('foo');

        $stream->write('a');
        $stream->write('b');

        $newStream = clone $stream;
        $newStream->setKeyCache($cache);
        $newStream->setNsKey('test');
        $newStream->setItemKey('bar');

        $newStream->write('x');
    }
}

<?php

class Swift_KeyCache_DiskKeyCacheAcceptanceTest extends \PHPUnit\Framework\TestCase
{
    private $cache;
    private $key1;
    private $key2;

    protected function setUp()
    {
        $this->key1 = uniqid(microtime(true), true);
        $this->key2 = uniqid(microtime(true), true);
        $this->cache = new Swift_KeyCache_DiskKeyCache(new Swift_KeyCache_SimpleKeyCacheInputStream(), sys_get_temp_dir());
    }

    public function testStringDataCanBeSetAndFetched()
    {
        $this->cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $this->assertEquals('test', $this->cache->getString($this->key1, 'foo'));
    }

    public function testStringDataCanBeOverwritten()
    {
        $this->cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $this->cache->setString(
            $this->key1, 'foo', 'whatever', Swift_KeyCache::MODE_WRITE
            );
        $this->assertEquals('whatever', $this->cache->getString($this->key1, 'foo'));
    }

    public function testStringDataCanBeAppended()
    {
        $this->cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $this->cache->setString(
            $this->key1, 'foo', 'ing', Swift_KeyCache::MODE_APPEND
            );
        $this->assertEquals('testing', $this->cache->getString($this->key1, 'foo'));
    }

    public function testHasKeyReturnValue()
    {
        $this->assertFalse($this->cache->hasKey($this->key1, 'foo'));
        $this->cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $this->assertTrue($this->cache->hasKey($this->key1, 'foo'));
    }

    public function testNsKeyIsWellPartitioned()
    {
        $this->cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $this->cache->setString(
            $this->key2, 'foo', 'ing', Swift_KeyCache::MODE_WRITE
            );
        $this->assertEquals('test', $this->cache->getString($this->key1, 'foo'));
        $this->assertEquals('ing', $this->cache->getString($this->key2, 'foo'));
    }

    public function testItemKeyIsWellPartitioned()
    {
        $this->cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $this->cache->setString(
            $this->key1, 'bar', 'ing', Swift_KeyCache::MODE_WRITE
            );
        $this->assertEquals('test', $this->cache->getString($this->key1, 'foo'));
        $this->assertEquals('ing', $this->cache->getString($this->key1, 'bar'));
    }

    public function testByteStreamCanBeImported()
    {
        $os = new Swift_ByteStream_ArrayByteStream();
        $os->write('abcdef');

        $this->cache->importFromByteStream(
            $this->key1, 'foo', $os, Swift_KeyCache::MODE_WRITE
            );
        $this->assertEquals('abcdef', $this->cache->getString($this->key1, 'foo'));
    }

    public function testByteStreamCanBeAppended()
    {
        $os1 = new Swift_ByteStream_ArrayByteStream();
        $os1->write('abcdef');

        $os2 = new Swift_ByteStream_ArrayByteStream();
        $os2->write('xyzuvw');

        $this->cache->importFromByteStream(
            $this->key1, 'foo', $os1, Swift_KeyCache::MODE_APPEND
            );
        $this->cache->importFromByteStream(
            $this->key1, 'foo', $os2, Swift_KeyCache::MODE_APPEND
            );

        $this->assertEquals('abcdefxyzuvw', $this->cache->getString($this->key1, 'foo'));
    }

    public function testByteStreamAndStringCanBeAppended()
    {
        $this->cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_APPEND
            );

        $os = new Swift_ByteStream_ArrayByteStream();
        $os->write('abcdef');

        $this->cache->importFromByteStream(
            $this->key1, 'foo', $os, Swift_KeyCache::MODE_APPEND
            );
        $this->assertEquals('testabcdef', $this->cache->getString($this->key1, 'foo'));
    }

    public function testDataCanBeExportedToByteStream()
    {
        $this->cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );

        $is = new Swift_ByteStream_ArrayByteStream();

        $this->cache->exportToByteStream($this->key1, 'foo', $is);

        $string = '';
        while (false !== $bytes = $is->read(8192)) {
            $string .= $bytes;
        }

        $this->assertEquals('test', $string);
    }

    public function testKeyCanBeCleared()
    {
        $this->cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $this->assertTrue($this->cache->hasKey($this->key1, 'foo'));
        $this->cache->clearKey($this->key1, 'foo');
        $this->assertFalse($this->cache->hasKey($this->key1, 'foo'));
    }

    public function testNsKeyCanBeCleared()
    {
        $this->cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $this->cache->setString(
            $this->key1, 'bar', 'xyz', Swift_KeyCache::MODE_WRITE
            );
        $this->assertTrue($this->cache->hasKey($this->key1, 'foo'));
        $this->assertTrue($this->cache->hasKey($this->key1, 'bar'));
        $this->cache->clearAll($this->key1);
        $this->assertFalse($this->cache->hasKey($this->key1, 'foo'));
        $this->assertFalse($this->cache->hasKey($this->key1, 'bar'));
    }

    public function testKeyCacheInputStream()
    {
        $is = $this->cache->getInputByteStream($this->key1, 'foo');
        $is->write('abc');
        $is->write('xyz');
        $this->assertEquals('abcxyz', $this->cache->getString($this->key1, 'foo'));
    }
}

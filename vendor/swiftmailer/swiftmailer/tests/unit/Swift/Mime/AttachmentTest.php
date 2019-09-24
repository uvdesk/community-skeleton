<?php


class Swift_Mime_AttachmentTest extends Swift_Mime_AbstractMimeEntityTest
{
    public function testNestingLevelIsAttachment()
    {
        $attachment = $this->createAttachment($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $this->assertEquals(
            Swift_Mime_SimpleMimeEntity::LEVEL_MIXED, $attachment->getNestingLevel()
            );
    }

    public function testDispositionIsReturnedFromHeader()
    {
        /* -- RFC 2183, 2.1, 2.2.
     */

        $disposition = $this->createHeader('Content-Disposition', 'attachment');
        $attachment = $this->createAttachment($this->createHeaderSet([
            'Content-Disposition' => $disposition, ]),
            $this->createEncoder(), $this->createCache()
            );
        $this->assertEquals('attachment', $attachment->getDisposition());
    }

    public function testDispositionIsSetInHeader()
    {
        $disposition = $this->createHeader('Content-Disposition', 'attachment',
            [], false
            );
        $disposition->shouldReceive('setFieldBodyModel')
                    ->once()
                    ->with('inline');
        $disposition->shouldReceive('setFieldBodyModel')
                    ->zeroOrMoreTimes();

        $attachment = $this->createAttachment($this->createHeaderSet([
            'Content-Disposition' => $disposition, ]),
            $this->createEncoder(), $this->createCache()
            );
        $attachment->setDisposition('inline');
    }

    public function testDispositionIsAddedIfNonePresent()
    {
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('addParameterizedHeader')
                ->once()
                ->with('Content-Disposition', 'inline');
        $headers->shouldReceive('addParameterizedHeader')
                ->zeroOrMoreTimes();

        $attachment = $this->createAttachment($headers, $this->createEncoder(),
            $this->createCache()
            );
        $attachment->setDisposition('inline');
    }

    public function testDispositionIsAutoDefaultedToAttachment()
    {
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('addParameterizedHeader')
                ->once()
                ->with('Content-Disposition', 'attachment');
        $headers->shouldReceive('addParameterizedHeader')
                ->zeroOrMoreTimes();

        $attachment = $this->createAttachment($headers, $this->createEncoder(),
            $this->createCache()
            );
    }

    public function testDefaultContentTypeInitializedToOctetStream()
    {
        $cType = $this->createHeader('Content-Type', '',
            [], false
            );
        $cType->shouldReceive('setFieldBodyModel')
              ->once()
              ->with('application/octet-stream');
        $cType->shouldReceive('setFieldBodyModel')
              ->zeroOrMoreTimes();

        $attachment = $this->createAttachment($this->createHeaderSet([
            'Content-Type' => $cType, ]),
            $this->createEncoder(), $this->createCache()
            );
    }

    public function testFilenameIsReturnedFromHeader()
    {
        /* -- RFC 2183, 2.3.
     */

        $disposition = $this->createHeader('Content-Disposition', 'attachment',
            ['filename' => 'foo.txt']
            );
        $attachment = $this->createAttachment($this->createHeaderSet([
            'Content-Disposition' => $disposition, ]),
            $this->createEncoder(), $this->createCache()
            );
        $this->assertEquals('foo.txt', $attachment->getFilename());
    }

    public function testFilenameIsSetInHeader()
    {
        $disposition = $this->createHeader('Content-Disposition', 'attachment',
            ['filename' => 'foo.txt'], false
            );
        $disposition->shouldReceive('setParameter')
                    ->once()
                    ->with('filename', 'bar.txt');
        $disposition->shouldReceive('setParameter')
                    ->zeroOrMoreTimes();

        $attachment = $this->createAttachment($this->createHeaderSet([
            'Content-Disposition' => $disposition, ]),
            $this->createEncoder(), $this->createCache()
            );
        $attachment->setFilename('bar.txt');
    }

    public function testSettingFilenameSetsNameInContentType()
    {
        /*
     This is a legacy requirement which isn't covered by up-to-date RFCs.
     */

        $cType = $this->createHeader('Content-Type', 'text/plain',
            [], false
            );
        $cType->shouldReceive('setParameter')
              ->once()
              ->with('name', 'bar.txt');
        $cType->shouldReceive('setParameter')
              ->zeroOrMoreTimes();

        $attachment = $this->createAttachment($this->createHeaderSet([
            'Content-Type' => $cType, ]),
            $this->createEncoder(), $this->createCache()
            );
        $attachment->setFilename('bar.txt');
    }

    public function testSizeIsReturnedFromHeader()
    {
        /* -- RFC 2183, 2.7.
     */

        $disposition = $this->createHeader('Content-Disposition', 'attachment',
            ['size' => 1234]
            );
        $attachment = $this->createAttachment($this->createHeaderSet([
            'Content-Disposition' => $disposition, ]),
            $this->createEncoder(), $this->createCache()
            );
        $this->assertEquals(1234, $attachment->getSize());
    }

    public function testSizeIsSetInHeader()
    {
        $disposition = $this->createHeader('Content-Disposition', 'attachment',
            [], false
            );
        $disposition->shouldReceive('setParameter')
                    ->once()
                    ->with('size', 12345);
        $disposition->shouldReceive('setParameter')
                    ->zeroOrMoreTimes();

        $attachment = $this->createAttachment($this->createHeaderSet([
            'Content-Disposition' => $disposition, ]),
            $this->createEncoder(), $this->createCache()
            );
        $attachment->setSize(12345);
    }

    public function testFilnameCanBeReadFromFileStream()
    {
        $file = $this->createFileStream('/bar/file.ext', '');
        $disposition = $this->createHeader('Content-Disposition', 'attachment',
            ['filename' => 'foo.txt'], false
            );
        $disposition->shouldReceive('setParameter')
                    ->once()
                    ->with('filename', 'file.ext');

        $attachment = $this->createAttachment($this->createHeaderSet([
            'Content-Disposition' => $disposition, ]),
            $this->createEncoder(), $this->createCache()
            );
        $attachment->setFile($file);
    }

    public function testContentTypeCanBeSetViaSetFile()
    {
        $file = $this->createFileStream('/bar/file.ext', '');
        $disposition = $this->createHeader('Content-Disposition', 'attachment',
            ['filename' => 'foo.txt'], false
            );
        $disposition->shouldReceive('setParameter')
                    ->once()
                    ->with('filename', 'file.ext');

        $ctype = $this->createHeader('Content-Type', 'text/plain', [], false);
        $ctype->shouldReceive('setFieldBodyModel')
              ->once()
              ->with('text/html');
        $ctype->shouldReceive('setFieldBodyModel')
              ->zeroOrMoreTimes();

        $headers = $this->createHeaderSet([
            'Content-Disposition' => $disposition,
            'Content-Type' => $ctype,
            ]);

        $attachment = $this->createAttachment($headers, $this->createEncoder(),
            $this->createCache()
            );
        $attachment->setFile($file, 'text/html');
    }

    public function XtestContentTypeCanBeLookedUpFromCommonListIfNotProvided()
    {
        $file = $this->createFileStream('/bar/file.zip', '');
        $disposition = $this->createHeader('Content-Disposition', 'attachment',
            ['filename' => 'foo.zip'], false
            );
        $disposition->shouldReceive('setParameter')
                    ->once()
                    ->with('filename', 'file.zip');

        $ctype = $this->createHeader('Content-Type', 'text/plain', [], false);
        $ctype->shouldReceive('setFieldBodyModel')
              ->once()
              ->with('application/zip');
        $ctype->shouldReceive('setFieldBodyModel')
              ->zeroOrMoreTimes();

        $headers = $this->createHeaderSet([
            'Content-Disposition' => $disposition,
            'Content-Type' => $ctype,
            ]);

        $attachment = $this->createAttachment($headers, $this->createEncoder(),
            $this->createCache(), ['zip' => 'application/zip', 'txt' => 'text/plain']
            );
        $attachment->setFile($file);
    }

    public function testDataCanBeReadFromFile()
    {
        $file = $this->createFileStream('/foo/file.ext', '<some data>');
        $attachment = $this->createAttachment($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $attachment->setFile($file);
        $this->assertEquals('<some data>', $attachment->getBody());
    }

    public function testFluidInterface()
    {
        $attachment = $this->createAttachment($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $this->assertSame($attachment,
            $attachment
            ->setContentType('application/pdf')
            ->setEncoder($this->createEncoder())
            ->setId('foo@bar')
            ->setDescription('my pdf')
            ->setMaxLineLength(998)
            ->setBody('xx')
            ->setBoundary('xyz')
            ->setChildren([])
            ->setDisposition('inline')
            ->setFilename('afile.txt')
            ->setSize(123)
            ->setFile($this->createFileStream('foo.txt', ''))
            );
    }

    protected function createEntity($headers, $encoder, $cache)
    {
        return $this->createAttachment($headers, $encoder, $cache);
    }

    protected function createAttachment($headers, $encoder, $cache, $mimeTypes = [])
    {
        $idGenerator = new Swift_Mime_IdGenerator('example.com');

        return new Swift_Mime_Attachment($headers, $encoder, $cache, $idGenerator, $mimeTypes);
    }

    protected function createFileStream($path, $data, $stub = true)
    {
        $file = $this->getMockery('Swift_FileStream');
        $file->shouldReceive('getPath')
             ->zeroOrMoreTimes()
             ->andReturn($path);
        $file->shouldReceive('read')
             ->zeroOrMoreTimes()
             ->andReturnUsing(function () use ($data) {
                 static $first = true;
                 if (!$first) {
                     return false;
                 }

                 $first = false;

                 return $data;
             });
        $file->shouldReceive('setReadPointer')
             ->zeroOrMoreTimes();

        return $file;
    }
}

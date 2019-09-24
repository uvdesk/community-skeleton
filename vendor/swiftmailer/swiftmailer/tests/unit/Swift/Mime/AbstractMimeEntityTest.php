<?php

require_once dirname(dirname(dirname(__DIR__))).'/fixtures/MimeEntityFixture.php';

abstract class Swift_Mime_AbstractMimeEntityTest extends \SwiftMailerTestCase
{
    public function testGetHeadersReturnsHeaderSet()
    {
        $headers = $this->createHeaderSet();
        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $this->assertSame($headers, $entity->getHeaders());
    }

    public function testContentTypeIsReturnedFromHeader()
    {
        $ctype = $this->createHeader('Content-Type', 'image/jpeg-test');
        $headers = $this->createHeaderSet(['Content-Type' => $ctype]);
        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $this->assertEquals('image/jpeg-test', $entity->getContentType());
    }

    public function testContentTypeIsSetInHeader()
    {
        $ctype = $this->createHeader('Content-Type', 'text/plain', [], false);
        $headers = $this->createHeaderSet(['Content-Type' => $ctype]);

        $ctype->shouldReceive('setFieldBodyModel')
              ->once()
              ->with('image/jpeg');
        $ctype->shouldReceive('setFieldBodyModel')
              ->zeroOrMoreTimes()
              ->with(\Mockery::not('image/jpeg'));

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $entity->setContentType('image/jpeg');
    }

    public function testContentTypeHeaderIsAddedIfNoneSet()
    {
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('addParameterizedHeader')
                ->once()
                ->with('Content-Type', 'image/jpeg');
        $headers->shouldReceive('addParameterizedHeader')
                ->zeroOrMoreTimes();

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $entity->setContentType('image/jpeg');
    }

    public function testContentTypeCanBeSetViaSetBody()
    {
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('addParameterizedHeader')
                ->once()
                ->with('Content-Type', 'text/html');
        $headers->shouldReceive('addParameterizedHeader')
                ->zeroOrMoreTimes();

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $entity->setBody('<b>foo</b>', 'text/html');
    }

    public function testGetEncoderFromConstructor()
    {
        $encoder = $this->createEncoder('base64');
        $entity = $this->createEntity($this->createHeaderSet(), $encoder,
            $this->createCache()
            );
        $this->assertSame($encoder, $entity->getEncoder());
    }

    public function testSetAndGetEncoder()
    {
        $encoder = $this->createEncoder('base64');
        $headers = $this->createHeaderSet();
        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $entity->setEncoder($encoder);
        $this->assertSame($encoder, $entity->getEncoder());
    }

    public function testSettingEncoderUpdatesTransferEncoding()
    {
        $encoder = $this->createEncoder('base64');
        $encoding = $this->createHeader(
            'Content-Transfer-Encoding', '8bit', [], false
            );
        $headers = $this->createHeaderSet([
            'Content-Transfer-Encoding' => $encoding,
            ]);
        $encoding->shouldReceive('setFieldBodyModel')
                 ->once()
                 ->with('base64');
        $encoding->shouldReceive('setFieldBodyModel')
                 ->zeroOrMoreTimes();

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $entity->setEncoder($encoder);
    }

    public function testSettingEncoderAddsEncodingHeaderIfNonePresent()
    {
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('addTextHeader')
                ->once()
                ->with('Content-Transfer-Encoding', 'something');
        $headers->shouldReceive('addTextHeader')
                ->zeroOrMoreTimes();

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $entity->setEncoder($this->createEncoder('something'));
    }

    public function testIdIsReturnedFromHeader()
    {
        /* -- RFC 2045, 7.
        In constructing a high-level user agent, it may be desirable to allow
        one body to make reference to another.  Accordingly, bodies may be
        labelled using the "Content-ID" header field, which is syntactically
        identical to the "Message-ID" header field
        */

        $cid = $this->createHeader('Content-ID', 'zip@button');
        $headers = $this->createHeaderSet(['Content-ID' => $cid]);
        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $this->assertEquals('zip@button', $entity->getId());
    }

    public function testIdIsSetInHeader()
    {
        $cid = $this->createHeader('Content-ID', 'zip@button', [], false);
        $headers = $this->createHeaderSet(['Content-ID' => $cid]);

        $cid->shouldReceive('setFieldBodyModel')
            ->once()
            ->with('foo@bar');
        $cid->shouldReceive('setFieldBodyModel')
            ->zeroOrMoreTimes();

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $entity->setId('foo@bar');
    }

    public function testIdIsAutoGenerated()
    {
        $entity = $this->createEntity($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $this->assertRegExp('/^.*?@.*?$/D', $entity->getId());
    }

    public function testGenerateIdCreatesNewId()
    {
        $headers = $this->createHeaderSet();
        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $id1 = $entity->generateId();
        $id2 = $entity->generateId();
        $this->assertNotEquals($id1, $id2);
    }

    public function testGenerateIdSetsNewId()
    {
        $headers = $this->createHeaderSet();
        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $id = $entity->generateId();
        $this->assertEquals($id, $entity->getId());
    }

    public function testDescriptionIsReadFromHeader()
    {
        /* -- RFC 2045, 8.
        The ability to associate some descriptive information with a given
        body is often desirable.  For example, it may be useful to mark an
        "image" body as "a picture of the Space Shuttle Endeavor."  Such text
        may be placed in the Content-Description header field.  This header
        field is always optional.
        */

        $desc = $this->createHeader('Content-Description', 'something');
        $headers = $this->createHeaderSet(['Content-Description' => $desc]);
        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $this->assertEquals('something', $entity->getDescription());
    }

    public function testDescriptionIsSetInHeader()
    {
        $desc = $this->createHeader('Content-Description', '', [], false);
        $desc->shouldReceive('setFieldBodyModel')->once()->with('whatever');

        $headers = $this->createHeaderSet(['Content-Description' => $desc]);

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $entity->setDescription('whatever');
    }

    public function testDescriptionHeaderIsAddedIfNotPresent()
    {
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('addTextHeader')
                ->once()
                ->with('Content-Description', 'whatever');
        $headers->shouldReceive('addTextHeader')
                ->zeroOrMoreTimes();

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $entity->setDescription('whatever');
    }

    public function testSetAndGetMaxLineLength()
    {
        $entity = $this->createEntity($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $entity->setMaxLineLength(60);
        $this->assertEquals(60, $entity->getMaxLineLength());
    }

    public function testEncoderIsUsedForStringGeneration()
    {
        $encoder = $this->createEncoder('base64', false);
        $encoder->expects($this->once())
                ->method('encodeString')
                ->with('blah');

        $entity = $this->createEntity($this->createHeaderSet(),
            $encoder, $this->createCache()
            );
        $entity->setBody('blah');
        $entity->toString();
    }

    public function testMaxLineLengthIsProvidedWhenEncoding()
    {
        $encoder = $this->createEncoder('base64', false);
        $encoder->expects($this->once())
                ->method('encodeString')
                ->with('blah', 0, 65);

        $entity = $this->createEntity($this->createHeaderSet(),
            $encoder, $this->createCache()
            );
        $entity->setBody('blah');
        $entity->setMaxLineLength(65);
        $entity->toString();
    }

    public function testHeadersAppearInString()
    {
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('toString')
                ->once()
                ->andReturn(
                    "Content-Type: text/plain; charset=utf-8\r\n".
                    "X-MyHeader: foobar\r\n"
                );

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $this->assertEquals(
            "Content-Type: text/plain; charset=utf-8\r\n".
            "X-MyHeader: foobar\r\n",
            $entity->toString()
            );
    }

    public function testSetAndGetBody()
    {
        $entity = $this->createEntity($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $entity->setBody("blah\r\nblah!");
        $this->assertEquals("blah\r\nblah!", $entity->getBody());
    }

    public function testBodyIsAppended()
    {
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('toString')
                ->once()
                ->andReturn("Content-Type: text/plain; charset=utf-8\r\n");

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $entity->setBody("blah\r\nblah!");
        $this->assertEquals(
            "Content-Type: text/plain; charset=utf-8\r\n".
            "\r\n".
            "blah\r\nblah!",
            $entity->toString()
            );
    }

    public function testGetBodyReturnsStringFromByteStream()
    {
        $os = $this->createOutputStream('byte stream string');
        $entity = $this->createEntity($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $entity->setBody($os);
        $this->assertEquals('byte stream string', $entity->getBody());
    }

    public function testByteStreamBodyIsAppended()
    {
        $headers = $this->createHeaderSet([], false);
        $os = $this->createOutputStream('streamed');
        $headers->shouldReceive('toString')
                ->once()
                ->andReturn("Content-Type: text/plain; charset=utf-8\r\n");

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $entity->setBody($os);
        $this->assertEquals(
            "Content-Type: text/plain; charset=utf-8\r\n".
            "\r\n".
            'streamed',
            $entity->toString()
            );
    }

    public function testBoundaryCanBeRetrieved()
    {
        /* -- RFC 2046, 5.1.1.
     boundary := 0*69<bchars> bcharsnospace

     bchars := bcharsnospace / " "

     bcharsnospace := DIGIT / ALPHA / "'" / "(" / ")" /
                                            "+" / "_" / "," / "-" / "." /
                                            "/" / ":" / "=" / "?"
        */

        $entity = $this->createEntity($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $this->assertRegExp(
            '/^[a-zA-Z0-9\'\(\)\+_\-,\.\/:=\?\ ]{0,69}[a-zA-Z0-9\'\(\)\+_\-,\.\/:=\?]$/D',
            $entity->getBoundary()
            );
    }

    public function testBoundaryNeverChanges()
    {
        $entity = $this->createEntity($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $firstBoundary = $entity->getBoundary();
        for ($i = 0; $i < 10; ++$i) {
            $this->assertEquals($firstBoundary, $entity->getBoundary());
        }
    }

    public function testBoundaryCanBeSet()
    {
        $entity = $this->createEntity($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $entity->setBoundary('foobar');
        $this->assertEquals('foobar', $entity->getBoundary());
    }

    public function testAddingChildrenGeneratesBoundaryInHeaders()
    {
        $child = $this->createChild();
        $cType = $this->createHeader('Content-Type', 'text/plain', [], false);
        $cType->shouldReceive('setParameter')
              ->once()
              ->with('boundary', \Mockery::any());
        $cType->shouldReceive('setParameter')
              ->zeroOrMoreTimes();

        $entity = $this->createEntity($this->createHeaderSet([
            'Content-Type' => $cType,
            ]),
            $this->createEncoder(), $this->createCache()
            );
        $entity->setChildren([$child]);
    }

    public function testChildrenOfLevelAttachmentAndLessCauseMultipartMixed()
    {
        for ($level = Swift_Mime_SimpleMimeEntity::LEVEL_MIXED;
            $level > Swift_Mime_SimpleMimeEntity::LEVEL_TOP; $level /= 2) {
            $child = $this->createChild($level);
            $cType = $this->createHeader(
                'Content-Type', 'text/plain', [], false
                );
            $cType->shouldReceive('setFieldBodyModel')
                  ->once()
                  ->with('multipart/mixed');
            $cType->shouldReceive('setFieldBodyModel')
                  ->zeroOrMoreTimes();

            $entity = $this->createEntity($this->createHeaderSet([
                'Content-Type' => $cType, ]),
                $this->createEncoder(), $this->createCache()
                );
            $entity->setChildren([$child]);
        }
    }

    public function testChildrenOfLevelAlternativeAndLessCauseMultipartAlternative()
    {
        for ($level = Swift_Mime_SimpleMimeEntity::LEVEL_ALTERNATIVE;
            $level > Swift_Mime_SimpleMimeEntity::LEVEL_MIXED; $level /= 2) {
            $child = $this->createChild($level);
            $cType = $this->createHeader(
                'Content-Type', 'text/plain', [], false
                );
            $cType->shouldReceive('setFieldBodyModel')
                  ->once()
                  ->with('multipart/alternative');
            $cType->shouldReceive('setFieldBodyModel')
                  ->zeroOrMoreTimes();

            $entity = $this->createEntity($this->createHeaderSet([
                'Content-Type' => $cType, ]),
                $this->createEncoder(), $this->createCache()
                );
            $entity->setChildren([$child]);
        }
    }

    public function testChildrenOfLevelRelatedAndLessCauseMultipartRelated()
    {
        for ($level = Swift_Mime_SimpleMimeEntity::LEVEL_RELATED;
            $level > Swift_Mime_SimpleMimeEntity::LEVEL_ALTERNATIVE; $level /= 2) {
            $child = $this->createChild($level);
            $cType = $this->createHeader(
                'Content-Type', 'text/plain', [], false
                );
            $cType->shouldReceive('setFieldBodyModel')
                  ->once()
                  ->with('multipart/related');
            $cType->shouldReceive('setFieldBodyModel')
                  ->zeroOrMoreTimes();

            $entity = $this->createEntity($this->createHeaderSet([
                'Content-Type' => $cType, ]),
                $this->createEncoder(), $this->createCache()
                );
            $entity->setChildren([$child]);
        }
    }

    public function testHighestLevelChildDeterminesContentType()
    {
        $combinations = [
            ['levels' => [Swift_Mime_SimpleMimeEntity::LEVEL_MIXED,
                Swift_Mime_SimpleMimeEntity::LEVEL_ALTERNATIVE,
                Swift_Mime_SimpleMimeEntity::LEVEL_RELATED,
                ],
                'type' => 'multipart/mixed',
                ],
            ['levels' => [Swift_Mime_SimpleMimeEntity::LEVEL_MIXED,
                Swift_Mime_SimpleMimeEntity::LEVEL_RELATED,
                ],
                'type' => 'multipart/mixed',
                ],
            ['levels' => [Swift_Mime_SimpleMimeEntity::LEVEL_MIXED,
                Swift_Mime_SimpleMimeEntity::LEVEL_ALTERNATIVE,
                ],
                'type' => 'multipart/mixed',
                ],
            ['levels' => [Swift_Mime_SimpleMimeEntity::LEVEL_ALTERNATIVE,
                Swift_Mime_SimpleMimeEntity::LEVEL_RELATED,
                ],
                'type' => 'multipart/alternative',
                ],
            ];

        foreach ($combinations as $combination) {
            $children = [];
            foreach ($combination['levels'] as $level) {
                $children[] = $this->createChild($level);
            }

            $cType = $this->createHeader(
                'Content-Type', 'text/plain', [], false
                );
            $cType->shouldReceive('setFieldBodyModel')
                  ->once()
                  ->with($combination['type']);

            $headerSet = $this->createHeaderSet(['Content-Type' => $cType]);
            $headerSet->shouldReceive('newInstance')
                      ->zeroOrMoreTimes()
                      ->andReturnUsing(function () use ($headerSet) {
                          return $headerSet;
                      });
            $entity = $this->createEntity($headerSet,
                $this->createEncoder(), $this->createCache()
                );
            $entity->setChildren($children);
        }
    }

    public function testChildrenAppearNestedInString()
    {
        /* -- RFC 2046, 5.1.1.
     (excerpt too verbose to paste here)
     */

        $headers = $this->createHeaderSet([], false);

        $child1 = new MimeEntityFixture(Swift_Mime_SimpleMimeEntity::LEVEL_ALTERNATIVE,
            "Content-Type: text/plain\r\n".
            "\r\n".
            'foobar', 'text/plain'
            );

        $child2 = new MimeEntityFixture(Swift_Mime_SimpleMimeEntity::LEVEL_ALTERNATIVE,
            "Content-Type: text/html\r\n".
            "\r\n".
            '<b>foobar</b>', 'text/html'
            );

        $headers->shouldReceive('toString')
              ->zeroOrMoreTimes()
              ->andReturn("Content-Type: multipart/alternative; boundary=\"xxx\"\r\n");

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $entity->setBoundary('xxx');
        $entity->setChildren([$child1, $child2]);

        $this->assertEquals(
            "Content-Type: multipart/alternative; boundary=\"xxx\"\r\n".
            "\r\n".
            "\r\n--xxx\r\n".
            "Content-Type: text/plain\r\n".
            "\r\n".
            "foobar\r\n".
            "\r\n--xxx\r\n".
            "Content-Type: text/html\r\n".
            "\r\n".
            "<b>foobar</b>\r\n".
            "\r\n--xxx--\r\n",
            $entity->toString()
            );
    }

    public function testMixingLevelsIsHierarchical()
    {
        $headers = $this->createHeaderSet([], false);
        $newHeaders = $this->createHeaderSet([], false);

        $part = $this->createChild(Swift_Mime_SimpleMimeEntity::LEVEL_ALTERNATIVE,
            "Content-Type: text/plain\r\n".
            "\r\n".
            'foobar'
            );

        $attachment = $this->createChild(Swift_Mime_SimpleMimeEntity::LEVEL_MIXED,
            "Content-Type: application/octet-stream\r\n".
            "\r\n".
            'data'
            );

        $headers->shouldReceive('toString')
              ->zeroOrMoreTimes()
              ->andReturn("Content-Type: multipart/mixed; boundary=\"xxx\"\r\n");
        $headers->shouldReceive('newInstance')
              ->zeroOrMoreTimes()
              ->andReturn($newHeaders);
        $newHeaders->shouldReceive('toString')
              ->zeroOrMoreTimes()
              ->andReturn("Content-Type: multipart/alternative; boundary=\"yyy\"\r\n");

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $entity->setBoundary('xxx');
        $entity->setChildren([$part, $attachment]);

        $this->assertRegExp(
            '~^'.
            "Content-Type: multipart/mixed; boundary=\"xxx\"\r\n".
            "\r\n\r\n--xxx\r\n".
            "Content-Type: multipart/alternative; boundary=\"yyy\"\r\n".
            "\r\n\r\n--(.*?)\r\n".
            "Content-Type: text/plain\r\n".
            "\r\n".
            'foobar'.
            "\r\n\r\n--\\1--\r\n".
            "\r\n\r\n--xxx\r\n".
            "Content-Type: application/octet-stream\r\n".
            "\r\n".
            'data'.
            "\r\n\r\n--xxx--\r\n".
            '$~',
            $entity->toString()
            );
    }

    public function testSettingEncoderNotifiesChildren()
    {
        $child = $this->createChild(0, '', false);
        $encoder = $this->createEncoder('base64');

        $child->shouldReceive('encoderChanged')
              ->once()
              ->with($encoder);

        $entity = $this->createEntity($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $entity->setChildren([$child]);
        $entity->setEncoder($encoder);
    }

    public function testReceiptOfEncoderChangeNotifiesChildren()
    {
        $child = $this->createChild(0, '', false);
        $encoder = $this->createEncoder('base64');

        $child->shouldReceive('encoderChanged')
              ->once()
              ->with($encoder);

        $entity = $this->createEntity($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $entity->setChildren([$child]);
        $entity->encoderChanged($encoder);
    }

    public function testReceiptOfCharsetChangeNotifiesChildren()
    {
        $child = $this->createChild(0, '', false);
        $child->shouldReceive('charsetChanged')
              ->once()
              ->with('windows-874');

        $entity = $this->createEntity($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $entity->setChildren([$child]);
        $entity->charsetChanged('windows-874');
    }

    public function testEntityIsWrittenToByteStream()
    {
        $entity = $this->createEntity($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $is = $this->createInputStream(false);
        $is->expects($this->atLeastOnce())
           ->method('write');

        $entity->toByteStream($is);
    }

    public function testEntityHeadersAreComittedToByteStream()
    {
        $entity = $this->createEntity($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );
        $is = $this->createInputStream(false);
        $is->expects($this->atLeastOnce())
           ->method('write');
        $is->expects($this->atLeastOnce())
           ->method('commit');

        $entity->toByteStream($is);
    }

    public function testOrderingTextBeforeHtml()
    {
        $htmlChild = new MimeEntityFixture(Swift_Mime_SimpleMimeEntity::LEVEL_ALTERNATIVE,
            "Content-Type: text/html\r\n".
            "\r\n".
            'HTML PART',
            'text/html'
            );
        $textChild = new MimeEntityFixture(Swift_Mime_SimpleMimeEntity::LEVEL_ALTERNATIVE,
            "Content-Type: text/plain\r\n".
            "\r\n".
            'TEXT PART',
            'text/plain'
            );
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('toString')
                ->zeroOrMoreTimes()
                ->andReturn("Content-Type: multipart/alternative; boundary=\"xxx\"\r\n");

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
            );
        $entity->setBoundary('xxx');
        $entity->setChildren([$htmlChild, $textChild]);

        $this->assertEquals(
            "Content-Type: multipart/alternative; boundary=\"xxx\"\r\n".
            "\r\n\r\n--xxx\r\n".
            "Content-Type: text/plain\r\n".
            "\r\n".
            'TEXT PART'.
            "\r\n\r\n--xxx\r\n".
            "Content-Type: text/html\r\n".
            "\r\n".
            'HTML PART'.
            "\r\n\r\n--xxx--\r\n",
            $entity->toString()
            );
    }

    public function testOrderingEqualContentTypesMaintainsOriginalOrdering()
    {
        $firstChild = new MimeEntityFixture(Swift_Mime_SimpleMimeEntity::LEVEL_ALTERNATIVE,
            "Content-Type: text/plain\r\n".
            "\r\n".
            'PART 1',
            'text/plain'
        );
        $secondChild = new MimeEntityFixture(Swift_Mime_SimpleMimeEntity::LEVEL_ALTERNATIVE,
            "Content-Type: text/plain\r\n".
            "\r\n".
            'PART 2',
            'text/plain'
        );
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('toString')
            ->zeroOrMoreTimes()
            ->andReturn("Content-Type: multipart/alternative; boundary=\"xxx\"\r\n");

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $this->createCache()
        );
        $entity->setBoundary('xxx');
        $entity->setChildren([$firstChild, $secondChild]);

        $this->assertEquals(
            "Content-Type: multipart/alternative; boundary=\"xxx\"\r\n".
            "\r\n\r\n--xxx\r\n".
            "Content-Type: text/plain\r\n".
            "\r\n".
            'PART 1'.
            "\r\n\r\n--xxx\r\n".
            "Content-Type: text/plain\r\n".
            "\r\n".
            'PART 2'.
            "\r\n\r\n--xxx--\r\n",
            $entity->toString()
        );
    }

    public function testUnsettingChildrenRestoresContentType()
    {
        $cType = $this->createHeader('Content-Type', 'text/plain', [], false);
        $child = $this->createChild(Swift_Mime_SimpleMimeEntity::LEVEL_ALTERNATIVE);

        $cType->shouldReceive('setFieldBodyModel')
              ->twice()
              ->with('image/jpeg');
        $cType->shouldReceive('setFieldBodyModel')
              ->once()
              ->with('multipart/alternative');
        $cType->shouldReceive('setFieldBodyModel')
              ->zeroOrMoreTimes()
              ->with(\Mockery::not('multipart/alternative', 'image/jpeg'));

        $entity = $this->createEntity($this->createHeaderSet([
            'Content-Type' => $cType,
            ]),
            $this->createEncoder(), $this->createCache()
            );

        $entity->setContentType('image/jpeg');
        $entity->setChildren([$child]);
        $entity->setChildren([]);
    }

    public function testBodyIsReadFromCacheWhenUsingToStringIfPresent()
    {
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('toString')
                ->zeroOrMoreTimes()
                ->andReturn("Content-Type: text/plain; charset=utf-8\r\n");

        $cache = $this->createCache(false);
        $cache->shouldReceive('hasKey')
              ->once()
              ->with(\Mockery::any(), 'body')
              ->andReturn(true);
        $cache->shouldReceive('getString')
              ->once()
              ->with(\Mockery::any(), 'body')
              ->andReturn("\r\ncache\r\ncache!");

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $cache
            );

        $entity->setBody("blah\r\nblah!");
        $this->assertEquals(
            "Content-Type: text/plain; charset=utf-8\r\n".
            "\r\n".
            "cache\r\ncache!",
            $entity->toString()
            );
    }

    public function testBodyIsAddedToCacheWhenUsingToString()
    {
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('toString')
                ->zeroOrMoreTimes()
                ->andReturn("Content-Type: text/plain; charset=utf-8\r\n");

        $cache = $this->createCache(false);
        $cache->shouldReceive('hasKey')
              ->once()
              ->with(\Mockery::any(), 'body')
              ->andReturn(false);
        $cache->shouldReceive('setString')
              ->once()
              ->with(\Mockery::any(), 'body', "\r\nblah\r\nblah!", Swift_KeyCache::MODE_WRITE);

        $entity = $this->createEntity($headers, $this->createEncoder(),
            $cache
            );

        $entity->setBody("blah\r\nblah!");
        $entity->toString();
    }

    public function testBodyIsClearedFromCacheIfNewBodySet()
    {
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('toString')
                ->zeroOrMoreTimes()
                ->andReturn("Content-Type: text/plain; charset=utf-8\r\n");

        $cache = $this->createCache(false);
        $entity = $this->createEntity($headers, $this->createEncoder(),
            $cache
            );

        $entity->setBody("blah\r\nblah!");
        $entity->toString();

        // We set the expectation at this point because we only care what happens when calling setBody()
        $cache->shouldReceive('clearKey')
              ->once()
              ->with(\Mockery::any(), 'body');

        $entity->setBody("new\r\nnew!");
    }

    public function testBodyIsNotClearedFromCacheIfSameBodySet()
    {
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('toString')
                ->zeroOrMoreTimes()
                ->andReturn("Content-Type: text/plain; charset=utf-8\r\n");

        $cache = $this->createCache(false);
        $entity = $this->createEntity($headers, $this->createEncoder(),
            $cache
            );

        $entity->setBody("blah\r\nblah!");
        $entity->toString();

        // We set the expectation at this point because we only care what happens when calling setBody()
        $cache->shouldReceive('clearKey')
              ->never();

        $entity->setBody("blah\r\nblah!");
    }

    public function testBodyIsClearedFromCacheIfNewEncoderSet()
    {
        $headers = $this->createHeaderSet([], false);
        $headers->shouldReceive('toString')
                ->zeroOrMoreTimes()
                ->andReturn("Content-Type: text/plain; charset=utf-8\r\n");

        $cache = $this->createCache(false);
        $otherEncoder = $this->createEncoder();
        $entity = $this->createEntity($headers, $this->createEncoder(),
            $cache
            );

        $entity->setBody("blah\r\nblah!");
        $entity->toString();

        // We set the expectation at this point because we only care what happens when calling setEncoder()
        $cache->shouldReceive('clearKey')
              ->once()
              ->with(\Mockery::any(), 'body');

        $entity->setEncoder($otherEncoder);
    }

    public function testBodyIsReadFromCacheWhenUsingToByteStreamIfPresent()
    {
        $is = $this->createInputStream();
        $cache = $this->createCache(false);
        $cache->shouldReceive('hasKey')
              ->once()
              ->with(\Mockery::any(), 'body')
              ->andReturn(true);
        $cache->shouldReceive('exportToByteStream')
              ->once()
              ->with(\Mockery::any(), 'body', $is);

        $entity = $this->createEntity($this->createHeaderSet(),
            $this->createEncoder(), $cache
            );
        $entity->setBody('foo');

        $entity->toByteStream($is);
    }

    public function testBodyIsAddedToCacheWhenUsingToByteStream()
    {
        $is = $this->createInputStream();
        $cache = $this->createCache(false);
        $cache->shouldReceive('hasKey')
              ->once()
              ->with(\Mockery::any(), 'body')
              ->andReturn(false);
        $cache->shouldReceive('getInputByteStream')
              ->once()
              ->with(\Mockery::any(), 'body');

        $entity = $this->createEntity($this->createHeaderSet(),
            $this->createEncoder(), $cache
            );
        $entity->setBody('foo');

        $entity->toByteStream($is);
    }

    public function testFluidInterface()
    {
        $entity = $this->createEntity($this->createHeaderSet(),
            $this->createEncoder(), $this->createCache()
            );

        $this->assertSame($entity,
            $entity
            ->setContentType('text/plain')
            ->setEncoder($this->createEncoder())
            ->setId('foo@bar')
            ->setDescription('my description')
            ->setMaxLineLength(998)
            ->setBody('xx')
            ->setBoundary('xyz')
            ->setChildren([])
            );
    }

    abstract protected function createEntity($headers, $encoder, $cache);

    protected function createChild($level = null, $string = '', $stub = true)
    {
        $child = $this->getMockery('Swift_Mime_SimpleMimeEntity')->shouldIgnoreMissing();
        if (isset($level)) {
            $child->shouldReceive('getNestingLevel')
                  ->zeroOrMoreTimes()
                  ->andReturn($level);
        }
        $child->shouldReceive('toString')
              ->zeroOrMoreTimes()
              ->andReturn($string);

        return $child;
    }

    protected function createEncoder($name = 'quoted-printable', $stub = true)
    {
        $encoder = $this->getMockBuilder('Swift_Mime_ContentEncoder')->getMock();
        $encoder->expects($this->any())
                ->method('getName')
                ->will($this->returnValue($name));
        $encoder->expects($this->any())
                ->method('encodeString')
                ->will($this->returnCallback(function () {
                    $args = func_get_args();

                    return array_shift($args);
                }));

        return $encoder;
    }

    protected function createCache($stub = true)
    {
        return $this->getMockery('Swift_KeyCache')->shouldIgnoreMissing();
    }

    protected function createHeaderSet($headers = [], $stub = true)
    {
        $set = $this->getMockery('Swift_Mime_SimpleHeaderSet')->shouldIgnoreMissing();
        $set->shouldReceive('get')
            ->zeroOrMoreTimes()
            ->andReturnUsing(function ($key) use ($headers) {
                return $headers[$key];
            });
        $set->shouldReceive('has')
            ->zeroOrMoreTimes()
            ->andReturnUsing(function ($key) use ($headers) {
                return array_key_exists($key, $headers);
            });

        return $set;
    }

    protected function createHeader($name, $model = null, $params = [], $stub = true)
    {
        $header = $this->getMockery('Swift_Mime_Headers_ParameterizedHeader')->shouldIgnoreMissing();
        $header->shouldReceive('getFieldName')
               ->zeroOrMoreTimes()
               ->andReturn($name);
        $header->shouldReceive('getFieldBodyModel')
               ->zeroOrMoreTimes()
               ->andReturn($model);
        $header->shouldReceive('getParameter')
               ->zeroOrMoreTimes()
               ->andReturnUsing(function ($key) use ($params) {
                   return $params[$key];
               });

        return $header;
    }

    protected function createOutputStream($data = null, $stub = true)
    {
        $os = $this->getMockery('Swift_OutputByteStream');
        if (isset($data)) {
            $os->shouldReceive('read')
               ->zeroOrMoreTimes()
               ->andReturnUsing(function () use ($data) {
                   static $first = true;
                   if (!$first) {
                       return false;
                   }

                   $first = false;

                   return $data;
               });
            $os->shouldReceive('setReadPointer')
              ->zeroOrMoreTimes();
        }

        return $os;
    }

    protected function createInputStream($stub = true)
    {
        return $this->getMockBuilder('Swift_InputByteStream')->getMock();
    }
}

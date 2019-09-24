<?php

namespace PhpMimeMailParser;

use PhpMimeMailParser\Contracts\CharsetManager;

/**
 * Parser of php-mime-mail-parser
 *
 * Fully Tested Mailparse Extension Wrapper for PHP 5.4+
 *
 */
class Parser
{
    /**
     * Attachment filename argument option for ->saveAttachments().
     */
    const ATTACHMENT_DUPLICATE_THROW  = 'DuplicateThrow';
    const ATTACHMENT_DUPLICATE_SUFFIX = 'DuplicateSuffix';
    const ATTACHMENT_RANDOM_FILENAME  = 'RandomFilename';

    /**
     * PHP MimeParser Resource ID
     *
     * @var resource $resource
     */
    protected $resource;

    /**
     * A file pointer to email
     *
     * @var resource $stream
     */
    protected $stream;

    /**
     * A text of an email
     *
     * @var string $data
     */
    protected $data;

    /**
     * Parts of an email
     *
     * @var array $parts
     */
    protected $parts;

    /**
     * @var CharsetManager object
     */
    protected $charset;

    /**
     * Valid stream modes for reading
     *
     * @var array
     */
    protected static $readableModes = [
        'r', 'r+', 'w+', 'a+', 'x+', 'c+', 'rb', 'r+b', 'w+b', 'a+b',
        'x+b', 'c+b', 'rt', 'r+t', 'w+t', 'a+t', 'x+t', 'c+t'
    ];

    /**
     * Stack of middleware registered to process data
     *
     * @var MiddlewareStack
     */
    protected $middlewareStack;

    /**
     * Parser constructor.
     *
     * @param CharsetManager|null $charset
     */
    public function __construct(CharsetManager $charset = null)
    {
        if ($charset == null) {
            $charset = new Charset();
        }

        $this->charset = $charset;
        $this->middlewareStack = new MiddlewareStack();
    }

    /**
     * Free the held resources
     *
     * @return void
     */
    public function __destruct()
    {
        // clear the email file resource
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }
        // clear the MailParse resource
        if (is_resource($this->resource)) {
            mailparse_msg_free($this->resource);
        }
    }

    /**
     * Set the file path we use to get the email text
     *
     * @param string $path File path to the MIME mail
     *
     * @return Parser MimeMailParser Instance
     */
    public function setPath($path)
    {
        if (is_writable($path)) {
            $file = fopen($path, 'a+');
            fseek($file, -1, SEEK_END);
            if (fread($file, 1) != "\n") {
                fwrite($file, PHP_EOL);
            }
            fclose($file);
        }

        // should parse message incrementally from file
        $this->resource = mailparse_msg_parse_file($path);
        $this->stream = fopen($path, 'r');
        $this->parse();

        return $this;
    }

    /**
     * Set the Stream resource we use to get the email text
     *
     * @param resource $stream
     *
     * @return Parser MimeMailParser Instance
     * @throws Exception
     */
    public function setStream($stream)
    {
        // streams have to be cached to file first
        $meta = @stream_get_meta_data($stream);
        if (!$meta || !$meta['mode'] || !in_array($meta['mode'], self::$readableModes, true) || $meta['eof']) {
            throw new Exception(
                'setStream() expects parameter stream to be readable stream resource.'
            );
        }

        /** @var resource $tmp_fp */
        $tmp_fp = tmpfile();
        if ($tmp_fp) {
            while (!feof($stream)) {
                fwrite($tmp_fp, fread($stream, 2028));
            }

            if (fread($tmp_fp, 1) != "\n") {
                fwrite($tmp_fp, PHP_EOL);
            }

            fseek($tmp_fp, 0);
            $this->stream = &$tmp_fp;
        } else {
            throw new Exception(
                'Could not create temporary files for attachments. Your tmp directory may be unwritable by PHP.'
            );
        }
        fclose($stream);

        $this->resource = mailparse_msg_create();
        // parses the message incrementally (low memory usage but slower)
        while (!feof($this->stream)) {
            mailparse_msg_parse($this->resource, fread($this->stream, 2082));
        }
        $this->parse();

        return $this;
    }

    /**
     * Set the email text
     *
     * @param string $data
     *
     * @return Parser MimeMailParser Instance
     */
    public function setText($data)
    {
        if (empty($data)) {
            throw new Exception('You must not call MimeMailParser::setText with an empty string parameter');
        }

        if (substr($data, -1) != "\n") {
            $data = $data . PHP_EOL;
        }

        $this->resource = mailparse_msg_create();
        // does not parse incrementally, fast memory hog might explode
        mailparse_msg_parse($this->resource, $data);
        $this->data = $data;
        $this->parse();

        return $this;
    }

    /**
     * Parse the Message into parts
     *
     * @return void
     */
    protected function parse()
    {
        $structure = mailparse_msg_get_structure($this->resource);
        $this->parts = [];
        foreach ($structure as $part_id) {
            $part = mailparse_msg_get_part($this->resource, $part_id);
            $part_data = mailparse_msg_get_part_data($part);
            $mimePart = new MimePart($part_id, $part_data);
            // let each middleware parse the part before saving
            $this->parts[$part_id] = $this->middlewareStack->parse($mimePart)->getPart();
        }
    }

    /**
     * Retrieve a specific Email Header, without charset conversion.
     *
     * @param string $name Header name (case-insensitive)
     *
     * @return string
     * @throws Exception
     */
    public function getRawHeader($name)
    {
        $name = strtolower($name);
        if (isset($this->parts[1])) {
            $headers = $this->getPart('headers', $this->parts[1]);

            return (isset($headers[$name])) ? $headers[$name] : false;
        } else {
            throw new Exception(
                'setPath() or setText() or setStream() must be called before retrieving email headers.'
            );
        }
    }

    /**
     * Retrieve a specific Email Header
     *
     * @param string $name Header name (case-insensitive)
     *
     * @return string
     */
    public function getHeader($name)
    {
        $rawHeader = $this->getRawHeader($name);
        if ($rawHeader === false) {
            return false;
        }

        return $this->decodeHeader($rawHeader);
    }

    /**
     * Retrieve all mail headers
     *
     * @return array
     * @throws Exception
     */
    public function getHeaders()
    {
        if (isset($this->parts[1])) {
            $headers = $this->getPart('headers', $this->parts[1]);
            foreach ($headers as $name => &$value) {
                if (is_array($value)) {
                    foreach ($value as &$v) {
                        $v = $this->decodeSingleHeader($v);
                    }
                } else {
                    $value = $this->decodeSingleHeader($value);
                }
            }

            return $headers;
        } else {
            throw new Exception(
                'setPath() or setText() or setStream() must be called before retrieving email headers.'
            );
        }
    }

    /**
     * Retrieve the raw mail headers as a string
     *
     * @return string
     * @throws Exception
     */
    public function getHeadersRaw()
    {
        if (isset($this->parts[1])) {
            return $this->getPartHeader($this->parts[1]);
        } else {
            throw new Exception(
                'setPath() or setText() or setStream() must be called before retrieving email headers.'
            );
        }
    }

    /**
     * Retrieve the raw Header of a MIME part
     *
     * @return String
     * @param $part Object
     * @throws Exception
     */
    protected function getPartHeader(&$part)
    {
        $header = '';
        if ($this->stream) {
            $header = $this->getPartHeaderFromFile($part);
        } elseif ($this->data) {
            $header = $this->getPartHeaderFromText($part);
        }
        return $header;
    }

    /**
     * Retrieve the Header from a MIME part from file
     *
     * @return String Mime Header Part
     * @param $part Array
     */
    protected function getPartHeaderFromFile(&$part)
    {
        $start = $part['starting-pos'];
        $end = $part['starting-pos-body'];
        fseek($this->stream, $start, SEEK_SET);
        $header = fread($this->stream, $end - $start);
        return $header;
    }

    /**
     * Retrieve the Header from a MIME part from text
     *
     * @return String Mime Header Part
     * @param $part Array
     */
    protected function getPartHeaderFromText(&$part)
    {
        $start = $part['starting-pos'];
        $end = $part['starting-pos-body'];
        $header = substr($this->data, $start, $end - $start);
        return $header;
    }

    /**
     * Checks whether a given part ID is a child of another part
     * eg. an RFC822 attachment may have one or more text parts
     *
     * @param string $partId
     * @param string $parentPartId
     * @return bool
     */
    protected function partIdIsChildOfPart($partId, $parentPartId)
    {
        $parentPartId = $parentPartId.'.';
        return substr($partId, 0, strlen($parentPartId)) == $parentPartId;
    }

    /**
     * Whether the given part ID is a child of any attachment part in the message.
     *
     * @param string $checkPartId
     * @return bool
     */
    protected function partIdIsChildOfAnAttachment($checkPartId)
    {
        foreach ($this->parts as $partId => $part) {
            if ($this->getPart('content-disposition', $part) == 'attachment') {
                if ($this->partIdIsChildOfPart($checkPartId, $partId)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Returns the email message body in the specified format
     *
     * @param string $type text, html or htmlEmbedded
     *
     * @return string Body
     * @throws Exception
     */
    public function getMessageBody($type = 'text')
    {
        $mime_types = [
            'text'         => 'text/plain',
            'html'         => 'text/html',
            'htmlEmbedded' => 'text/html',
        ];

        if (in_array($type, array_keys($mime_types))) {
            $part_type = $type === 'htmlEmbedded' ? 'html' : $type;
            $inline_parts = $this->getInlineParts($part_type);
            $body = empty($inline_parts) ? '' : $inline_parts[0];
        } else {
            throw new Exception(
                'Invalid type specified for getMessageBody(). Expected: text, html or htmlEmbeded.'
            );
        }

        if ($type == 'htmlEmbedded') {
            $attachments = $this->getAttachments();
            foreach ($attachments as $attachment) {
                if ($attachment->getContentID() != '') {
                    $body = str_replace(
                        '"cid:'.$attachment->getContentID().'"',
                        '"'.$this->getEmbeddedData($attachment->getContentID()).'"',
                        $body
                    );
                }
            }
        }

        return $body;
    }

    /**
     * Returns the embedded data structure
     *
     * @param string $contentId Content-Id
     *
     * @return string
     */
    protected function getEmbeddedData($contentId)
    {
        foreach ($this->parts as $part) {
            if ($this->getPart('content-id', $part) == $contentId) {
                $embeddedData = 'data:';
                $embeddedData .= $this->getPart('content-type', $part);
                $embeddedData .= ';'.$this->getPart('transfer-encoding', $part);
                $embeddedData .= ','.$this->getPartBody($part);
                return $embeddedData;
            }
        }
        return '';
    }

    /**
     * Return an array with the following keys display, address, is_group
     *
     * @param string $name Header name (case-insensitive)
     *
     * @return array
     */
    public function getAddresses($name)
    {
        $value = $this->getRawHeader($name);
        $value = (is_array($value)) ? $value[0] : $value;
        $addresses = mailparse_rfc822_parse_addresses($value);
        foreach ($addresses as $i => $item) {
            $addresses[$i]['display'] = $this->decodeHeader($item['display']);
        }
        return $addresses;
    }

    /**
     * Returns the attachments contents in order of appearance
     *
     * @return Attachment[]
     */
    public function getInlineParts($type = 'text')
    {
        $inline_parts = [];
        $mime_types = [
            'text'         => 'text/plain',
            'html'         => 'text/html',
        ];

        if (!in_array($type, array_keys($mime_types))) {
            throw new Exception('Invalid type specified for getInlineParts(). "type" can either be text or html.');
        }

        foreach ($this->parts as $partId => $part) {
            if ($this->getPart('content-type', $part) == $mime_types[$type]
                && $this->getPart('content-disposition', $part) != 'attachment'
                && !$this->partIdIsChildOfAnAttachment($partId)
            ) {
                $headers = $this->getPart('headers', $part);
                $encodingType = array_key_exists('content-transfer-encoding', $headers) ?
                    $headers['content-transfer-encoding'] : '';
                $undecoded_body = $this->decodeContentTransfer($this->getPartBody($part), $encodingType);
                $inline_parts[] = $this->charset->decodeCharset($undecoded_body, $this->getPartCharset($part));
            }
        }

        return $inline_parts;
    }

    /**
     * Returns the attachments contents in order of appearance
     *
     * @return Attachment[]
     */
    public function getAttachments($include_inline = true)
    {
        $attachments = [];
        $dispositions = $include_inline ? ['attachment', 'inline'] : ['attachment'];
        $non_attachment_types = ['text/plain', 'text/html'];
        $nonameIter = 0;

        foreach ($this->parts as $part) {
            $disposition = $this->getPart('content-disposition', $part);
            $filename = 'noname';

            if (isset($part['disposition-filename'])) {
                $filename = $this->decodeHeader($part['disposition-filename']);
                // Escape all potentially unsafe characters from the filename
                $filename = preg_replace('((^\.)|\/|(\.$))', '_', $filename);
            } elseif (isset($part['content-name'])) {
                // if we have no disposition but we have a content-name, it's a valid attachment.
                // we simulate the presence of an attachment disposition with a disposition filename
                $filename = $this->decodeHeader($part['content-name']);
                // Escape all potentially unsafe characters from the filename
                $filename = preg_replace('((^\.)|\/|(\.$))', '_', $filename);
                $disposition = 'attachment';
            } elseif (in_array($part['content-type'], $non_attachment_types, true)
                && $disposition !== 'attachment') {
                // it is a message body, no attachment
                continue;
            } elseif (substr($part['content-type'], 0, 10) !== 'multipart/') {
                // if we cannot get it by getMessageBody(), we assume it is an attachment
                $disposition = 'attachment';
            }
            if (in_array($disposition, ['attachment', 'inline']) === false && !empty($disposition)) {
                $disposition = 'attachment';
            }

            if (in_array($disposition, $dispositions) === true) {
                if ($filename == 'noname') {
                    $nonameIter++;
                    $filename = 'noname'.$nonameIter;
                }

                $headersAttachments = $this->getPart('headers', $part);
                $contentidAttachments = $this->getPart('content-id', $part);

                $attachmentStream = $this->getAttachmentStream($part);
                $mimePartStr = $this->getPartComplete($part);

                $attachments[] = new Attachment(
                    $filename,
                    $this->getPart('content-type', $part),
                    $attachmentStream,
                    $disposition,
                    $contentidAttachments,
                    $headersAttachments,
                    $mimePartStr
                );
            }
        }

        return $attachments;
    }

    /**
     * Save attachments in a folder
     *
     * @param string $attach_dir directory
     * @param bool $include_inline
     * @param string $filenameStrategy How to generate attachment filenames
     *
     * @return array Saved attachments paths
     * @throws Exception
     */
    public function saveAttachments(
        $attach_dir,
        $include_inline = true,
        $filenameStrategy = self::ATTACHMENT_DUPLICATE_SUFFIX
    ) {
        $attachments = $this->getAttachments($include_inline);
        if (empty($attachments)) {
            return false;
        }

        $attachments_paths = [];
        foreach ($attachments as $attachment) {
            $attachments_paths[] = $attachment->save($attach_dir, $include_inline, $filenameStrategy);
        }

        return $attachments_paths;
    }

    /**
     * Read the attachment Body and save temporary file resource
     *
     * @param array $part
     *
     * @return resource Mime Body Part
     * @throws Exception
     */
    protected function getAttachmentStream(&$part)
    {
        /** @var resource $temp_fp */
        $temp_fp = tmpfile();

        $headers = $this->getPart('headers', $part);
        $encodingType = array_key_exists('content-transfer-encoding', $headers) ?
            $headers['content-transfer-encoding'] : '';

        if ($temp_fp) {
            if ($this->stream) {
                $start = $part['starting-pos-body'];
                $end = $part['ending-pos-body'];
                fseek($this->stream, $start, SEEK_SET);
                $len = $end - $start;
                $written = 0;
                while ($written < $len) {
                    $write = $len;
                    $data = fread($this->stream, $write);
                    fwrite($temp_fp, $this->decodeContentTransfer($data, $encodingType));
                    $written += $write;
                }
            } elseif ($this->data) {
                $attachment = $this->decodeContentTransfer($this->getPartBodyFromText($part), $encodingType);
                fwrite($temp_fp, $attachment, strlen($attachment));
            }
            fseek($temp_fp, 0, SEEK_SET);
        } else {
            throw new Exception(
                'Could not create temporary files for attachments. Your tmp directory may be unwritable by PHP.'
            );
        }

        return $temp_fp;
    }

    /**
     * Decode the string from Content-Transfer-Encoding
     *
     * @param string $encodedString The string in its original encoded state
     * @param string $encodingType  The encoding type from the Content-Transfer-Encoding header of the part.
     *
     * @return string The decoded string
     */
    protected function decodeContentTransfer($encodedString, $encodingType)
    {
        if (is_array($encodingType)) {
            $encodingType = $encodingType[0];
        }

        $encodingType = strtolower($encodingType);
        if ($encodingType == 'base64') {
            return base64_decode($encodedString);
        } elseif ($encodingType == 'quoted-printable') {
            return quoted_printable_decode($encodedString);
        } else {
            return $encodedString;
        }
    }

    /**
     * $input can be a string or array
     *
     * @param string|array $input
     *
     * @return string
     */
    protected function decodeHeader($input)
    {
        //Sometimes we have 2 label From so we take only the first
        if (is_array($input)) {
            return $this->decodeSingleHeader($input[0]);
        }

        return $this->decodeSingleHeader($input);
    }

    /**
     * Decodes a single header (= string)
     *
     * @param string $input
     *
     * @return string
     */
    protected function decodeSingleHeader($input)
    {
        // For each encoded-word...
        while (preg_match('/(=\?([^?]+)\?(q|b)\?([^?]*)\?=)((\s+)=\?)?/i', $input, $matches)) {
            $encoded = $matches[1];
            $charset = $matches[2];
            $encoding = $matches[3];
            $text = $matches[4];
            $space = isset($matches[6]) ? $matches[6] : '';

            switch (strtolower($encoding)) {
                case 'b':
                    $text = $this->decodeContentTransfer($text, 'base64');
                    break;

                case 'q':
                    $text = str_replace('_', ' ', $text);
                    preg_match_all('/=([a-f0-9]{2})/i', $text, $matches);
                    foreach ($matches[1] as $value) {
                        $text = str_replace('='.$value, chr(hexdec($value)), $text);
                    }
                    break;
            }

            $text = $this->charset->decodeCharset($text, $this->charset->getCharsetAlias($charset));
            $input = str_replace($encoded.$space, $text, $input);
        }

        return $input;
    }

    /**
     * Return the charset of the MIME part
     *
     * @param array $part
     *
     * @return string
     */
    protected function getPartCharset($part)
    {
        if (isset($part['charset'])) {
            return $this->charset->getCharsetAlias($part['charset']);
        } else {
            return 'us-ascii';
        }
    }

    /**
     * Retrieve a specified MIME part
     *
     * @param string $type
     * @param array  $parts
     *
     * @return string|array
     */
    protected function getPart($type, $parts)
    {
        return (isset($parts[$type])) ? $parts[$type] : false;
    }

    /**
     * Retrieve the Body of a MIME part
     *
     * @param array $part
     *
     * @return string
     */
    protected function getPartBody(&$part)
    {
        $body = '';
        if ($this->stream) {
            $body = $this->getPartBodyFromFile($part);
        } elseif ($this->data) {
            $body = $this->getPartBodyFromText($part);
        }

        return $body;
    }

    /**
     * Retrieve the Body from a MIME part from file
     *
     * @param array $part
     *
     * @return string Mime Body Part
     */
    protected function getPartBodyFromFile(&$part)
    {
        $start = $part['starting-pos-body'];
        $end = $part['ending-pos-body'];
        $body = '';
        if ($end - $start > 0) {
            fseek($this->stream, $start, SEEK_SET);
            $body = fread($this->stream, $end - $start);
        }

        return $body;
    }

    /**
     * Retrieve the Body from a MIME part from text
     *
     * @param array $part
     *
     * @return string Mime Body Part
     */
    protected function getPartBodyFromText(&$part)
    {
        $start = $part['starting-pos-body'];
        $end = $part['ending-pos-body'];

        return substr($this->data, $start, $end - $start);
    }

    /**
     * Retrieve the content of a MIME part
     *
     * @param array $part
     *
     * @return string
     */
    protected function getPartComplete(&$part)
    {
        $body = '';
        if ($this->stream) {
            $body = $this->getPartFromFile($part);
        } elseif ($this->data) {
            $body = $this->getPartFromText($part);
        }

        return $body;
    }

    /**
     * Retrieve the content from a MIME part from file
     *
     * @param array $part
     *
     * @return string Mime Content
     */
    protected function getPartFromFile(&$part)
    {
        $start = $part['starting-pos'];
        $end = $part['ending-pos'];
        $body = '';
        if ($end - $start > 0) {
            fseek($this->stream, $start, SEEK_SET);
            $body = fread($this->stream, $end - $start);
        }

        return $body;
    }

    /**
     * Retrieve the content from a MIME part from text
     *
     * @param array $part
     *
     * @return string Mime Content
     */
    protected function getPartFromText(&$part)
    {
        $start = $part['starting-pos'];
        $end = $part['ending-pos'];

        return substr($this->data, $start, $end - $start);
    }

    /**
     * Retrieve the resource
     *
     * @return resource resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Retrieve the file pointer to email
     *
     * @return resource stream
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Retrieve the text of an email
     *
     * @return string data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Retrieve the parts of an email
     *
     * @return array parts
     */
    public function getParts()
    {
        return $this->parts;
    }

    /**
     * Retrieve the charset manager object
     *
     * @return CharsetManager charset
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Add a middleware to the parser MiddlewareStack
     * Each middleware is invoked when:
     *   a MimePart is retrieved by mailparse_msg_get_part_data() during $this->parse()
     * The middleware will receive MimePart $part and the next MiddlewareStack $next
     *
     * Eg:
     *
     * $Parser->addMiddleware(function(MimePart $part, MiddlewareStack $next) {
     *      // do something with the $part
     *      return $next($part);
     * });
     *
     * @param callable $middleware Plain Function or Middleware Instance to execute
     * @return void
     */
    public function addMiddleware(callable $middleware)
    {
        if (!$middleware instanceof Middleware) {
            $middleware = new Middleware($middleware);
        }
        $this->middlewareStack = $this->middlewareStack->add($middleware);
    }
}

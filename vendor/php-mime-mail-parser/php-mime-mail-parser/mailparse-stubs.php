<?php
/**
 * @link http://php.net/manual/en/mailparse.constants.php
 */
define('MAILPARSE_EXTRACT_OUTPUT', 0);

/**
 * @link http://php.net/manual/en/mailparse.constants.php
 */
define('MAILPARSE_EXTRACT_STREAM', 1);

/**
 * @link http://php.net/manual/en/mailparse.constants.php
 */
define('MAILPARSE_EXTRACT_RETURN', 2);

/**
 * Parses a file. This is the optimal way of parsing a mail file that you have on
 * disk.
 *
 * @link http://php.net/manual/en/functions.mailparse-msg-parse-file.php
 *
 * @param string $filename Path to the file holding the message. The file is opened
 *                         and streamed through the parser
 *
 * @return resource Returns a MIME resource representing the structure, or false on error
 */
function mailparse_msg_parse_file($filename)
{
}

/**
 * .
 *
 * @link http://php.net/manual/en/functions.mailparse-msg-get-part.php
 *
 * @param resource $mimemail A valid MIME resource
 * @param string   $mimesection
 *
 * @return resource
 */
function mailparse_msg_get_part($mimemail, $mimesection)
{
}

/**
 * .
 *
 * @link http://php.net/manual/en/functions.mailparse-msg-get-structure.php
 *
 * @param resource $mimemail A valid MIME resource
 *
 * @return array
 */
function mailparse_msg_get_structure($mimemail)
{
}

/**
 * .
 *
 * @link http://php.net/manual/en/functions.mailparse-msg-get-part-data.php
 *
 * @param resource $mimemail A valid MIME resource
 *
 * @return array
 */
function mailparse_msg_get_part_data($mimemail)
{
}

/**
 * .
 *
 * @link http://php.net/manual/en/functions.mailparse-msg-extract-part.php
 *
 * @param resource $mimemail A valid MIME resource
 * @param string   $msgbody
 * @param callable $callbackfunc
 *
 * @return void
 */
function mailparse_msg_extract_part($mimemail, $msgbody, $callbackfunc)
{
}

/**
 * Extracts/decodes a message section from the supplied filename.
 *
 * @link http://php.net/manual/en/functions.mailparse-msg-extract-part-file.php
 *
 * @param resource $mimemail     A valid MIME resource, created with
 *                               mailparse_msg_create
 * @param mixed    $filename     Can be a file name or a valid stream resource
 * @param callable $callbackfunc If set, this must be either a valid callback that
 *                               will be passed the extracted section, or null to make this function return the
 *                               extracted section
 *
 * @return string If $callbackfunc is not null returns true on success
 */
function mailparse_msg_extract_part_file($mimemail, $filename, $callbackfunc = false)
{
}

/**
 * .
 *
 * @link http://php.net/manual/en/functions.mailparse-msg-extract-whole-part-file.php
 *
 * @param resource $mimemail A valid MIME resource
 * @param string   $filename
 * @param callable $callbackfunc
 *
 * @return string
 */
function mailparse_msg_extract_whole_part_file($mimemail, $filename, $callbackfunc)
{
}

/**
 * Create a MIME mail resource.
 *
 * @link http://php.net/manual/en/functions.mailparse-msg-create.php
 * @return resource Returns a handle that can be used to parse a message
 */
function mailparse_msg_create()
{
}

/**
 * Frees a MIME resource.
 *
 * @link http://php.net/manual/en/functions.mailparse-msg-free.php
 *
 * @param resource $mimemail A valid MIME resource allocated by
 *                           mailparse_msg_create or mailparse_msg_parse_file
 *
 * @return bool
 */
function mailparse_msg_free($mimemail)
{
}

/**
 * Incrementally parse data into the supplied mime mail resource.
 *
 * @link http://php.net/manual/en/functions.mailparse-msg-parse.php
 *
 * @param resource $mimemail A valid MIME resource
 * @param string   $data
 *
 * @return bool
 */
function mailparse_msg_parse($mimemail, $data)
{
}

/**
 * Parses a RFC 822 compliant recipient list, such as that found in the To: header.
 *
 * @link http://php.net/manual/en/functions.mailparse-rfc822-parse-addresses.php
 *
 * @param string $addresses A string containing addresses, like in: Wez Furlong
 *                          wez@example.com, doe@example.com
 *
 * @return array Returns an array of associative arrays with the following keys for each
 *         recipient: display The recipient name, for display purpose. If this part is not
 *         set for a recipient, this key will hold the same value as address. address The
 *         email address is_group true if the recipient is a newsgroup, false otherwise
 */
function mailparse_rfc822_parse_addresses($addresses)
{
}

/**
 * Figures out the best way of encoding the content read from the given file
 * pointer.
 *
 * @link http://php.net/manual/en/functions.mailparse-determine-best-xfer-encoding.php
 *
 * @param resource $fp A valid file pointer, which must be seek-able
 *
 * @return string Returns one of the character encodings supported by the mbstring module
 */
function mailparse_determine_best_xfer_encoding($fp)
{
}

/**
 * Streams data from the source file pointer, apply $encoding and write to the
 * destination file pointer.
 *
 * @link http://php.net/manual/en/functions.mailparse-stream-encode.php
 *
 * @param resource $sourcefp A valid file handle. The file is streamed through the
 *                           parser
 * @param resource $destfp   The destination file handle in which the encoded data
 *                           will be written
 * @param string   $encoding One of the character encodings supported by the mbstring
 *                           module
 *
 * @return bool
 */
function mailparse_stream_encode($sourcefp, $destfp, $encoding)
{
}

/**
 * Scans the data from the given file pointer and extract each embedded uuencoded
 * file into a temporary file.
 *
 * @link http://php.net/manual/en/functions.mailparse-uudecode-all.php
 *
 * @param resource $fp A valid file pointer
 *
 * @return array Returns an array of associative arrays listing filename information.
 *         filename Path to the temporary file name created origfilename The original
 *         filename, for uuencoded parts only The first filename entry is the message body.
 *         The next entries are the decoded uuencoded files
 */
function mailparse_uudecode_all($fp)
{
}

/**
 * @return
 */
function mailparse_test()
{
}

class mimemessage
{
    /**
     * @return
     */
    public function mimemessage()
    {
    }

    /**
     * @return
     */
    public function get_child()
    {
    }

    /**
     * @return
     */
    public function get_child_count()
    {
    }

    /**
     * @return
     */
    public function get_parent()
    {
    }

    /**
     * @return
     */
    public function extract_headers()
    {
    }

    /**
     * @return
     */
    public function extract_body()
    {
    }

    /**
     * @return
     */
    public function enum_uue()
    {
    }

    /**
     * @return
     */
    public function extract_uue()
    {
    }

    /**
     * @return
     */
    public function remove()
    {
    }

    /**
     * @return
     */
    public function add_child()
    {
    }
}

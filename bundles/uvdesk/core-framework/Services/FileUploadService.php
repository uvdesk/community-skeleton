<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Services;

use Webkul\UVDesk\CoreFrameworkBundle\Utils\TokenGenerator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

class FileUploadService extends \Webkul\UVDesk\CoreFrameworkBundle\FileSystem\UploadManagers\Localhost
{
    public function uploadFile(UploadedFile $temporaryFile, $prefix = null, bool $renameFile = true)
    {
        $fileName = $temporaryFile->getClientOriginalName();
        $fileData = parent::uploadFile($temporaryFile, $prefix, $renameFile);
        $fileData['name'] = $fileName;
        return $fileData;
    }

    public function fileRemoveFromFolder($filepath)
    {
        $fs = new Filesystem();
        if($fs->exists("$filepath")) {
            $fs->remove("$filepath");
            return true;
        }
        return false;
    }

	public function svgFileCheck($file, $filename = null)
	{
        
		// Return error if the file is not uploaded.
		if (!$file || !file_exists($file) || !is_uploaded_file($file))
		{
			return false;
		}
		
		// Return error if the file size is zero.
		if (($filesize = filesize($file)) == 0)
		{
			return false;
		}
		
		// Get the extension.
		$ext = $filename ? strtolower(substr(strrchr($filename, '.'), 1)) : '';
		
		// Check the first 4KB of the file for possible XML content.
		$fp = fopen($file, 'rb');
		$first4kb = fread($fp, 4096);
		$is_xml = preg_match('/<(?:\?xml|!DOCTYPE|html|head|body|meta|script|svg)\b/i', $first4kb);
        
		// Check SVG files.
		if (($ext === 'svg' || $is_xml) && !self::_checkSVG($fp, 0, $filesize))
		{
			fclose($fp);
			return false;
		}
		
		// Check XML files.
		if (($ext === 'xml' || $is_xml) && !self::_checkXML($fp, 0, $filesize))
		{
			fclose($fp);
			return false;
		}
		
		// Check HTML files.
		if (($ext === 'html' || $ext === 'shtml' || $ext === 'xhtml' || $ext === 'phtml' || $is_xml) && !self::_checkHTML($fp, 0, $filesize))
		{
			fclose($fp);
			return false;
		}
		
		// Return true if everything is OK.
		fclose($fp);
		return true;
	}
	
	/**
	 * Check SVG file for XSS or SSRF vulnerabilities (#1088, #1089)
	 *
	 */
	protected static function _checkSVG($fp, $from, $to)
	{
		if (self::_matchStream('/<script|<handler\b|xlink:href\s*=\s*"(?!data:)/i', $fp, $from, $to))
		{
			return false;
		}
		if (self::_matchStream('/\b(?:ev:(?:event|listener|observer)|on[a-z]+)\s*=/i', $fp, $from, $to))
		{
			return false;
		}
		
		return true;
	}
	
	/**
	 * Check XML file for external entity inclusion.
	 *
	 */
	protected static function _checkXML($fp, $from, $to)
	{
		if (self::_matchStream('/<!ENTITY/i', $fp, $from, $to))
		{
			return false;
		}
		
		return true;
	}
	
	/**
	 * Check HTML file for PHP code, server-side includes, and other nastiness.
	 *
	 */
	protected static function _checkHTML($fp, $from, $to)
	{
		if (self::_matchStream('/<\?(?!xml\b)|<!--#(?:include|exec|echo|config|fsize|flastmod|printenv)\b/i', $fp, $from, $to))
		{
			return false;
		}
		
		return true;
	}
	
	/**
	 * Match a stream against a regular expression.
	 * 
	 * This method is useful when dealing with large files,
	 * because we don't need to load the entire file into memory.
	 * We allow a generous overlap in case the matching string
	 * occurs across a block boundary.
	 * 
	 */
	protected static function _matchStream($regexp, $fp, $from, $to, $block_size = 16384, $overlap_size = 1024)
	{
		fseek($fp, $position = $from);
		while (strlen($content = fread($fp, $block_size + $overlap_size)) > 0)
		{
			if (preg_match($regexp, $content))
			{
				return true;
			}
			fseek($fp, min($to, $position += $block_size));
		}
		return false;
	}
}
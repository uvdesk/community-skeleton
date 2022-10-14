<?php

namespace Webkul\UVDesk\CoreFrameworkBundle\Utils;

/**
 * Generates a unique random string that can be used be as token as well.
 */
class TokenGenerator
{
	const CODE_LENGTH = 62;
	const CODE_SPAN = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

	/**
	 * Generates a unique token.
	 * 
	 * @param  integer 	$length 		The length of the token to be generated.
     * @param  string 	$range 		    Range of characters that should be used.
	 * 
	 * @return string          			The generated token.
	 */
    public static function generateToken($length = 32, $range = '')
    {
    	$token = '';
        $counter = 0;
        $codeRange = !empty($range) ? $range : self::CODE_SPAN;
        $codeLength = strlen($codeRange) - 1;

        do {
			$token .= $codeRange[self::crypto_rand_secure(0, $codeLength)];
        } while ($length != ++$counter);

        return $token;
    }

    /**
     * Generates a random number.
     * 
     * @param  integer $minValue 		Lower bound value.
     * @param  integer $maxValue 		Upper bound value.
     * 
     * @return integer            		Random number within the bounded range.
     */
    private static function crypto_rand_secure($minValue = 0, $maxValue = 0)
    {
        if (($span = ($maxValue - $minValue)) < 1)
            return $minValue;

        $log = ceil(log($span, 2)); // Calculate log
        $bitLength = (int) $log + 1; // Get length in bits
        $byteLength = (int) ($log / 8) + 1; // Get length in bytes
        $filter = (int) (1 << $bitLength) - 1; // Filter bits - Sets all lower bits to 1

        do {
            $randomNumber = hexdec(bin2hex(openssl_random_pseudo_bytes($byteLength)));
            $randomNumber = $randomNumber & $filter; // Discard irrelevant bits
        } while ($randomNumber > $span);

        return $minValue + $randomNumber;
    }
}

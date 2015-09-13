<?php 
	session_start();
	// Function called from the controller to encrypt a string.
	function bitwiseEncrypt($plaintext)
	{
		$_SESSION["key"] = generateKey(strlen($plaintext));
		return encode($plaintext, $_SESSION["key"]);
	}
	// Function called from the controller to decode a string.
	function bitwiseDecode($encryptedText)
	{
		return decode($encryptedText, $_SESSION["key"]);
	}
	// Randomly generates a key unique to the Bitwise Cipher.
	function generateKey($length)
	{
		$key = "";
		for( $i = 0; $i < $length; $i++ )
		{
			$key .= dechex( rand(97, 122) );
		}
		return $key;
	}
	// Take a perfectly good string and encodes it.
	function encode($plaintext, $key)
	{
		$cleanText = clean($plaintext);
		return bin2hex( pack('H*', $cleanText) ^ pack('H*', $key) );
	}
	// Take a chunk of mysterious code and decode it.
	function decode($encryptedText, $key)
	{
		$decodedText = bin2hex( pack('H*', $encryptedText) ^ pack('H*', $key) );
		for( $i = 0; $i < strlen($decodedText) - 1; $i += 2 )
		{
			$AscVal = hexdec( substr($decodedText, $i, 2) );
			$readableText .= chr($AscVal);
		}
		return $readableText;
	}
	// First converts every character into its Ascii equivalent.
	// Then it converts the Ascii value into hex values.
	function clean($plaintext)
	{
		for( $i = 0; $i < strlen($plaintext); $i++ )
		{
			$AscVal = ord($plaintext{$i});
			$cleanText .= dechex($AscVal);
		}
		return $cleanText;
	}
?>
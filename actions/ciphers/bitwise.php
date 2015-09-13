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
		$temp = "";
		for( $i = 0; $i < $length; $i++ )
		{
			$temp .= chr( rand(97, 122) );
		}
		echo $temp, "<br>";
		$key = bin2hex( pack('H*', $temp) );
		echo $key, "<br>";
		return $key;
	}
	// Take a perfectly good string and encodes it.
	function encode($plaintext, $key)
	{
		$encryptedText = "";

		$cleanText = clean($plaintext);
		echo $cleanText, "<br>";
		


		return $encryptedText;
	}
	// Take a chunk of mysterious code and decode it.
	function decode($encryptedText, $key)
	{
		$decodedText = "";



		return $decodedText;
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
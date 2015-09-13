<?php 
	session_start();
	// Function called from the controller to encrypt a string.
	function bitwiseEncrypt($plaintext)
	{
		

		return encode($plaintext);
	}
	// Function called from the controller to decode a string.
	function bitwiseDecode($encryptedText)
	{
		

		return decode($encryptedText);
	}
	// Randomly generates a key unique to the Bitwise Cipher.
	function generateKey()
	{
		

		return $key;
	}
	// Take a perfectly good string and encodes it.
	function encode($plaintext)
	{
		$encryptedText = "";

		$cleanText = clean($plaintext);

		

		return $encryptedText;
	}
	// Take a chunk of mysterious code and decode it.
	function decode($encryptedText)
	{
		$decodedText = "";



		return $decodedText;
	}
	// First converts every character into its Ascii equivalent.
	// Then it converts the Ascii value into hex values.
	function clean($plaintext)
	{
		$cleanText = "";
		for( $i = 0; $i < strlen($plaintext); $i++ )
		{
			
		}

		return $cleanText;
	}
?>
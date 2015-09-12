<?php 
	session_start();
	// Function called from the controller to encrypt a string.
	function foursquareEncrypt($plaintext)
	{
		$encryptedText = "";
		$upperLeft = "abcdefghiklmnopqrstuvwxyz";
		$lowerRight = "abcdefghiklmnopqrstuvwxyz";

		$key1 = generateKey();
		$key2 = generateKey();

		return $encryptedText;
	}
	// Function called from the controller to decode a string.
	function foursquareDecode($encryptedText)
	{
		$decodedText = "";
		$upperLeft = "abcdefghiklmnopqrstuvwxyz";
		$lowerRight = "abcdefghiklmnopqrstuvwxyz";
		
		$key1 = generateKey();
		$key2 = generateKey();

		return $decodedText;
	}
	// Randomly generates a key unique to the Foursquare Cipher.
	function generateKey()
	{
		$alphabetTemplate = "abcdefghiklmnopqrstuvwxyz";
		$key = "";
	
		while(strlen($alphabetTemplate) > 0)
		{
			$alphabetTemplateLength = strlen($alphabetTemplate);
			$randomLetterIndex = rand( 0, $alphabetTemplateLength - 1 );
			$key .= $alphabetTemplate{$randomLetterIndex};
			$truncatedString = substr_replace($alphabetTemplate, "", $randomLetterIndex, 1);
			$alphabetTemplate = $truncatedString;
		}

		return $key;
	}

?>
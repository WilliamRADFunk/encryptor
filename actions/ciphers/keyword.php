<?php 
	session_start();
	// Function called from the controller to encrypt a string.
	function keywordEncrypt($plaintext)
	{
		$_SESSION["key"] = generateKey();
		return encode($plaintext, $_SESSION["key"]);
	}
	// Function called from the controller to decode a string.
	function keywordDecode($encryptedText)
	{
		return decode($encryptedText, $_SESSION["key"]);
	}
	// Randomly generates a key unique to the Keyword Cipher.
	function generateKey()
	{
		$dictionary = fopen( "../../assets/TemporaryDictionaryFiltered.txt", "r") or die("Unable to open file!" );
		$key = "";
		$count = 0;
		$word = rand(1, 50086);

		while( !feof($dictionary) && $count < $word )
		{
			$count++;
			$key = fgets($dictionary);
		}
		
		fclose($dictionary);

		return trim($key);
	}
	// Take a perfectly good string and encodes it.
	function encode($plaintext, $key)
	{
		$encryptedText = "";
		$alphabetTemplate = "abcdefghiklmnopqrstuvwxyz";
		$cleanText = clean($plaintext);
		$cipherString = getCipherString($key);

		for( $i = 0; $i < strlen($cleanText); $i++ )
		{
			if( (ord($cleanText{$i}) >= 97) && (ord($cleanText{$i}) <= 122) )
			{
				$subNum = strpos($cipherString, $cleanText{$i});
				$encryptedText .= $alphabetTemplate{$subNum};
			}
			else
			{
				$encryptedText .= $cleanText{$i};
			}
		}

		return $encryptedText;
	}
	// Take a chunk of mysterious code and decode it.
	function decode($encryptedText, $key)
	{
		$decodedText = "";
		$alphabetTemplate = "abcdefghiklmnopqrstuvwxyz";
		$cipherString = getCipherString($key);

		for( $i = 0; $i < strlen($encryptedText); $i++ )
		{
			if( (ord($encryptedText{$i}) >= 97) && (ord($encryptedText{$i}) <= 122) )
			{
				$subNum = strpos($alphabetTemplate, $encryptedText{$i});
				$decodedText .= $cipherString{$subNum};
			}
			else
			{
				$decodedText .= $encryptedText{$i};
			}
		}

		return $decodedText;
	}
	// Cleans plaintext specific to the keyword cipher
	function clean($plaintext)
	{
		$cleanText = "";
		for( $i = 0; $i < strlen($plaintext); $i++ )
		{
			if( (ord($plaintext{$i}) >= 65) && (ord($plaintext{$i}) <= 90) )
			{
				$cleanText .= strtolower($plaintext{$i});
			}
			else
			{
				$cleanText .= $plaintext{$i};
			}
		}

		return $cleanText;
	}
	// Uses keyword to construct the 5 x 5 letter cipher string.
	function getCipherString($key)
	{
		$alphabetTemplate = "abcdefghiklmnopqrstuvwxyz";
		$cleanKey = stripRepeats($key);
		$cipherString = $cleanKey;

		for( $i = 0; $i < strlen($alphabetTemplate); $i++ )
		{
			if( strpos($cipherString, $alphabetTemplate{$i}) === false )
			{
				$cipherString .= $alphabetTemplate{$i};
			}
		}
		return trim($cipherString);
	}
	// Removes repeated letters from a string.
	function stripRepeats($key)
	{
		$newKey = "";
		for( $i = 0; $i < strlen($key); $i++ )
		{
			if( strpos($newKey, $key{$i}) === false )
			{
				$newKey .= $key{$i};
			}
		}
		return trim($newKey);
	}
?>
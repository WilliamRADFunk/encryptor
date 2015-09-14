<?php 
	session_start();
	// Function called from the controller to encrypt a string.
	function vigenereEncrypt($plaintext)
	{
		$_SESSION["key"] = generateKey();
		return encode($plaintext, $_SESSION["key"]);
	}
	// Function called from the controller to decode a string.
	function vigenereDecode($encryptedText)
	{
		return decode($encryptedText, $_SESSION["key"]);
	}
	// Randomly generates a key unique to the Vigenere Cipher.
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
		$cipherTable = tableMaker($key);

		for( $i = 0; $i < strlen($cleanText) - 1; $i += 2 )
		{
			$pair = textPairing($cleanText, $i);
			$match = encodeMatch($pair, $cipherTable);
			$encryptedText .= $match;
		}
		return $encryptedText;
	}
	// Take a chunk of mysterious code and decode it.
	function decode($encryptedText, $key)
	{
		$decodedText = "";
		$alphabetTemplate = "abcdefghiklmnopqrstuvwxyz";
		$cipherTable = tableMaker($key);

		for( $i = 0; $i < strlen($encryptedText) - 1; $i += 2 )
		{
			$pair = textPairing($encryptedText, $i);
			$match = decodeMatch($pair, $cipherTable);
			$decodedText .= $match;
		}

		return $decodedText;
	}
	// Cleans plaintext specific to the vigenere cipher
	// Only letters count, upper is changed to lower, and
	// an odd length string is padded with an extra "x."
	function clean($plaintext)
	{
		$cleanText = "";

		for( $i = 0; $i < strlen($plaintext); $i++ )
		{
			if( (ord($plaintext{$i}) == 74) || (ord($plaintext{$i}) == 106) )
			{
				$cleanText .= "i";
				continue;
			}
			
			if( (ord($plaintext{$i}) >= 65) && (ord($plaintext{$i}) <= 90) )
			{
				$plaintext = substr_replace($plaintext, strtolower($plaintext{$i}), $plaintext{$i}, 1);
			}

			if( (ord($plaintext{$i}) >= 97) && (ord($plaintext{$i}) <= 122) )
			{
				$cleanText .= $plaintext{$i};
			}
		}

		if( (strlen($cleanText) % 2) != 0 )
		{
			$cleanText .= "x";
		}
		
		return $cleanText;
	}
	// Uses alphabet to construct the 26 x 26 letter vigenere table.
	function tableMaker($key)
	{
		$alphabetTemplate = "abcdefghiklmnopqrstuvwxyz";
		$cleanKey = stripRepeats($key);
		$cipherTable = $cleanKey;

		for( $i = 0; $i < strlen($alphabetTemplate); $i++ )
		{
			if( strpos($cipherTable, $alphabetTemplate{$i}) === false )
			{
				$cipherTable .= $alphabetTemplate{$i};
			}
		}
		return trim($cipherTable);
	}
	?>
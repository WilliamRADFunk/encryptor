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
		$cleanText = clean($plaintext);
		$vKeyLength = getTextLength($cleanText);
		$vKey = getVKey( $key, $vKeyLength );

		$counter = 0;
		for( $i = 0; $i < strlen($cleanText); $i++ )
		{
			if( (ord($cleanText{$i}) >= 97) && (ord($cleanText{$i}) <= 122) )
			{
				$match = encodeMatch($vKey{$counter++}, $cleanText{$i});
				$encryptedText .= $match;
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
		$cleanText = clean($encryptedText);
		$vKeyLength = getTextLength($cleanText);
		$vKey = getVKey( $key, $vKeyLength );

		$counter = 0;
		for( $i = 0; $i < strlen($encryptedText); $i++ )
		{
			if( (ord($encryptedText{$i}) >= 97) && (ord($encryptedText{$i}) <= 122) )
			{
				$match = decodeMatch($vKey{$counter++}, $encryptedText{$i});
				$decodedText .= $match;
			}
			else
			{
				$decodedText .= $encryptedText{$i};
			}
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
	// Finds the number of encodable characters.
	function getTextLength($cleanText)
	{
		$counter = 0;
		for( $i = 0; $i < strlen($cleanText); $i++ )
		{
			if( (ord($cleanText{$i}) >= 97) && (ord($cleanText{$i}) <= 122) )
			{
				$counter++;
			}
		}
		return $counter;
	}
	// Converts keyword into a key that matches length of plaintext's
	// total number of encodable characters.
	function getVKey( $key, $length )
	{
		$vKey = "";
		for( $i = 0; $i < $length; )
		{
			for( $j = 0; $j < strlen($key); $j++ )
			{
				$vKey .= $key{$j};
				$i++;
				if( $i >= $length )
				{
					break;
				}
			}
		}
		return $vKey;
	}
	// Finds an encryption match for each encodable character.
	function encodeMatch($keyChar, $textChar)
	{
			$index1 = (ord($textChar) % 97);
			$index2 = (ord($keyChar) % 97);
			return chr( (($index1 + $index2) % 26) + 97 );
	}
	// Decodes each inputed character using the key.
	function decodeMatch($keyChar, $textChar)
	{
			$index1 = (ord($textChar) % 97);
			$index2 = (ord($keyChar) % 97);
			if( ($index1 - $index2) < 0)
			{
				return chr( (($index1 - $index2) + 26) + 97 );
			}
			return chr( (abs($index1 - $index2) % 26) + 97 );
	}
?>
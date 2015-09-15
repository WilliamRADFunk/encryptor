<?php 
	session_start();
	// Function called from the controller to encrypt a string.
	function railfenceEncrypt($plaintext)
	{
		$_SESSION["key"] = generateKey();
		return encode($plaintext, $_SESSION["key"]);
	}
	// Function called from the controller to decode a string.
	function railfenceDecode($encryptedText)
	{
		return decode($encryptedText, $_SESSION["key"]);
	}
	// Randomly generates a key unique to the Railfence Cipher.
	function generateKey()
	{
		return rand(3, 5);
	}
	// Take a perfectly good string and encodes it.
	function encode($plaintext, $key)
	{
		$encryptedText = "";
		$cleanText = clean($plaintext);
		$textLength = getTextLength($cleanText);
		$paddedText - padText($cleanText, $key, $textLength);
		$numOfRows = $textLength / $key;

		$counter = 0;
		for( $i = 0; $i < strlen($cleanText); $i++ )
		{
			if( ($counter % $key) == 0)
			{
				if( (ord($cleanText{$i}) >= 97) && (ord($cleanText{$i}) <= 122) )
				{
					$encryptedText .= encodeMatch($vKey{$counter++}, $cleanText{$i});
					$counter++;
				}
				else
				{
					$encryptedText .= $cleanText{$i};
				}
			}
		}
		return $encryptedText;
	}
	// Take a chunk of mysterious code and decode it.
	function decode($encryptedText, $key)
	{
		$decodedText = "";
		$cleanText = clean($encryptedText);

		$counter = 0;
		for( $i = 0; $i < strlen($encryptedText); $i++ )
		{
			if( (ord($encryptedText{$i}) >= 97) && (ord($encryptedText{$i}) <= 122) )
			{
				$decodedText .= decodeMatch($vKey{$counter++}, $encryptedText{$i});
			}
			else
			{
				$decodedText .= $encryptedText{$i};
			}
		}

		return $decodedText;
	}
	// Cleans plaintext specific to the railfence cipher
	// Only letters count, upper is changed to lower.
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
	// Gets length of string where only letters count.
	function getTextLength($cleanText)
	{
		$counter = 0;
		for( $i = 0; $i < strlen($cleanText); $i += $key )
		{
			if( (ord($cleanText{$i}) >= 97) && (ord($cleanText{$i}) <= 122) )
			{
				$counter++;
			}
		}
		return $counter;
	}
	// Adds extraneous characters to the text to make the cipher of
	// a modable number with the key.
	function padText($cleanText, $key, $length)
	{
		$paddedText = "";
		if( (strlen($length) % $key) == 0 )
		{
			return $cleanText;
		}
		else
		{
			$paddedText .= $cleanText;
			for( $i = 0; $i < $key; $i++ )
			{
				$paddedText .= "j";
			}
			return $paddedText;
		}
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
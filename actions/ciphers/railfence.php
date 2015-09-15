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

		for( $i = 0; $i < $key; $i++)
		{
			$counter = 0;
			for( $j = $i; $j < strlen($cleanText); $j++ )
			{
				if( (ord($cleanText{$j}) >= 97) && (ord($cleanText{$j}) <= 122) )
				{
					$counter++;
					if($counter == $key)
					{
						$encryptedText .= $paddedText{$j};
						$counter = 0;
					}
				}
				else
				{
					$encryptedText .= $paddedText{$j};
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

		for( $i = 0; $i < $key; $i++)
		{
			$counter = 0;
			for( $j = $i; $j < strlen($cleanText); $j++ )
			{
				if( (ord($cleanText{$j}) >= 97) && (ord($cleanText{$j}) <= 122) )
				{
					$counter++;
					if($counter == $key)
					{
						$decodedText .= $paddedText{$j};
						$counter = 0;
					}
				}
				else
				{
					$decodedText .= $paddedText{$j};
				}
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
?>
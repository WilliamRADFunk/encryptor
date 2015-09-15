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
		return (rand(3, 5));
	}
	// Take a perfectly good string and encodes it.
	function encode($plaintext, $key)
	{
		$encryptedText = "";
		$cleanText = clean($plaintext);
		$paddedText = padText($cleanText, $key);

		$counter = 0;

		for( $i = 0; $i < $key; $i++)
		{
			$encryptedText .= $paddedText{$i};
			for( $j = $i + 1; $j < strlen($paddedText); $j++ )
			{
				$counter++;
				if( ($counter % $key) == 0 )
				{
					$encryptedText .= $paddedText{$j};
					$counter = 0;
				}
			}
			$counter = 0;
		}
		return $encryptedText;
	}
	// Take a chunk of mysterious code and decode it.
	function decode($encryptedText, $key)
	{
		$decodedText = "";

		$counter = 0;

		for( $i = 0; $i < $key; $i++)
		{
			for( $j = $i + 1; $j < strlen($encryptedText); $j++ )
			{
				$counter++;
				if( ($counter % $key) == 0 )
				{
					$decodedText .= $encryptedText{$j};
					$counter = 0;
				}
			}
			$counter = 0;
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
			else if( (ord($plaintext{$i}) >= 97) && (ord($plaintext{$i}) <= 122) )
			{
				$cleanText .= $plaintext{$i};
			}
		}
		
		return $cleanText;
	}
	// Adds extraneous characters to the text to make the cipher of
	// a modable number with the key.
	function padText($cleanText, $key)
	{
		$paddedText = "";
		if( (strlen($cleanText) % $key) == 0 )
		{
			return $cleanText;
		}
		else
		{
			$paddedText = $cleanText;
			$textLength = strlen($cleanText);
			for( $i = $textLength; $i < ( $textLength + ($textLength % $key) ); $i++ )
			{
				$paddedText .= "j";
			}
			return $paddedText;
		}
	}
?>
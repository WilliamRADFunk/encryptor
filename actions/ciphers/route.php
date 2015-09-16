<?php 
	session_start();
	// Function called from the controller to encrypt a string.
	function routeEncrypt($plaintext)
	{
		$_SESSION["key"] = generateKey();
		return encode($plaintext, $_SESSION["key"]);
	}
	// Function called from the controller to decode a string.
	function routeDecode($encryptedText)
	{
		return decode($encryptedText, $_SESSION["key"]);
	}
	// Randomly generates a key unique to the Route Cipher.
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
		$cipherTable = tableMaker($paddedText, $key);

		
		return $encryptedText;
	}
	// Take a chunk of mysterious code and decode it.
	function decode($encryptedText, $key)
	{
		$decodedText = "";
		$cipherTable = tableMaker($encryptedText, $key);

		
		return $decodedText;
	}
	// Cleans plaintext specific to the route cipher
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

			for( $i = 1; $i < ($textLength / $key); $i++)
			{
				for( $j = $i; $j < $textLength; $j += $key )
				{
					if( $j == ($textLength - 1) )
					{
						continue;
					}
					else if( ($j + $key) >= $textLength )
					{
						$paddedText = substr( $paddedText, 0, $j ) . "j" . substr( $paddedText, $j+1, strlen($cleanText) - 1 );
						break;
					}
				}
			}

			return $paddedText;
		}
	}
	// Constructs the route table to make decoding possible.
	function tableMaker($encryptedText, $key)
	{
		$cipherTable = array();
		$counter = 0;

		for( $i = 0; $i < $key; $i++)
		{
			$column = array();
			for( $j = 0; $j < ( strlen($encryptedText) / $key ); $j++)
			{
				array_push($column, $encryptedText{$counter});
				$counter++;
			}
			array_push($cipherTable, $column);
		}
		return $cipherTable;
	}
?>
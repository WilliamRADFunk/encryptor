<?php
	session_start();
	function caesarEncrypt($plaintext)
	{
		$_SESSION["key"] = generateKey();
		return encode($plaintext, $_SESSION["key"]);
	}

	function caesarDecode($encryptedText, $key)
	{
		return decode($encryptedText, $key);
	}

	function generateKey()
	{
		return ( rand(1, 25) );
	}

	function letterToNum($char)
	{
		return ( ord($char) % 97 );
	}

	function NumToLetter($NumValue)
	{
		return ( chr($NumValue + 97) );
	}

	function shift($char, $key)
	{
		// Convert upper to lower.
		if(ord($char) >= 65 && ord($char) <= 90)
		{
			$temp = strtolower($char);
			$char = $temp;
		}
		$code = letterToNum($char);
		$shifted = ($code + $key);

		// If it isn't a letter.
		if(ord($char) >= 97 && ord($char) <= 122)
		{
			if($key < 0)
			{
				if( $shifted < 0)
				{
					$coded = 26 + $shifted;
					$newCh = NumToLetter($coded);
				}
				else
				{
					$coded = $shifted;
					$newCh = NumToLetter($coded);
				}
				return $newCh;
			}
			// Shift wraps back around passed 'z'
			else if( $shifted > 25)
			{
				$coded = $shifted % 26;
				$newCh = NumToLetter($coded);
			}
			else
			{
				$coded = $shifted;
				$newCh = NumToLetter($coded);
			}
			return $newCh;
		}
		else
		{
			return $char;
		}
	}
	// Take a perfectly good string and encodes it.
	function encode($plaintext, $key)
	{
		$newString = "";
		for($i = 0; $i < strlen($plaintext); $i++)
		{
			$newString .= shift($plaintext{$i}, $key);
		}
		return $newString;
	}
	// Take a chunk of mysterious code and decode it.
	function decode($encryptedText, $key)
	{
		$newString = "";
		for($i = 0; $i < strlen($encryptedText); $i++)
		{
			$newString .= shift( $encryptedText{$i}, (-$key) );
		}
		return $newString;
	}
?>
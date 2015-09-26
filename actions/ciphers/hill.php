<?php 
	session_start();
	// Function called from the controller to encrypt a string.
	function hillEncrypt($plaintext)
	{
		$sizeOfKey = rand(2, 9);
		$_SESSION["key"] = generateKey($sizeOfKey);
		return encode($plaintext, $_SESSION["key"], $sizeOfKey);
	}
	// Function called from the controller to decode a string.
	function hillDecode($encryptedText)
	{
		$key = invertMatrix($_SESSION["key"]);
		return decode($encryptedText, $_SESSION["key"]);
	}
	// Randomly generates a key unique to the Hill Cipher.
	function generateKey($sizeOfKey)
	{
		$key = $sizeOfKey . "";
		for($i = 0; $i < ($sizeOfKey * $sizeOfKey); $i++)
		{
			$keyNum = (rand(0, 25) - rand(0, 25));
			$key .= ("," . $keyNum);
		}
		return $key;
	}
	function invertMatrix($key)
	{
		$invertedMatrix = array();
		switch($key{0})
		{
			case 2:
			{
				$determinant = twoBytwo($key);
				break;
			}
			case 3:
			{
				$determinant = threeBythree($key);
				break;
			}
			case 4:
			{
				$determinant = fourByfour($key);
				break;
			}
			default:
			{
				echo "</br>ERROR: Improper key size entered.</br>";
			}
		}
	}
	// Take a perfectly good string and encodes it.
	function encode($plaintext, $key, $sizeOfKey)
	{
		$encryptedText = "";
		$cleanText = clean($plaintext);
		$paddedText = padText($cleanText, $key, $sizeOfKey);
		$paddedTextArray = explode(",", $paddedText);
		$keyArray = explode(",", $key);
		array_splice($keyArray, 0, 1);

	    // Moves through text one block at a time, converts it to the 0-25 value system,
	    // multiples key row against block as a column, mods by 26, then adds 97 to convert
	    // back to ascii letter.
	    for($x = 0; $x < count($paddedTextArray); $x += $sizeOfKey)
	    {
	        $plainBlock = array();

	        // Collects a block and converts to the 0-25 value.
	        for($y = 0; $y < $sizeOfKey; $y++)
	        {
	            array_push( $plainBlock, $paddedTextArray[$x + $y] );
	        }

	        // Traverses the whole key, one row after the next.
	        for($p = 0; $p < ($sizeOfKey * $sizeOfKey); $p += $sizeOfKey)
	        {
	            $letterTotal = 0;
	            // Collects the sum of products of a key row and plaintext block column.
	            for($z = 0; $z < $sizeOfKey; $z++)
	            {
	                $letterTotal += $keyArray[$p + $z] * $plainBlock[$z];
	            }
	            // Converts 0-25 value of encrypted letter back into ascii equivalent.
	            if($letterTotal >= 0)
	            {
	                $encryptedText .= NumToLetter($letterTotal % 26);
	            }
	            else
	            {
	                $result = $letterTotal;
	                while($result < 0)
	                {
	                    $result += 26;
	                }
	                $encryptedText .= NumToLetter($result);
	            }
	        }
	    }
		return $encryptedText;
	}
	// Take a chunk of mysterious code and decode it.
	function decode($encryptedText, $key)
	{
		$decodedText = "";
		$cipherTable = tableMaker($encryptedText, $key);

		
		return $decodedText;
	}
	// Cleans plaintext specific to the hill cipher
	// Only letters count, upper is changed to lower.
	function clean($plaintext)
	{
		$strippedText = "";
		$cleanText = "";

		for( $i = 0; $i < strlen($plaintext); $i++ )
		{
			if( (ord($plaintext{$i}) >= 65) && (ord($plaintext{$i}) <= 90) )
			{
				$strippedText .= strtolower($plaintext{$i});
			}
			else if( (ord($plaintext{$i}) >= 97) && (ord($plaintext{$i}) <= 122) )
			{
				$strippedText .= $plaintext{$i};
			}
		}
		$cleanText .= letterToNum($strippedText{0});
		for( $j = 1; $j < strlen($strippedText); $j++ )
		{
			$cleanText .= "," . letterToNum($strippedText{$j});
		}
		
		return $cleanText;
	}
	// Adds extraneous characters to the text to make the cipher of
	// a modable number with the key.
	function padText($cleanText, $key, $sizeOfKey)
	{
		$cleanTextLength = count(explode(",", $cleanText));
		if( ($cleanTextLength % $sizeOfKey) == 0 )
		{
			return $cleanText;
		}
		else
		{
			$paddedText = $cleanText;
			$padLength = $sizeOfKey - ($cleanTextLength % $sizeOfKey);
			for( $i = $cleanTextLength; $i <= $cleanTextLength + $padLength - 1; $i++)
			{
				$paddedText .= "," . (rand(0, 25));
			}
			return $paddedText;
		}
	}
	// Converts a single character into the 0 to 25 integer value.
	function letterToNum($char)
	{
		return ( ord($char) % 97 );
	}
	// Converts the 0 to 25 integer value into a single character.
	function NumToLetter($NumValue)
	{
		return ( chr($NumValue + 97) );
	}
?>
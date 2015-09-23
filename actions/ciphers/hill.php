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
		echo $key, "</br>";
		return $key;
	}
	// Take a perfectly good string and encodes it.
	function encode($plaintext, $key, $sizeOfKey)
	{
		$encryptedText = "";
		echo $plaintext, "</br>";

		$cleanText = clean($plaintext);
		echo "cleanText: </br>", $cleanText, "</br>";

		$paddedText = padText($cleanText, $key, $sizeOfKey);
		echo "paddedText: </br>", $paddedText, "</br>";

		$paddedTextMatrix = explode(",", $paddedText);
		echo "paddedTextMatrix: </br>", implode(" ", $paddedTextMatrix), "</br>";

		echo "key: </br>", $key, "</br>";
		$keyMatrix = explode(",", $key);
		echo "keyMatrix: </br>", implode(" ", $keyMatrix), "</br></br>";
		array_splice($keyMatrix, 0, 1);
		echo "keyMatrix: </br>", implode(" ", $keyMatrix), "</br></br>";

		for( $i = 0; $i < count($paddedTextMatrix); $i += $sizeOfKey )
		{
			$cipherBlock = encodeBlock( $paddedTextMatrix, $keyMatrix, $sizeOfKey, $i );
			$encryptedText .= $cipherBlock;
		}
		echo "encryptedText: </br>", $encryptedText, "</br>";
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
			echo $strippedText{$j}, " ", letterToNum($strippedText{$j}), "</br>";
			$cleanText .= "," . letterToNum($strippedText{$j});
		}
		
		return $cleanText;
	}
	// Adds extraneous characters to the text to make the cipher of
	// a modable number with the key.
	function padText($cleanText, $key, $sizeOfKey)
	{
		$cleanTextLength = count(explode(",", $cleanText));
		echo "cleanText length: ", $cleanTextLength, "</br>";
		$paddedText = "";
		if( ($cleanTextLength % $sizeOfKey) == 0 )
		{
			return $cleanText;
		}
		else
		{
			$paddedText = $cleanText;
			$padLength = $sizeOfKey - ($cleanTextLength % $sizeOfKey);
			echo "padLength: ", $padLength, "</br>";

			for( $i = $cleanTextLength; $i <= $cleanTextLength + $padLength; $i++)
			{
				$paddedText .= "," . (rand(0, 25));
			}

			return $paddedText;
		}
	}
	// Constructs the hill table to make decoding possible.
	function encodeBlock($paddedTextMatrix, $keyMatrix, $sizeOfKey, $startIndex)
	{
		$toBeEncodedBlock = array();
		$blockOfEncodedText = "";
		for($i = $startIndex; ($i < $startIndex + $sizeOfKey) && ($i <= count($paddedTextMatrix)); $i++)
		{
			echo $i, " = ", $paddedTextMatrix{$i}, "</br>";
			array_push($toBeEncodedBlock, $paddedTextMatrix[$i]);
		}
		echo "------------------</br>";
		for($j = 0; $j < count($keyMatrix); )
		{
			$total = 0;
			for($k = 0; $k < $sizeOfKey; $j++, $k++)
			{
				$total += $toBeEncodedBlock{$j} * $keyMatrix{$k};
			}
			$temp = $total % 26;
			$temp = ($temp < 0) ? ($temp+26) : $temp;
			$blockOfEncodedText .= NumToLetter($temp);
		}
		echo "------------------</br>";
		echo "------------------</br>";

		return $blockOfEncodedText;
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
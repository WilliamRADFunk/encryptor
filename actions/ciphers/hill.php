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
		echo $key, "</br>";
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
		echo $plaintext, "</br>";
		$cleanText = clean($plaintext);
		echo "cleanText: &nbsp&nbsp&nbsp", $cleanText, "</br>";
		$paddedText = padText($cleanText, $key, $sizeOfKey);
		$paddedTextArray = explode(",", $paddedText);
		echo "paddedTextArray: ", implode(" ", $paddedTextArray), "</br>";
		$keyArray = explode(",", $key);
		array_splice($keyArray, 0, 1);
		echo "keyArray: </br>", implode(" ", $keyArray), "</br></br>";

		$keyMatrix = array();
		for($i = 0; $i < count($keyArray); $i += $j)
		{
			$row = array();
			for($j = 0; $j < $sizeOfKey; $j++)
			{
				array_push($row, $keyArray[$i + $j]);
			}
			array_push($keyMatrix, $row);
		}

		echo "</br></br>";
		for($i = 0; $i < count($keyMatrix[0]); $i++)
		{
			foreach($keyMatrix[$i][0] as $child)
			{
				echo $child . " ";
			}
			echo "</br>";
		}
		echo "</br></br>";

		for( $k = 0; $k < count($paddedTextArray); $k += $sizeOfKey )
		{
			$cipherBlock = encodeBlock( $paddedTextArray, $keyMatrix, $sizeOfKey, $k );
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
		if( ($cleanTextLength % $sizeOfKey) == 0 )
		{
			echo "padLength: 0</br>";
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
			echo "paddedText: ", $paddedText, "</br>";
			return $paddedText;
		}
	}
	// Constructs the hill table to make decoding possible.
	function encodeBlock($paddedTextArray, $keyMatrix, $sizeOfKey, $startIndex)
	{
		$toBeEncodedBlock = array();
		$blockOfEncodedText = "";
		for($i = $startIndex; ($i < $startIndex + $sizeOfKey) && ($i <= count($paddedTextArray)); $i++)
		{
			echo $i, " = ", $paddedTextArray{$i}, "</br>";
			array_push($toBeEncodedBlock, $paddedTextArray[$i]);
		}
		echo "------------------</br>";
		for($j = 0; $j < $sizeOfKey; $j++)
		{
			$total = 0;
			for($k = 0; $k < $sizeOfKey; $k++)
			{
				echo "total = ", $total, " + ";
				$total += $toBeEncodedBlock[$k] * $keyMatrix[$j][$k];
				echo "(", $toBeEncodedBlock[$k], "*", $keyMatrix[$j][$k], ") = ", $total, "</br>";
			}
			if($total >= 0)
			{
				$temp = $total % 26;
				$blockOfEncodedText .= NumToLetter($temp);
				echo "+temp: ", $temp, " ***blockOfEncodedText = ", $blockOfEncodedText, "</br>";
			}
			else
			{
				$temp2 = $total;
				while($temp2 < 0)
				{
					$temp2 += 26;
				}
				$blockOfEncodedText .= NumToLetter($temp2);
				echo "-temp2: ", $temp2, " ***blockOfEncodedText = ", $blockOfEncodedText, "</br>";

			}			
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
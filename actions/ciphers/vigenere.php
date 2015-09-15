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
		$table = tableMaker();
		$vKeyLength = getTextLength($cleanText);
		$vKey = getVKey( $key, $vKeyLength );

		$counter = 0;
		for( $i = 0; $i < strlen($cleanText) && $counter < $vKeyLength; $i++ )
		{
			$match = match($vKey{$counter++}, $cleanText{$i}, $table);
			$encryptedText .= $match;
		}
		return $encryptedText;
	}
	// Take a chunk of mysterious code and decode it.
	function decode($encryptedText, $key)
	{
		$decodedText = "";
		$table = tableMaker();
		$vKeyLength = getTextLength($encryptedText);
		$vKey = getVKey( $key, $vKeyLength );

		$counter = 0;
		for( $i = 0; $i < strlen($encryptedText) && $counter < $vKeyLength; $i++ )
		{
			$match = match($vKey{$counter++}, $encryptedText{$i}, $table);
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
			if( (ord($plaintext{$i}) >= 65) && (ord($plaintext{$i}) <= 90) )
			{
				$plaintext = substr_replace($plaintext, strtolower($plaintext{$i}), $plaintext{$i}, 1);
			}

			$cleanText .= $plaintext{$i};
		}
		
		return $cleanText;
	}
	// Uses alphabet to construct the 26 x 26 letter vigenere table.
	function tableMaker()
	{
		$table =[ ["a","b","c","d","e","f","g","h","i","j","k","l","m",
				 "n","o","p","q","r","s","t","u","v","w","x","y","z"],
				["b","c","d","e","f","g","h","i","j","k","l","m","n",
				 "o","p","q","r","s","t","u","v","w","x","y","z","a"],
				["c","d","e","f","g","h","i","j","k","l","m","n","o",
				 "p","q","r","s","t","u","v","w","x","y","z","a","b"],
				["d","e","f","g","h","i","j","k","l","m","n","o","p",
				 "q","r","s","t","u","v","w","x","y","z","a","b","c"],
				["e","f","g","h","i","j","k","l","m","n","o","p","q",
				 "r","s","t","u","v","w","x","y","z","a","b","c","d"],
				["f","g","h","i","j","k","l","m","n","o","p","q","r",
				 "s","t","u","v","w","x","y","z","a","b","c","d","e"],
				["g","h","i","j","k","l","m","n","o","p","q","r","s",
				 "t","u","v","w","x","y","z","a","b","c","d","e","f"],
				["h","i","j","k","l","m","n","o","p","q","r","s","t",
				 "u","v","w","x","y","z","a","b","c","d","e","f","g"],
				["i","j","k","l","m","n","o","p","q","r","s","t","u",
				 "v","w","x","y","z","a","b","c","d","e","f","g","h"],
				["j","k","l","m","n","o","p","q","r","s","t","u","v",
				 "w","x","y","z","a","b","c","d","e","f","g","h","i"],
				["k","l","m","n","o","p","q","r","s","t","u","v","w",
				 "x","y","z","a","b","c","d","e","f","g","h","i","j"],
				["l","m","n","o","p","q","r","s","t","u","v","w","x",
				 "y","z","a","b","c","d","e","f","g","h","i","j","k"],
				["m","n","o","p","q","r","s","t","u","v","w","x","y",
				 "z","a","b","c","d","e","f","g","h","i","j","k","l"],
				["n","o","p","q","r","s","t","u","v","w","x","y","z",
				 "a","b","c","d","e","f","g","h","i","j","k","l","m"],
				["o","p","q","r","s","t","u","v","w","x","y","z","a",
				 "b","c","d","e","f","g","h","i","j","k","l","m","n"],
				["p","q","r","s","t","u","v","w","x","y","z","a","b",
				 "c","d","e","f","g","h","i","j","k","l","m","n","o"],
				["q","r","s","t","u","v","w","x","y","z","a","b","c",
				 "d","e","f","g","h","i","j","k","l","m","n","o","p"],
				["r","s","t","u","v","w","x","y","z","a","b","c","d",
				 "e","f","g","h","i","j","k","l","m","n","o","p","q"],
				["s","t","u","v","w","x","y","z","a","b","c","d","e",
				 "f","g","h","i","j","k","l","m","n","o","p","q","r"],
				["t","u","v","w","x","y","z","a","b","c","d","e","f",
				 "g","h","i","j","k","l","m","n","o","p","q","r","s"],
				["u","v","w","x","y","z","a","b","c","d","e","f","g",
				 "h","i","j","k","l","m","n","o","p","q","r","s","t"],
				["v","w","x","y","z","a","b","c","d","e","f","g","h",
				 "i","j","k","l","m","n","o","p","q","r","s","t","u"],
				["w","x","y","z","a","b","c","d","e","f","g","h","i",
				 "j","k","l","m","n","o","p","q","r","s","t","u","v"],
				["x","y","z","a","b","c","d","e","f","g","h","i","j",
				 "k","l","m","n","o","p","q","r","s","t","u","v","w"],
				["y","z","a","b","c","d","e","f","g","h","i","j","k",
				 "l","m","n","o","p","q","r","s","t","u","v","w","x"],
				["z","a","b","c","d","e","f","g","h","i","j","k","l",
				 "m","n","o","p","q","r","s","t","u","v","w","x","y"] ];
		return $table;
	}
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
	function getVKey( $key, $length )
	{
		$vKey = "";
		for( $i = 0; $i < strlen($length); $i += strlen($key) )
		{
			if( $i >= strlen($length) )
			{
				break;
			}
			for( $j = 0; $j < strlen($key); $j++ )
			{
				$vKey .= $key{$j};
			}
		}
		echo "<br>vKey-length: ", $length, "--- key: ", $key, "<br><br>";
		return $vKey;
	}
	function match($keyChar, $textChar, $table)
	{
		if( (ord($textChar) >= 97) && (ord($textChar) <= 122) )
		{
			$index1 = (ord($textChar) % 97);
			$index2 = (ord($keyChar) % 97);
			echo $index1, "---", $index2, "---'", $keyChar, "'---", $table[$index1][$index2], "<br>";
			return $table[$index1][$index2];
		}
		else
		{
			return $textChar;
		}
	}
?>
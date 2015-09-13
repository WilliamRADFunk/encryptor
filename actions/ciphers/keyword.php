<?php 
	session_start();
	// Function called from the controller to encrypt a string.
	function keywordEncrypt($plaintext)
	{
		$_SESSION["key"] = generateKey();
		return encode($plaintext, $key);
	}
	// Function called from the controller to decode a string.
	function keywordDecode($encryptedText)
	{
		return decode($encryptedText, $key);
	}
	// Randomly generates a key unique to the Keyword Cipher.
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

		return $key;
	}
	// Take a perfectly good string and encodes it.
	function encode($plaintext, $key)
	{
		$encryptedText = "";

		$cleanText = clean($plaintext);

		return $encryptedText;
	}
	// Take a chunk of mysterious code and decode it.
	function decode($encryptedText, $key)
	{
		$decodedText = "";

		return $decodedText;
	}
	// Cleans plaintext specific to the keyword cipher
	function clean($plaintext)
	{
		$cleanText = "";

		return $cleanText;
	}
	// Takes a string, and breaks it into pairs.
	// It uses white space as an EOF signal.
	function textPairing($text, $index)
	{
		$pair = "";
		$pair .= $text{$index};
		$pair .= $text{$index + 1};

		return $pair;
	}
	// Matches the input pair against a pair from the opposing tables.
	function match($pair, $upperLeft, $upperRight, $lowerLeft, $lowerRight)
	{
		$pairMatch = "";

		if($pair{0} == "j")
		{
			$pair = substr_replace($pair, "i", 0, 1);
		}
		if($pair{1} == "j")
		{
			$pair = substr_replace($pair, "i", 1, 1);
		}

		$row1 = ( (int)(strpos($upperLeft, $pair{0}) / 5) );
		$col1 = ( (int)(strpos($lowerRight, $pair{1}) % 5) );
		$pos = ( ($row1 * 5) + $col1 );
		$pairMatch .= $upperRight{$pos};

		$row2 = ( (int)(strpos($lowerRight, $pair{1}) / 5) );
		$col2 = ( (int)(strpos($upperLeft, $pair{0}) % 5) );
		$pos = ( ($row2 * 5) + $col2 );
		$pairMatch .= $lowerLeft{$pos};

		return $pairMatch;
	}
?>
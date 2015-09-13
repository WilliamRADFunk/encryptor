<?php 
	session_start();
	// Function called from the controller to encrypt a string.
	function foursquareEncrypt($plaintext)
	{
		$key1 = generateKey();
		$key2 = generateKey();
		$upperLeft = "abcdefghiklmnopqrstuvwxyz";
		$upperRight = $key1;
		$lowerLeft = $key2;
		$lowerRight = "abcdefghiklmnopqrstuvwxyz";

		$_SESSION["key"] = $key1 . " " . $key2;

		return encode($plaintext, $upperLeft, $upperRight, $lowerLeft, $lowerRight);
	}
	// Function called from the controller to decode a string.
	function foursquareDecode($encryptedText)
	{
		$upperLeft = substr($_SESSION["key"], 0, 25);
		$upperRight = "abcdefghiklmnopqrstuvwxyz";
		$lowerLeft = "abcdefghiklmnopqrstuvwxyz";
		$lowerRight = substr($_SESSION["key"], 26);

		return decode($encryptedText, $upperLeft, $upperRight, $lowerLeft, $lowerRight);
	}
	// Randomly generates a key unique to the Foursquare Cipher.
	function generateKey()
	{
		$alphabetTemplate = "abcdefghiklmnopqrstuvwxyz";
		$key = "";
	
		while(strlen($alphabetTemplate) > 0)
		{
			$alphabetTemplateLength = strlen($alphabetTemplate);
			$randomLetterIndex = rand( 0, $alphabetTemplateLength - 1 );
			$key .= $alphabetTemplate{$randomLetterIndex};
			$truncatedString = substr_replace($alphabetTemplate, "", $randomLetterIndex, 1);
			$alphabetTemplate = $truncatedString;
		}
		return $key;
	}
	// Take a perfectly good string and encodes it.
	function encode($plaintext, $upperLeft, $upperRight, $lowerLeft, $lowerRight)
	{
		$encryptedText = "";

		$cleanText = clean($plaintext);

		if( (strlen($cleanText) % 2) != 0 )
		{
			$cleanText .= "x";
		}
		
		for( $i = 0; $i < strlen($cleanText) - 1; $i += 2)
		{
			$pair = textPairing($cleanText, $i);
			$encryptedText .= match($pair, $upperLeft, $upperRight, $lowerLeft, $lowerRight);
		}

		return $encryptedText;
	}
	// Take a chunk of mysterious code and decode it.
	function decode($encryptedText, $upperLeft, $upperRight, $lowerLeft, $lowerRight)
	{
		$decodedText = "";

		for( $i = 0; $i < strlen($encryptedText) - 1; $i += 2)
		{
			$pair = textPairing($encryptedText, $i);
			$decodedText .= match($pair, $upperLeft, $upperRight, $lowerLeft, $lowerRight);
		}

		return $decodedText;
	}
	// Removes all non-letter characters from the text,
	// and returns all lowercase.
	function clean($plaintext)
	{
		$cleanText = "";
		for( $i = 0; $i < strlen($plaintext); $i++ )
		{
			if( (ord($plaintext{$i}) >= 97) && (ord($plaintext{$i}) <= 122) )
			{
				$cleanText .= $plaintext{$i};
			}
			else if( (ord($plaintext{$i}) >= 65) && (ord($plaintext{$i}) <= 90) )
			{
				$cleanText .= strtolower($plaintext{$i});
			}
		}

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
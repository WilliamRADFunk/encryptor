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
		$upperLeft = "abcdefghiklmnopqrstuvwxyz";
		$upperRight = substr($_SESSION["key"], 0, 24);
		$lowerLeft = substr($_SESSION["key"], 26, 49);
		$lowerRight = "abcdefghiklmnopqrstuvwxyz";

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

		if( (strlen($plaintext) % 2) != 0 )
		{
			$plaintext .= "x";
		}
		
		for( $i = 0; $i < strlen($plaintext); $i++ )
		{
			$pair = textPairing($plaintext, $i);
			$encryptedText .= match($pair, $upperLeft, $upperRight, $lowerRight);
		}

		return $encryptedText;
	}
	// Take a chunk of mysterious code and decode it.
	function decode($encryptedText, $upperLeft, $upperRight, $lowerLeft, $lowerRight)
	{
		$decodedText = "";

		for( $i = 0; $i < strlen($encryptedText); $i++ )
		{
			$pair = textPairing($encryptedText, $i);
			$decodedText .= match($pair{$i}, $upperLeft, $upperRight, $lowerRight);
		}

		return $decodedText;
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

		$row1 = ( strpos($upperLeft, $pair{0}) / 5 );
		$col1 = ( strpos($lowerRight, $pair{1}) % 5 );
		$pairMatch .= ( strpos($upperRight, (($row * 5) + $col) );

		$row2 = ( strpos($lowerRight, $pair{1}) / 5 );
		$col2 = ( strpos($upperLeft, $pair{0}) % 5 );
		$pairMatch .= ( strpos($lowerLeft, (($row * 5) + $col) );
			
		return $pairMatch;
	}
?>
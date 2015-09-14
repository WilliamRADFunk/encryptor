<?php 
	session_start();
	// Function called from the controller to encrypt a string.
	function playfairEncrypt($plaintext)
	{
		$_SESSION["key"] = generateKey();
		return encode($plaintext, $_SESSION["key"]);
	}
	// Function called from the controller to decode a string.
	function playfairDecode($encryptedText)
	{
		return decode($encryptedText, $_SESSION["key"]);
	}
	// Randomly generates a key unique to the Playfair Cipher.
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
		$alphabetTemplate = "abcdefghiklmnopqrstuvwxyz";
		$cleanText = clean($plaintext);
		$cipherTable = tableMaker($key);

		for( $i = 0; $i < strlen($cleanText) - 1; $i += 2 )
		{
			$pair = textPairing($cleanText, $i);
			$match = encodeMatch($pair, $cipherTable);
			$encryptedText .= $match;
		}
		return $encryptedText;
	}
	// Take a chunk of mysterious code and decode it.
	function decode($encryptedText, $key)
	{
		$decodedText = "";
		$alphabetTemplate = "abcdefghiklmnopqrstuvwxyz";
		$cipherTable = tableMaker($key);

		for( $i = 0; $i < strlen($encryptedText) - 1; $i += 2 )
		{
			$pair = textPairing($encryptedText, $i);
			$match = decodeMatch($pair, $cipherTable);
			$decodedText .= $match;
		}

		return $decodedText;
	}
	// Cleans plaintext specific to the playfair cipher
	// Only letters count, upper is changed to lower, and
	// an odd length string is padded with an extra "x."
	function clean($plaintext)
	{
		$cleanText = "";

		for( $i = 0; $i < strlen($plaintext); $i++ )
		{
			if( (ord($plaintext{$i}) == 74) || (ord($plaintext{$i}) == 106) )
			{
				$cleanText .= "i";
				continue;
			}
			
			if( (ord($plaintext{$i}) >= 65) && (ord($plaintext{$i}) <= 90) )
			{
				$plaintext = substr_replace($plaintext, strtolower($plaintext{$i}), $plaintext{$i}, 1);
			}

			if( (ord($plaintext{$i}) >= 97) && (ord($plaintext{$i}) <= 122) )
			{
				$cleanText .= $plaintext{$i};
			}
		}

		if( (strlen($cleanText) % 2) != 0 )
		{
			$cleanText .= "x";
		}
		
		return $cleanText;
	}
	// Uses keyword to construct the 5 x 5 letter cipher string.
	function tableMaker($key)
	{
		$alphabetTemplate = "abcdefghiklmnopqrstuvwxyz";
		$cleanKey = stripRepeats($key);
		$cipherTable = $cleanKey;

		for( $i = 0; $i < strlen($alphabetTemplate); $i++ )
		{
			if( strpos($cipherTable, $alphabetTemplate{$i}) === false )
			{
				$cipherTable .= $alphabetTemplate{$i};
			}
		}
		return trim($cipherTable);
	}
	// Removes repeated letters from a string.
	function stripRepeats($key)
	{
		$newKey = "";
		for( $i = 0; $i < strlen($key); $i++ )
		{
			if($key{$i} == "j")
			{
				$key = substr_replace($key, "i", $key{$i}, 1);
			}
			if( strpos($newKey, $key{$i}) === false )
			{
				$newKey .= $key{$i};
			}
		}
		return trim($newKey);
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
	function encodeMatch($pair, $cipherTable)
	{
		$pairMatch = "";


		$row1 = ( (int)(strpos($cipherTable, $pair{0}) / 5) );
		$col1 = ( (int)(strpos($cipherTable, $pair{0}) % 5) );

		$row2 = ( (int)(strpos($cipherTable, $pair{1}) / 5) );
		$col2 = ( (int)(strpos($cipherTable, $pair{1}) % 5) );

		if( $pair{0} == $pair{1} )
		{
			if( $pos1 == 24 )
			{
				$pairMatch .= $cipherTable{ 0 };
				$pairMatch .= $cipherTable{ 0 };
			}
			else if ( $row1 == 4 )
			{
				$pairMatch .= $cipherTable{ $col1 + 1 };
				$pairMatch .= $cipherTable{ $col1 + 1 };
			}
			else if ( $col1 == 4 )
			{
				$pairMatch .= $cipherTable{ (($row1 + 1) * 5) };
				$pairMatch .= $cipherTable{ (($row1 + 1) * 5) };
			}
			else
			{
				$pairMatch .= $cipherTable{ (($row1 + 1) * 5) + $col1 + 1 };
				$pairMatch .= $cipherTable{ (($row1 + 1) * 5) + $col1 + 1 };
			}
		}
		else if($row1 == $row2)
		{
			$pos1 = ( ($row1 * 5) + $col1 );
			$pos2 = ( ($row2 * 5) + $col2 );
			if($col1 < 4)
			{
				$pairMatch .= $cipherTable{ $pos1 + 1 };
			}
			else
			{
				$pairMatch .= $cipherTable{ ($row1 * 5) };
			}

			if($col2 < 4)
			{
				$pairMatch .= $cipherTable{ $pos2 + 1 };
			}
			else
			{
				$pairMatch .= $cipherTable{ ($row2 * 5) };
			}
		}
		else if($col1 == $col2)
		{
			$pos1 = ( ($row1 * 5) + $col1 );
			$pos2 = ( ($row2 * 5) + $col2 );
			if($row1 < 4)
			{
				$pairMatch .= $cipherTable{ $pos1 + 5 };
			}
			else
			{
				$pairMatch .= $cipherTable{$col1};
			}

			if($row2 < 4)
			{
				$pairMatch .= $cipherTable{ $pos2 + 5 };
			}
			else
			{
				$pairMatch .= $cipherTable{$col2};
			}
		}
		else
		{
			$pos1 = ( ($row1 * 5) + $col2 );
			$pos2 = ( ($row2 * 5) + $col1 );
			$pairMatch .= $cipherTable{$pos1};
			$pairMatch .= $cipherTable{$pos2};
		}

		return $pairMatch;
	}
	// Matches the input pair against a pair from the opposing tables.
	function decodeMatch($pair, $cipherTable)
	{
		$pairMatch = "";


		$row1 = ( (int)(strpos($cipherTable, $pair{0}) / 5) );
		$col1 = ( (int)(strpos($cipherTable, $pair{0}) % 5) );

		$row2 = ( (int)(strpos($cipherTable, $pair{1}) / 5) );
		$col2 = ( (int)(strpos($cipherTable, $pair{1}) % 5) );

		$pos1 = ( ($row1 * 5) + $col1 );
		$pos2 = ( ($row2 * 5) + $col2 );

		if( $pair{0} == $pair{1} )
		{
			if( $pos1 == 0 )
			{
				$pairMatch .= $cipherTable{ 24 };
				$pairMatch .= $cipherTable{ 24 };
			}
			else if ( $row1 == 0 )
			{
				$pairMatch .= $cipherTable{ 20 + $col1 - 1 };
				$pairMatch .= $cipherTable{ 20 + $col1 - 1 };
			}
			else if ( $col1 == 0 )
			{
				$pairMatch .= $cipherTable{ (($row1 - 1) * 5) + 4 };
				$pairMatch .= $cipherTable{ (($row1 - 1) * 5) + 4 };
			}
			else
			{
				$pairMatch .= $cipherTable{ (($row1 - 1) * 5) + $col1 - 1 };
				$pairMatch .= $cipherTable{ (($row1 - 1) * 5) + $col1 - 1 };
			}
		}
		else if($row1 == $row2)
		{
			if($col1 != 0)
			{
				$pairMatch .= $cipherTable{ $pos1 - 1 };
			}
			else
			{
				$pairMatch .= $cipherTable{ ($row1 * 5) + 4 };
			}

			if($col2 != 0)
			{
				$pairMatch .= $cipherTable{ $pos2 - 1 };
			}
			else
			{
				$pairMatch .= $cipherTable{ ($row2 * 5) + 4 };
			}
		}
		else if($col1 == $col2)
		{
			if($row1 != 0)
			{
				$pairMatch .= $cipherTable{ $pos1 - 5 };
			}
			else
			{
				$pairMatch .= $cipherTable{ 20 + $col1};
			}

			if($row2 != 0)
			{
				$pairMatch .= $cipherTable{ $pos2 - 5 };
			}
			else
			{
				$pairMatch .= $cipherTable{ 20 + $col2};
			}
		}
		else
		{
			$pos1 = ( ($row1 * 5) + $col2 );
			$pos2 = ( ($row2 * 5) + $col1 );
			$pairMatch .= $cipherTable{$pos1};
			$pairMatch .= $cipherTable{$pos2};
		}

		return $pairMatch;
	}
?>
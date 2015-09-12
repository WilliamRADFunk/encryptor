<?php
	function caesarEncrypt($cleanText, $key)
	{
		$encryptedText = "";
		for( $i = 0; $i < strlen($cleanText); $i++ )
		{
			$convertedChar = letterToNum( $cleanText{$i} );
			$code = shift( $convertedChar, $key );
			$encryptedText .= chr( $code );
		}
		return $encryptedText;
	}

	function caesarDecode($encryptedText, $key)
	{
		$decodedText = "";
		for( $i = 0; $i < strlen($encryptedText); $i++ )
		{
			$shiftedNum = shift( ord($encryptedText{$i}), (-$key) );
			$ch = NumToLetter( $shiftedNum );
			$decodedText .= $ch;
		}
		return $decodedText;
	}

	function letterToNum($char)
	{
		return ( ord($char) - 32 );
	}

	function NumToLetter($NumValue)
	{
		return ( chr($NumValue + 32) );
	}

	function shift($char, $key)
	{
		if( ($char + $key) < 0 )
		{
			return ( ($char + $key) + 95 );
		}
		else
		{
			return ( ($char + $key) % 95 );
		}
	}
?>
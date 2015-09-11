<?php
	function caesarEncrypt($cleanText, $key)
	{
		$encryptedText = "";
		for( $i = 0; $i < strlen($cleanText); $i++ )
		{
			$convertedChar = letterToNum( $cleanText{$i} );
			$code = shift( $key, $convertedChar );
			$encryptedText .= chr( $code );
		}
		return $encryptedText;
	}

	function caesarDecode($encryptedText, $key)
	{
		$decodedText = "";
		for( $i = 0; $i < strlen($encryptedText); $i++ )
		{
			$convertedNum = NumToLetter( $encryptedText{$i} );
			$char = shift( $key, $convertedNum );
			$decodedText .= $char;
		}
		return $encryptedText;
	}

	function letterToNum($char)
	{
		return ( ord($char) - 32 );
	}

	function NumToLetter($NumValue)
	{
		return ( chr($NumValue + 32) );
	}

	function shift($key, $char)
	{
		return ( ($char + $key) % 95 );
	}

	function deShift($key, $char)
	{
		return ( ($char - $key) % 95 );
	}
?>
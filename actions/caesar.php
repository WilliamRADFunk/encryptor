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

	function caesarDecode($text, $key)
	{
		$decodedText = "";
		for( $i = 0; $i < strlen($text); $i++ )
		{
			$convertedNum = NumToLetter( $text{$i} );
			$ch = shift( (-$key), $convertedNum );
			$decodedText .= $ch;
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
?>
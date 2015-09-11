<?php
	function caesarEncrypt($cleanText, $key)
	{
		$encryptedText = "";
		for( $i = 0; $i < strlen($cleanText); $i++ )
		{
			$convertedChar = letterToCode( $cleanText{$i} );
			$code = shift( $key, $convertedChar );
			$encryptedText .= chr( $code );
		}
		return $encryptedText;
	}

	function letterToCode($char)
	{
		return ( ord($char) - 32 );
	}

	function shift($key, $char)
	{
		return ( ($char + $key) % 95 );
	}
?>
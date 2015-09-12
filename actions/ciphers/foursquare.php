<?php 
	session_start();
	function foursquareEncrypt($plaintext)
	{
		$key1 = generateKey();
		echo $key1, "<br>";
		$key2 = generateKey();
		echo $key2;

		$upperLeft = "abcdefghiklmnopqrstuvwxyz";
		$lowerRight = "abcdefghiklmnopqrstuvwxyz";

		return $upperLeft;
	}

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

?>
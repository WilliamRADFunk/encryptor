<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" prefix="og: http://ogp.me/ns#">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Encryptor</title>
    <link rel="stylesheet" href="css/reset_author_richard_clark.css">
    <link rel="stylesheet" href="css/styles.css">

</head>
<body>

<?php
$emailAddress = htmlspecialchars($_POST["contact"]);
$email = htmlspecialchars($_POST["emailMe"]);
$cryptoMethod = $_POST["crypto-method"];
$plaintext = $_POST["plaintext"];


switch( $cryptoMethod )
{
	case "Caesar":
	{
		$key = rand(1, 93);
		$cleanText = caesarClean($plaintext);
		require_once("caesar.php");
		$encryptedText = caesarEncrypt($cleanText, $key);
		$data = 
		{
			key: $key,
			text: $encryptedText,
			method: $cryptoMethod,
			email: $email,
			address: $emailAddress
		};
		break;
	}
	case "Keyword":
	{
		break;
	}
	case "Vigniere":
	{
		break;
	}
	case "Engima":
	{
		break;
	}
	case "Bitwise":
	{
		break;
	}
	case "Hill":
	{
		break;
	}
	case "Geometric":
	{
		break;
	}
	case "Playfair":
	{
		break;
	}
	case "Transposition":
	{
		break;
	}
	case "MD5":
	{
		break;
	}
	default:
	{
		echo "ERROR: The choice of cryptographic methods did not match any of the available option.";
	}
}
?>

<?php
	function caesarClean($plaintext)
	{
		$cleanText = "";
		for($i = 0; $i < strlen($plaintext); $i++)
		{
			if( (ord($plaintext{$i}) >= 32) && (ord($plaintext{$i}) <= 126) )
			{
				$cleanText .= $plaintext{$i};
			}
		}
		return $cleanText;
	}
?>


</body>
</html>
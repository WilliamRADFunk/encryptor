<?php 
	session_start();
	$_SESSION["emailAddress"] = htmlspecialchars($_POST["contact"]);
	$_SESSION["email"] = $_POST["emailMe"];
	$_SESSION["cryptoMethod"] = $_POST["crypto-method"];
	$plaintext = $_POST["plaintext"];


	switch( $_SESSION["cryptoMethod"] )
	{
		case "Caesar":
		{
			$_SESSION["key"] = rand(1, 93);
			$cleanText = clean($plaintext);
			require_once("caesar.php");
			$_SESSION["result"] = caesarEncrypt($cleanText, $_SESSION["key"]);
			header("Location: http://williamrobertfunk.com/Applications/encryptor/results.php");
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
	function clean($plaintext)
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
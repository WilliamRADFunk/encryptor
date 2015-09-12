<?php 
	session_start();
	$_SESSION["emailAddress"] = htmlspecialchars($_POST["contact"]);
	$_SESSION["email"] = $_POST["emailMe"];
	$_SESSION["key"] = $_POST["key"];
	$_SESSION["cryptoMethod"] = $_POST["crypto-method"];
	$_SESSION["result"] = "";
	$encryptedText = $_POST["encryptedtext"];


	switch( $_SESSION["cryptoMethod"] )
	{
		case "Bitwise":
		{
			break;
		}
		case "Caesar":
		{
			require_once("caesar.php");
			$_SESSION["result"] = caesarDecode($encryptedText, $_SESSION["key"]);
			header("Location: http://williamrobertfunk.com/Applications/encryptor/results.php");
			break;
		}
		case "Engima":
		{
			break;
		}
		case "Geometric":
		{
			break;
		}
		case "Hill":
		{
			break;
		}
		case "Keyword":
		{
			break;
		}
		case "MD5":
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
		case "Vigniere":
		{
			break;
		}
		default:
		{
			echo "ERROR: The choice of cryptographic methods did not match any of the available option.";
		}
	}
?>


</body>
</html>
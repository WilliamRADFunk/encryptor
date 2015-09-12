<link rel="shortcut icon" href="http://williamrobertfunk.com/Applications/encryptor/favicon.ico">
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
		case "Caesar":
		{
			require_once("caesar.php");
			echo $encryptedText;
			echo "-------";
			$_SESSION["result"] = caesarDecode($encryptedText, $_SESSION["key"]);
			echo $_SESSION["result"];
			echo "Something";
			//header("Location: http://williamrobertfunk.com/Applications/encryptor/results.php");
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


</body>
</html>
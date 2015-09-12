<?php 
	session_start();
	// Session variables passed between pages.
	$_SESSION["emailAddress"] = htmlspecialchars($_POST["contact"]);
	$_SESSION["email"] = $_POST["emailMe"];
	$_SESSION["key"] = $_POST["key"];
	$_SESSION["cryptoMethod"] = $_POST["crypto-method"];
	$_SESSION["result"] = "";
	// Page-specific variable.
	$encryptedText = $_POST["encryptedtext"];

	// Depending on the encryption method used, the controller will
	// call only the cipher specified.
	switch( $_SESSION["cryptoMethod"] )
	{
		case "Bitwise":
		{
			break;
		}
		case "Caesar":
		{
			require_once("../ciphers/caesar.php");
			$_SESSION["result"] = caesarDecode($encryptedText, $_SESSION["key"]);
			header("Location: ../../results.php");
			break;
		}
		case "Foursquare":
		{
			require_once("../ciphers/foursquare.php");
			$_SESSION["result"] = foursquareDecode($encryptedText, $_SESSION["key"]);
			header("Location: ../../results.php");
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
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
			require_once("../ciphers/bitwise.php");
			$_SESSION["result"] = bitwiseDecode($encryptedText, $_SESSION["key"]);
			header("Location: ../../results.php");
			break;
		}
		case "Caesar":
		{
			require_once("../ciphers/caesar.php");
			$_SESSION["result"] = caesarDecode($encryptedText, $_SESSION["key"]);
			header("Location: ../../results.php");
			break;
		}
		case "Feistel":
		{
			require_once("../ciphers/feistel.php");
			$_SESSION["result"] = feistelDecode($encryptedText, $_SESSION["key"]);
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
		case "Hill":
		{
			require_once("../ciphers/hill.php");
			$_SESSION["result"] = hillDecode($encryptedText, $_SESSION["key"]);
			header("Location: ../../results.php");
			break;
		}
		case "Keyword":
		{
			require_once("../ciphers/keyword.php");
			$_SESSION["result"] = keywordDecode($encryptedText, $_SESSION["key"]);
			header("Location: ../../results.php");
			break;
		}
		case "Playfair":
		{
			require_once("../ciphers/playfair.php");
			$_SESSION["result"] = playfairDecode($encryptedText, $_SESSION["key"]);
			header("Location: ../../results.php");
			break;
		}
		case "Railfence":
		{
			require_once("../ciphers/railfence.php");
			$_SESSION["result"] = railfenceDecode($encryptedText, $_SESSION["key"]);
			header("Location: ../../results.php");
			break;
		}
		case "RSA":
		{
			require_once("../ciphers/rsa.php");
			$_SESSION["result"] = rsaDecode($encryptedText, $_SESSION["key"]);
			header("Location: ../../results.php");
			break;
		}
		case "Vigniere":
		{
			require_once("../ciphers/vigenere.php");
			$_SESSION["result"] = vigenereDecode($encryptedText, $_SESSION["key"]);
			header("Location: ../../results.php");
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
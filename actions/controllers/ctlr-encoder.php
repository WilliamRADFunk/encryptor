<?php 
	session_start();
	// Session variables passed between pages.
	$_SESSION["emailAddress"] = htmlspecialchars($_POST["contact"]);
	$_SESSION["email"] = $_POST["emailMe"];
	$_SESSION["cryptoMethod"] = $_POST["crypto-method"];
	$_SESSION["result"] = "";
	// Page-specific variable.
	$plaintext = $_POST["plaintext"];

	// Depending on the encryption method used, the controller will
	// call only the cipher specified.
	switch( $_SESSION["cryptoMethod"] )
	{
		case "Bitwise":
		{
			require_once("../ciphers/bitwise.php");
			$_SESSION["result"] = bitwiseEncrypt($plaintext);
			header("Location: ../../results.php");
			break;
		}
		case "Caesar":
		{
			require_once("../ciphers/caesar.php");
			$_SESSION["result"] = caesarEncrypt($plaintext);
			header("Location: ../../results.php");
			break;
		}
		case "Foursquare":
		{
			require_once("../ciphers/foursquare.php");
			$_SESSION["result"] = foursquareEncrypt($plaintext);
			header("Location: ../../results.php");
			break;
		}
		case "Geometric":
		{
			require_once("../ciphers/geometric.php");
			$_SESSION["result"] = geometricEncrypt($plaintext);
			header("Location: ../../results.php");
			break;
		}
		case "Hill":
		{
			require_once("../ciphers/hill.php");
			$_SESSION["result"] = hillEncrypt($plaintext);
			header("Location: ../../results.php");
			break;
		}
		case "Keyword":
		{
			require_once("../ciphers/keyword.php");
			$_SESSION["result"] = keywordEncrypt($plaintext);
			header("Location: ../../results.php");
			break;
		}
		case "MD5":
		{
			require_once("../ciphers/md5.php");
			$_SESSION["result"] = md5Encrypt($plaintext);
			header("Location: ../../results.php");
			break;
		}
		case "Playfair":
		{
			require_once("../ciphers/playfair.php");
			$_SESSION["result"] = playfairEncrypt($plaintext);
			header("Location: ../../results.php");
			break;
		}
		case "Transposition":
		{
			require_once("../ciphers/railfence.php");
			$_SESSION["result"] = railfenceEncrypt($plaintext);
			header("Location: ../../results.php");
			break;
		}
		case "Vigniere":
		{
			require_once("../ciphers/vigenere.php");
			$_SESSION["result"] = vigenereEncrypt($plaintext);
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
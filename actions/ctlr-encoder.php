<?php 
	session_start();
	$_SESSION["emailAddress"] = htmlspecialchars($_POST["contact"]);
	$_SESSION["email"] = $_POST["emailMe"];
	$_SESSION["cryptoMethod"] = $_POST["crypto-method"];
	$_SESSION["result"] = "";
	$plaintext = $_POST["plaintext"];


	switch( $_SESSION["cryptoMethod"] )
	{
		case "Caesar":
		{
			require_once("caesar.php");
			$_SESSION["result"] = caesarEncrypt($plaintext);
			header("Location: ../results.php");
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
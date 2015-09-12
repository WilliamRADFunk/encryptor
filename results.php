<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" prefix="og: http://ogp.me/ns#">
<intercept-url pattern="/favicon.ico" access="permitAll" />

<head>
<!-- Background photo: http://skeletaljoy.tumblr.com/post/3582812227 -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Encryptor</title>
    <link rel="stylesheet" href="css/reset_author_richard_clark.css">
    <link rel="stylesheet" href="css/styles.css">

</head>
<body class="results">

<div id="results-box">
	<h3>CRYPTOGAPHICAL FUNCTION COMPLETE</h3>
	<p class="boxed">Encryption Method Used</p>
	<p>"<?php echo $_SESSION["cryptoMethod"]; ?>"</p>
	<p class="boxed">Key</p>
	<p>"<?php echo $_SESSION["key"]; ?>"</p>
	<?php
		if($_SESSION["emailMe"])
		{
			echo "<p>Encrypted text emailed to: " . $_SESSION["emailAddress"] . "</p>";
		}
	?>
	<p class="clearBoth boxed">Encrypted text</p>
	<textarea rows="10" cols="20"><?php echo $_SESSION["result"]; ?></textarea>
</div>

<?php
	session_unset();
	session_destroy();
?>

</body>
</html>
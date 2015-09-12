<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" prefix="og: http://ogp.me/ns#">
<intercept-url pattern="/favicon.ico" access="permitAll" />

<head>
<!-- Background photo: https://www.flickr.com/photos/41315642@N04/4686290616/in/faves-59382647@N03/ -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Encryptor</title>
    <link rel="stylesheet" href="css/reset_author_richard_clark.css">
    <link rel="stylesheet" href="css/styles.css">

</head>

<body class="decoder">
<form action="index.php" method="post">
	<input id="btn-switch" type="submit" value="SWITCH TO ENCODER">
</form>
<div id="crypto-box">
	<form action="actions/ctlr-decoder.php" method="post">
		<fieldset>
			<legend>THE DECODER</legend>
			<p><label for="crypto-method">Encryption Method:</label></p>
			<select name="crypto-method">
				<option class="encryp-opt" value="Caesar">Caesar Cipher</option>
				<option class="encryp-opt" value="Keyword">Keyword Cipher</option>
				<option class="encryp-opt" value="Vigniere">Vigniere Cipher</option>
				<option class="encryp-opt" value="Engima">Enigma Cipher</option>
				<option class="encryp-opt" value="Bitwise">Bitwise Cipher</option>
				<option class="encryp-opt" value="Hill">Hill Cipher</option>
				<option class="encryp-opt" value="Geometric">Geometric Cipher</option>
				<option class="encryp-opt" value="Playfair">Playfair Cipher</option>
				<option class="encryp-opt" value="Transposition">Transposition (Rail-Fence Depth 2) Cipher</option>
				<option class="encryp-opt" value="MD5">MD5 Cipher</option>
			</select>
			<p><label for="key">Key:</label></p>
			<input type="text" name="key">
			<p><label for="contact">Email Address (optional):</label></p>
			<input type="text" name="contact">
			<p id="check"><input type="checkbox" name="emailMe"><label for="emailMe">Email me the result</label></p>
			<p class="clearBoth"><label for="encryptedtext">Paste in encrypted text to be decoded:</label></p>
			<textarea name="encryptedtext" rows="10" cols="20"></textarea>
			<input id="btn-submit" type="submit" value="Submit">
		</fieldset>
	</form>
</div>
</body>

</html>
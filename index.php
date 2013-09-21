<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<title>Obfuscation Tool</title>
	<link href="./includes/bootstrap.css" rel="stylesheet">
	<!--[if lt IE 9]>
      		<script src="./includes/html5shiv.js"></script>
      		<script src="./includes/respond.js"></script>
    	<![endif]-->
    	<script src="./includes/bootstrap.js"></script>
    	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    	<!-- Alrighty, let's make some AJAX. -->
    	<script type="text/javascript">
    	function beamMeUpScotty()
    	{
    	var sendit;
    	if (window.XmlHttpRequest)
    	{
    	sendit = new XmlHttpRequest();
    	}
    	else
    	{
    	sendit = new ActiveXObject("Microsoft.XMLHTTP");
    	}
    	sendit.open("POST","crypt.php",true);
   	sendit.send("encrypt=document.forms["encrypt"].elements["encrypt"].value");
    	}
    	</script>
</head>

<body onLoad="document.encrypt.encrypt.focus();">
	<div align="center">
		<div class="jumbotron">
		<h1>Welcome!</h1>
		<p>Welcome to the obfuscator. Please enter text to encrypt or decrypt, and a password.</p>
		</div>
		<br />
		<form role="form" name="encrypt">
			<div class="form-group">
			<textarea class="form-control" id="encrypt" name="encrypt" placeholder="Text to encrypt"><?php echo $decrypted; ?></textarea>
			<label for="password">Password:</label>
			<div class="col-lg-10">
			<input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>">
			</div>
			<button type="submit" data-loading-text="Loading..." class="btn btn-primary">Encrypt</button>
			</div>
		</form>
		<form role="form" name="decrypt">
			<div class="form-group">
			<textarea class="form-control" id="decrypt" name="decrypt" placeholder="Text to decrypt"><?php echo $encrypted; ?></textarea>
			<label for="password">Password:</label>
			<div class="col-lg-10">
			<input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>">
			</div>
			<button type="submit" data-loading-text="Loading..." class="btn btn-primary">Decrypt</button>
			</div>
		</form>
        </div>
    <div>
        <p><a href="https://github.com/doubledave/obfuscator-php">Source<a></p>
    </div>
</body>

</html>

<?php
// I want this here
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Obfuscation Tool</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<script type="text/javascript">
var observe;
if (window.attachEvent) {
    observe = function (element, event, handler) {
        element.attachEvent('on'+event, handler);
    };
}
else {
    observe = function (element, event, handler) {
        element.addEventListener(event, handler, false);
    };
}
function fixTehTextArea () {
    var text = document.getElementById('maintext');
    function resize () {
        text.style.height = 'auto';
        text.style.height = text.scrollHeight+'px';
    }
    function delayedResize () {
        window.setTimeout(resize, 0);
    }
    observe(text, 'change',  resize);
    observe(text, 'cut',     delayedResize);
    observe(text, 'paste',   delayedResize);
    observe(text, 'drop',    delayedResize);
    observe(text, 'keydown', delayedResize);

    text.focus();
    text.select();
    resize();
}
</script>
</head>

<body onLoad="fixTehTextArea();">
	<div align="center">
		<p>Welcome to the obfuscator! Please enter your text below as well as a password.</p>
		<br />
		<form name="mainForm" action="obfuscate.php" method="post">
			<textarea id="maintext"></textarea>
			Password: <input type="password" id="password">
			<input type="submit" value="Submit">
		</form>
	</div>
</body>

</html>

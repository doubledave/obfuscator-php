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
                <p>debugging:<br/>
                <?php
                $key="123";
                $decrypted = "Test Message 01.";
                echo "key: ".$key."<br/>";
                echo "decrypted: ".$decrypted."<br/>";
                echo "md5 of key: ".md5($key)."<br/>";
                echo "encrypted: ".encrypt($decrypted,$key);
                ?>
                </p>
		<form name="mainForm" action="obfuscate.php" method="post">
			<textarea id="maintext"></textarea>
			Password: <input type="password" id="password">
			<input type="submit" value="Submit">
		</form>
	</div>
</body>

</html>

<?php
function encrypt($decrypted, $hash)
{
    $hash = md5($decrypted);
    $output = "";
    $index = 0;
    foreach(str_split($decrypted) as $char)
    {
        if ($index >= strlen($hash)) { $index = 0; }
        $byte = ord(substr($hash,$index,1));
        $index++;
        if ($byte < 58) { $byte -= 47; } // convert ascii numbers into number 1 - 10
        if ($byte > 64) { $byte -= 86; } // convert ascii hex a-f into numbers 11-16
        echo " ".$byte." "; //debug
        $upperCase="";
        $tempchar = ord($char);
        echo chr($tempchar).">"; //debug
        if ($tempchar > 47 && $tempchar < 58) { $upperCase = "N"; } // number
        if ($tempchar > 64 && $tempchar < 91) { $upperCase = "U"; } // upper case
        if ($tempchar > 96 && $tempchar < 123) { $upperCase = "L"; } // lower case
        if (strlen($upperCase) > 0 ) { $tempchar += $byte; } // change the character if a number or letter
        if ($upperCase == "N" && $tempchar > 57) { $tempchar -= 10; } // if it wraps out of range of a number
        if ($upperCase == "N" && $tempchar > 57) { $tempchar -= 10; } // repeat once
        if ($upperCase == "U" && $tempchar > 90) { $tempchar -= 26; }
        if ($upperCase == "L" && $tempchar > 122) { $tempchar -= 26; }
        echo $upperCase.chr($tempchar); //debug
        $output = $output.chr($tempchar);
        
    }
    return $output;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
	<title>Obfuscation Tool</title>
</head>

<body onLoad="document.encrypt.encrypt.focus();">
	<div align="center">
		<h1>Welcome to the obfuscator! Please enter your text below as well as a password.</h1>
		<br />
                <p>
                <?php
$encrypted = "";
$decrypted = "";
$operation = "";
$password = "";
$invalid = FALSE;
if (isset($_POST['encrypt']))
{ $decrypted = $_POST['encrypt']; }
if (isset($_POST['decrypt']))
{ $encrypted = $_POST['decrypt']; }
if (isset($_POST['password']))
{ $password = $_POST['password']; }
                    // echo "key: ".$password."</br>";
                    // echo "encrypted: ".$encrypted."<br/>";
                    // echo "decrypted: ".$decrypted."<br/>";
if ($encrypted == "Text to decrypt:")
{ $encrypted = ""; }
if ($decrypted == "Text to encrypt:")
{ $decrypted = ""; }
if (strlen($decrypted)>0 && strlen($encrypted)>0) // don't know if I need to encrypt or decrypt
{ $invalid = TRUE; }
if (strlen($decrypted)<1 && strlen($encrypted)<1) // nothing was entered
{ $invalid = TRUE; }
if (!$invalid)
{
    if (strlen($decrypted) > strlen($encrypted))
    { $operation = "E"; }
    else
    { $operation = "D"; }
}
                if ($invalid)
                { 
                    echo "Invalid.  Text box likely empty?<br/>";
                    // echo "key: ".$password."</br>";
                    // echo "encrypted: ".$encrypted."<br/>";
                    // echo "decrypted: ".$decrypted."<br/>";
                    $encrypted = "Text to decrypt:";
                    $decrypted = "Text to encrypt:";
              }
                else
                {
                // echo "key: ".$password."<br/>";
                // echo "md5 of key: ".md5($password)."<br/>";
                if ($operation == "D")
                { $decrypted = decrypt($encrypted, $password); }
                else
                { $encrypted = encrypt($decrypted, $password); }
                // echo "encrypted: ".$encrypted."<br/>";
                // echo "decrypted: ".$decrypted."<br/>";
                if (strlen($password)<3)
                { echo "<strong>Warning: Password is too short.  It is ".strlen($password)." characters long.</strong><br/>"; }
                }
                ?>
                </p>
		<form name="encrypt" action="" method="post">
			<textarea id="encrypt" name="encrypt"><?php echo $decrypted; ?></textarea>
			Password: <input type="password" id="password" name="password" value="<?php echo $password; ?>">
			<input type="submit" value="Encrypt">
		</form>
		<form name="decrypt" action="" method="post">
			<textarea id="decrypt" name="decrypt"><?php echo $encrypted; ?></textarea>
			Password: <input type="password" id="password" name="password" value="<?php echo $password; ?>">
			<input type="submit" value="Decrypt">
		</form>
        </div>
</body>

</html>

<?php
function encrypt($decrypted, $hash)
{
    $hash = md5($hash);
    $output = "";
    $index = 0;
    foreach(str_split($decrypted) as $char)
    {
        if ($index >= strlen($hash)) { $index = 0; }
        $byte = ord(substr($hash,$index,1));
        $index++;
        // echo " ".chr($byte)." "; //debug
        if ($byte < 58) { $byte -= 47; } // convert ascii numbers into number 1 - 10
        if ($byte > 64) { $byte -= 86; } // convert ascii hex a-f into numbers 11-16
        // echo " ".$byte." "; //debug
        $upperCase="";
        $tempchar = ord($char);
        // echo chr($tempchar).">"; //debug
        if ($tempchar > 47 && $tempchar < 58) { $upperCase = "N"; } // number
        if ($tempchar > 64 && $tempchar < 91) { $upperCase = "U"; } // upper case
        if ($tempchar > 96 && $tempchar < 123) { $upperCase = "L"; } // lower case
        if (strlen($upperCase) > 0 ) { $tempchar += $byte; } // change the character if a number or letter
        if ($upperCase == "N" && $tempchar > 57) { $tempchar -= 10; } // if it wraps out of range of a number
        if ($upperCase == "N" && $tempchar > 57) { $tempchar -= 10; } // repeat once
        if ($upperCase == "U" && $tempchar > 90) { $tempchar -= 26; }
        if ($upperCase == "L" && $tempchar > 122) { $tempchar -= 26; }
        // echo $upperCase.chr($tempchar); //debug
        $output = $output.chr($tempchar);
    }
    return $output;
}
function decrypt($encrypted, $hash)
{
    $hash = md5($hash);
    $output = "";
    $index = 0;
    foreach(str_split($encrypted) as $char)
    {
        if ($index >= strlen($hash)) { $index = 0; }
        $byte = ord(substr($hash,$index,1));
        $index++;
        // echo " ".chr($byte)." "; //debug
        if ($byte < 58) { $byte -= 47; } // convert ascii numbers into number 1 - 10
        if ($byte > 64) { $byte -= 86; } // convert ascii hex a-f into numbers 11-16
        // echo " ".$byte." "; //debug
        $upperCase="";
        $tempchar = ord($char);
        // echo chr($tempchar).">"; //debug
        if ($tempchar > 47 && $tempchar < 58) { $upperCase = "N"; } // number
        if ($tempchar > 64 && $tempchar < 91) { $upperCase = "U"; } // upper case
        if ($tempchar > 96 && $tempchar < 123) { $upperCase = "L"; } // lower case
        if (strlen($upperCase) > 0 ) { $tempchar -= $byte; } // change the character if a number or letter
        if ($upperCase == "N" && $tempchar < 48) { $tempchar += 10; } // if it wraps out of range of a number
        if ($upperCase == "N" && $tempchar < 48) { $tempchar += 10; } // repeat once
        if ($upperCase == "U" && $tempchar < 65) { $tempchar += 26; }
        if ($upperCase == "L" && $tempchar < 97) { $tempchar += 26; }
        // echo $upperCase.chr($tempchar); //debug
        $output = $output.chr($tempchar);
    }
    return $output;
}
?>

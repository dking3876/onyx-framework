<?php
$info = $_REQUEST['info'];
$utilities = "<php
interface IonyxUtilities {

    const \$salt = '{$info['salt']}';
}
";
$fp=fopen('IonyxAuthenticate.php', 'w');
fwrite($fp, $Icreds);
fclose($fp);
?>
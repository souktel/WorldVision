<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$sh_status = 0; // Hide
$split_reference = str_split($command_array[1], 2);
if(strtoupper($split_reference[0]) == "JV")
{
    require_once("../jobmatch/jo/sms/jv_sh.php");
}
else if(strtoupper($split_reference[0]) == "CV")
{
    require_once("../jobmatch/js/sms/cv_sh.php");
}
else
{
    reply("C61", null);
}
?>

<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$split_reference = str_split($command_array[1], 2);
if(strtoupper($split_reference[0]) == "JV")
{
    require_once("../jobmatch/jo/sms/jv_update.php");
}
else if(strtoupper($split_reference[0]) == "CV")
{
    require_once("../jobmatch/js/sms/cv_update.php");
}
else
{
    reply("C63", null);
}
?>

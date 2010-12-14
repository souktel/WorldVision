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
    require_once("../jobmatch/jo/sms/jv_view.php");
}
else if(strtoupper($split_reference[0]) == "CV")
{
    require_once("../jobmatch/js/sms/cv_view.php");
}
else
{
    reply("C64", null);
}
?>

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
    require_once("../jobmatch/jo/sms/jv_remove.php");
}
else if(strtoupper($split_reference[1]) == "CV")
{
    require_once("../jobmatch/js/sms/cv_remove.php");
}
else
{
    $split_reference = str_split($command_array[1], 1);
    if(strtoupper($split_reference[0]) == "G")
    {
        require_once("../groups/sms/group_remove.php");
    }
    else
    {
        reply("C60", null);
    }
}
?>

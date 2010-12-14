<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(sizeof($command_array) < 3)
{
    reply("A38", null);
}
else
{
    $group_reference = string_wslashes($command_array[1]);
    $msg2send = "";
    for($gn = 2; $gn < sizeof($command_array); $gn++) $msg2send .= $command_array[$gn]." ";
    $msg2send = trim($msg2send);

    if($group_reference == "" || $msg2send == "")
    {
        reply("A39", null);
    }
    else
    {
        $split_reference = str_split($group_reference, 1);
        if(strtoupper($split_reference[0]) == "G")
        {
            require_once("../alerts/sms/groups_sg.php");
        }
        else if(strtoupper($split_reference[0]) == "R")
        {
            reply("A40", null);
        }
        else
        {
            reply("A41", null);
        }
    }
}

?>
<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(sizeof($command_array) != 3)
{
    reply("A03", null);
}
else
{
    $group_reference = string_wslashes($command_array[1]);
    $users_to_add = split("\.",string_wslashes($command_array[2]));

    if($group_reference != "" && sizeof($users_to_add) > 0)
    {
        $split_reference = str_split($group_reference, 1);
        if(strtoupper($split_reference[0]) == "G")
        {
            require_once("../groups/sms/groups_adds.php");
        }
        else if(strtoupper($split_reference[0]) == "R")
        {
            require_once("../groups/sms/group_refs_adds.php");
        }
    }
    else
    {
        reply("A04", null);
    }
}

?>
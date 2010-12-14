<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if(sizeof($command_array) >= 2)
{
    $command_array[1] = strtolower($command_array[1]);
}
else
{
    $command_array[1] = "WOG";
}

$command_array[2] = 2;
require_once("cmds/register.php");
?>

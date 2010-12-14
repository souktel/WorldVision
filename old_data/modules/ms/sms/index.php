<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

/*
 * Aljazeera TV : GAZA SMS System
 */

$ms_text = "";
for($msi = 1; $msi <= sizeof($command_array); $msi++)
{
    $ms_text .= $command_array[$msi]." ";
}

$ms_text = mysql_escape_string(trim($ms_text));
$ms_mobile = trim($req_mobile);

if(mysql_query("INSERT INTO tbl_mini_survey VALUES(id, $ms_system, '$ms_mobile', '$ms_text', CURRENT_TIMESTAMP, 0)", $sms_dbid))
{
    reply("B99", null);
}
else
{
    reply("C01", null);
}

?>

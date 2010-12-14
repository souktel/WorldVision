<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

/* 
 * Test Command
 */

$tst_text = "";
for($tsi = 1; $tsi <= sizeof($command_array); $tsi++)
{
    $tst_text .= $command_array[$tsi]." ";
}
reply_static(trim($tst_text));

?>

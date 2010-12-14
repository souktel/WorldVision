<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

/*
 * Tamer Qasim
 * This file contains the main parameters and settings for the system
 */

//Application Path

//URL to the folder where you put the cpanel script files without the lasting slash
//$folder_path = "/souktel";
$folder_path = "";

//Server Port with [: Symbol] (default = ":80")
//$server_port = ":80"; // e.g $server_port = ":8080"

//Absolute Path
//$param_abs_path = "/souktel/";
$param_abs_path = "/";

//##########################################################################   
//Do Not Modify     

//System Images Absolute Path
$param_abs_path_si = $param_abs_path."images/system/";

//System Images Absolute Path
$param_abs_path_sib = $param_abs_path_si."buttons/";   

//Server URL
$param_server = "http://".$_SERVER["HTTP_HOST"].$folder_path;
//##########################################################################   

?>

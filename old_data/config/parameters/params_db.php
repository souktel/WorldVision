<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

/*
 * Tamer Qasim
 * This file contains database paramerters and variables
 */

 /*
  * Database
  */
    
function string_wslashes($string)
{
    return addslashes($string);
}

//Database IP Address
//$param_db_ipaddr = "97.74.87.219";
$param_db_ipaddr = "localhost";

//Database Port
$param_db_port = "3306";

//Database Name
//$param_db_dbname = "db_tst_souktel";
$param_db_dbname = "db_worldvision";

//Database Users, Passwords array
$param_db_users[0][0] = "dbwvn";
//$param_db_users[0][0] = "root";

$param_db_users[0][1] = "wvn@1o1o";
//$param_db_users[0][1] = "";

//Database Rows per Page
$param_db_rows_per_page = 20;

?>

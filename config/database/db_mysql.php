<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

/*
 * Tamer Qasim
 * This file contains functions and procedures for database connection,
 * manipluation and retreival
 */

/*
* Function
* name: db_connect
* no attributes
* return: db resource link id
*/
function db_connect()
{
    //define the global variables
    global $param_db_ipaddr,$param_db_port,$param_db_dbname,$param_db_users;

    $db_username = $param_db_users[0][0];
    $db_password = $param_db_users[0][1];

    $dbid = mysql_connect($param_db_ipaddr.":".$param_db_port,$db_username,$db_password);

    if($dbid != false)
    {
        mysql_select_db($param_db_dbname);
        mysql_query("SET NAMES 'utf8';", $dbid);
        mysql_query("SET CHARACTER SET 'utf8';", $dbid);
    }

    return $dbid;
}

/*
* Function
* name: db_close
* one attribute($dbid: db resource link id)
* no return
*/
function db_close($dbid)
{
    mysql_close($dbid);
}

?>

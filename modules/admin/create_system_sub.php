<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */
if($param_session_check != "zZZz4332W")
{
    header("Location: index.php");
}  
?>
<?php
/*
 * Tamer Qasim
 */

//Validation Data Fields
$errors = array();
$rules = array();

//Error Flag
$error_found = false; //No Errors at first
$error_no = "";

$name = string_wslashes($_POST['name']);
$prefix = trim(string_wslashes(trim($_POST['prefix'])));
$mobile = trim(string_wslashes(trim($_POST['mobile'])));
$country = string_wslashes($_POST['country']);
$language = string_wslashes($_POST['language']);
$system_status = string_wslashes($_POST['system_status']);
$sms_status = string_wslashes($_POST['sms_status']);
$other_info1 = string_wslashes($_POST['other_info1']);
$other_info2 = string_wslashes($_POST['other_info2']);

//Modules
$modules = array();
for($i = 0; $i < sizeof($_POST['module']); $i++)
{
    $modules[] = string_wslashes($_POST['module'][$i]);
}

//Name
$rules[] = ("required,name,Required : Name.");
$rules[] = ("length<=100,name,Name : < 100 chars please.");

//Prefix
$rules[] = ("required,prefix,Required : Prefix.");
$rules[] = ("letters_only,prefix,Prefix : a-Z only please.");
$rules[] = ("length=1-4,prefix,Prefix : 1-4 chars");

//Mobile
$rules[] = ("digits_only,mobile,Mobile : Digits only please.");
$rules[] = ("required,mobile,Required : Mobile.");
$rules[] = ("length<=20,mobile,Mobile : < 20 digits please.");

//Confirm Mobile
$rules[] = ("same_as,confirm,mobile,Mobile is not equal to Confirmation Mobile");    

$errors = validateFields($_POST, $rules);

if (sizeof($errors)==0)
{
    $dbid = db_connect();

    mysql_query("BEGIN");

    //Select First City For The Selected Country
    $rs_city = mysql_query("SELECT city_id FROM tbl_ref_city WHERE country_id = $country", $dbid);
    $row_city = mysql_fetch_array($rs_city);
    $city = $row_city[0];
    //==

    $rs_system = mysql_query("INSERT INTO tbl_sys VALUES(sys_id, '$prefix', '$prefix', '$name', $language, $country, $system_status, $sms_status, CURRENT_TIMESTAMP, 7200, '$other_info1', '$other_info2', api_id, api_key, 0)", $dbid);

    $system_id = mysql_insert_id($dbid);

    if($rs_system)
    {
        $modules_error = false; //No Error :default
        for($i = 0; $i < sizeof($modules); $i++)
        {
            $module_id = $modules[$i];
            if(!mysql_query("INSERT INTO tbl_sys_module VALUES($system_id, $module_id)", $dbid))
            {
                $modules_error = true;
            }
        }
        if($modules_error == false)
        {
            $query = "INSERT INTO tbl_sys_user VALUES(user_id, $system_id, '$mobile', '1234', '$mobile', SHA1('1234'), 2 ,1 ,0, CURRENT_TIMESTAMP, 'System Administrator', $country, $city, '',1)";
            $query_unique_mobile = "SELECT user_id FROM tbl_sys_user WHERE sys_id = $system_id AND (mobile = '$mobile' OR username = '$mobile')";

            $rs = mysql_query($query_unique_mobile, $dbid);

            if($row = mysql_fetch_array($rs))
            {
                $error_found = true;
                $error_no = "10101"; // Mobile number already exists
            }
            else
            {
                if(mysql_query($query,$dbid))
                {
                    $current_id = mysql_insert_id($dbid);
                    $query_insert = "INSERT INTO tbl_sys_user_nind VALUES($current_id, '', '', '', '', '')";
                    if(!mysql_query($query_insert,$dbid))
                    {
                        $error_found = true;
                        $error_no = "1602";
                        mysql_query("ROLLBACK");
                    }
                    else
                    {
                        if(!mysql_query("INSERT INTO tbl_sys_user_lastlogin VALUES($current_id, CURRENT_TIMESTAMP)",$dbid))
                        {
                            $error_found = true;
                            $error_no = "1602";
                            mysql_query("ROLLBACK");
                        }
                        else
                        {
                            for($i = 0; $i < sizeof($modules); $i++)
                            {
                                $module_id = $modules[$i];
                                if(!mysql_query("INSERT INTO tbl_sys_user_module VALUES($current_id,$module_id)",$dbid))
                                {
                                    $error_found = true;
                                    $error_no = "1602";
                                    mysql_query("ROLLBACK");
                                    break;
                                }
                            }
                        }
                    }
                }
                else
                {
                    $error_found = true;
                    $error_no = "1602";
                    mysql_query("ROLLBACK");
                }
            }

            if(!$error_found) mysql_query("COMMIT");
        }
        else
        {
            $error_found = true;
            $error_no = "1602";
            mysql_query("ROLLBACK");
        }
    }
    else
    {
        $error_found = true;
        $error_no = "1602";
        mysql_query("ROLLBACK");
    }

    db_close($dbid);

}
else
{
    $error_found = true;
    $error_no = "1501";
}

if ($error_found)
{
    //Failed
    header("Location: $param_server"."/templates/html/error.php?en=".$error_no);
}
else
{
    //Success
    header("Location: ".$param_server."/modules/admin/index.php");
}
?>
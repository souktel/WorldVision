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

$name = trim(string_wslashes(trim($_POST['name'])));
$mobile = trim(string_wslashes(trim($_POST['mobile'])));

$password = string_wslashes($_POST['password']);
$pin = string_wslashes($_POST['pin']);

$country = string_wslashes($_POST['country']);
$city = string_wslashes($_POST['city']);

$email = string_wslashes($_POST['email']);

$usertype = string_wslashes($_POST['usertype']);

$year = string_wslashes($_POST['year']);
$month = string_wslashes($_POST['month']);
$day = string_wslashes($_POST['day']);
$gender = string_wslashes($_POST['gender']);

$phone = string_wslashes($_POST['phone']);
$fax = string_wslashes($_POST['fax']);
$website = string_wslashes($_POST['website']);
$business_field = string_wslashes($_POST['business_field']);
$description = string_wslashes($_POST['description']);

//Name
$rules[] = ("required,name,Required : Name.");
$rules[] = ("length<=100,name,Name : < 100 chars please.");

//Mobile
$rules[] = ("digits_only,mobile,Mobile : Digits only please.");
$rules[] = ("required,mobile,Required : Mobile.");
$rules[] = ("length<=20,mobile,Mobile : < 20 digits please.");

//PIN CODE
$rules[] = ("digits_only,pin,PIN : Digits only please.");
$rules[] = ("required,pin,Required : PIN.");
$rules[] = ("length=4-4,pin,PIN : 4 Digits");   

//Confirm PIN
$rules[] = ("same_as,confirmpin,pin,PIN not equal Conformation PIN");

//Password
$rules[] = ("is_alpha,password,Password : 0-9, a-Z only please.");
$rules[] = ("required,password,Required : Password.");
$rules[] = ("length=4-20,password,Password : 4 - 15 chars");

//Confirm Password
$rules[] = ("same_as,confirmpassword,password,Password not equal Conformation Password");

//Country
$rules[] = ("digits_only,country,Country : Digits only please.");
$rules[] = ("required,country,Required : Country.");

//City
$rules[] = ("digits_only,city,City : Digits only please.");
$rules[] = ("required,city,Required : City.");

//User Type
$rules[] = ("digits_only,usertype,Usertype : Digits only please.");
$rules[] = ("required,usertype,Required : Usertype.");

//DOB
//$rules[] = ("valid_date,month,day,year,any_date,Date of Birth : Invalid Date.");

//Gender
$rules[] = ("digits_only,gender,Gender : Digits only please.");
$rules[] = ("required,gender,Required : Gender.");

//Email
$rules[] = ("valid_email,email,Email : Not Valid Email");

//Phone
$rules[] = ("digits_only,phone,Phone : Digits only please.");
$rules[] = ("length<=20,phone,Phone : < 20 digits please.");

//Fax
$rules[] = ("digits_only,fax,Fax : Digits only please.");
$rules[] = ("length<=20,fax,Fax : < 20 digits please.");

$errors = validateFields($_POST, $rules);

if (sizeof($errors)==0)
{
    $dbid = db_connect();

    $query = "INSERT INTO tbl_sys_user VALUES(user_id, $param_session_sys_id, '$mobile', '$pin', '$mobile', SHA1('$password'), $usertype ,1 ,0, CURRENT_TIMESTAMP, '$name', $country, $city, '$email',1)";
    $query_unique_mobile = "SELECT user_id FROM tbl_sys_user WHERE sys_id = $param_session_sys_id AND (mobile = '$mobile' OR username = '$mobile') AND registered = 1";

    mysql_query("BEGIN");

    if($usertype == "1" || $usertype == 1)
    {
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
                $query_insert = "INSERT INTO tbl_sys_user_ind VALUES($current_id, $year, $month, $day, $gender)";
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
                        $rs2 = mysql_query("SELECT dm.module_id FROM tbl_sys_default_usertype_module dm, tbl_sys_module sm WHERE sm.sys_id = dm.sys_id AND sm.module_id = dm.module_id AND dm.type_id = $usertype AND sm.sys_id = $param_session_sys_id", $dbid);
                        while ($row2 = mysql_fetch_array($rs2))
                        {
                            $available_4user = $row2[0];
                            $query_insert = "INSERT INTO tbl_sys_user_module VALUES($current_id,$available_4user)";
                            if(!mysql_query($query_insert,$dbid))
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
    }
    else if($usertype == "2" || $usertype == 2)
    {
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
                $query_insert = "INSERT INTO tbl_sys_user_nind VALUES($current_id, '$phone', '$fax', '$website', '$business_field', '$description')";
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
                        $rs2 = mysql_query("SELECT dm.module_id FROM tbl_sys_default_usertype_module dm, tbl_sys_module sm WHERE sm.sys_id = dm.sys_id AND sm.module_id = dm.module_id AND dm.type_id = $usertype AND sm.sys_id = $param_session_sys_id", $dbid);
                        while ($row2 = mysql_fetch_array($rs2))
                        {
                            $available_4user = $row2[0];
                            $query_insert = "INSERT INTO tbl_sys_user_module VALUES($current_id,$available_4user)";
                            if(!mysql_query($query_insert,$dbid))
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
    }
    else
    {
        $error_found = true;
        $error_no = "1601";
    }

    if(!$error_found) mysql_query("COMMIT");

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
    $return_url = $_POST["return_url"];
    header("Location: ".$param_server."/modules/system/index.php");
}

?>

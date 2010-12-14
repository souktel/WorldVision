<?php
    /**
     * Souktel v2.0
     * Developed By Tamer A. Qasim
     * +972(0)599358296
     * q.tamer@gmail.com
     */

    function check_login_success()
    {
        $error_found = false;
        
        $v = array();
        $v[] = $_SESSION['param_session_sys_id'];
        $v[] = $_SESSION['param_session_sys_prefix'];
        $v[] = $_SESSION['param_session_sys_reference_code'];
        $v[] = $_SESSION['param_session_user_user_id'];
        $v[] = $_SESSION['param_session_user_mobile'];
        $v[] = $_SESSION['param_session_user_modules'];
        $v[] = $_SESSION['param_session_current_login'];
        
        for($ij = 0; $ij < 7;$ij++)
        {
            if(empty($v[$ij]) || $v[$ij] == "")
            {
                $error_found = true;
                break;
            }
        }
        
        if(!$_SESSION['param_session_login-true'] == "souktel-sudani54-true")
        {
            $error_found = true;
        }
        
        //$_SESSION['param_session_sys_host']
        if(!$_SESSION['param_session_sys_host'] == $_SERVER["HTTP_HOST"])
        {
            $error_found = true;
        }
        
        return !$error_found;
    }
    
    //contains header redirection
    function check_valid_login()
    {
        if(!check_login_success())
        {
            global $param_server;
            header("Location: ".$param_server."/logoff.php");
        }
    }
    
?>

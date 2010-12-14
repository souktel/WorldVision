<?php
    session_start();
    /*
     * Tamer Qasim
     */

    //Database Parameters
    require_once($apath."config/parameters/params_db.php");
    //Database Connection
    require_once($apath."config/database/db_mysql.php");
    
    //Main Parameters
    require_once($apath."config/parameters/params_main.php");
    
    //Session Parameters
    require_once($apath."config/parameters/params_session.php");
    
    //Menu Parameters
    require_once($apath."config/parameters/params_header_menu.php");
    
    //Functions
    require_once($apath."config/functions/validation.php");
    require_once($apath."config/functions/util_func.php");
    require_once($apath."config/functions/val_func.php");
    require_once($apath."config/functions/oth_func.php");
    require_once($apath."config/functions/send_func.php");
    
    //Authentication Module
    if($required_login == true)
    {
        //Check Authentication
        require_once($apath."auth/check_authentication.php");
        check_valid_login(); //from auth/check_authentication.php file
    }
    
    //Check module availability
    $available_module_here = false;
    
    $page_title = "";
    
    for($cm = 0;$cm < $menu_count;$cm++)
    {
        if(strtoupper($param_header_menu[$cm][2]) == strtoupper($module_prefix))
        {
            if($param_header_menu[$cm][3] == "1")
            {
                $available_module_here = true;
                $page_title = $param_header_menu[$cm][0];
                break;
            }
        }
    }
    
    if(!$available_module_here)
    {
        header("Location: ".$param_server."/logoff.php");
    }
    
    
    /*
     * Extended Design or Not
     * By passing the GET attribute
     */
    //Header
    if($_GET['act'] != "1")
    {
        $extended = $_GET['extended']==''?$_SESSION['param_session_extended']:$_GET['extended'];
        if(!$extended == "ED455Xx") {
	    $param_session_extended = "";
	    $_SESSION['param_session_extended'] = "";
	}
        else {
	    $param_session_extended = $extended;
	    $_SESSION['param_session_extended'] = $extended;
	}
        if($param_session_extended != "ED455Xx")
        {
            require_once($apath."templates/html/header_inc.php");
        } else {
            require_once($apath."templates/html/header_ne_inc.php");
        }
    }
    
    //Include Function List Array
    if(!empty($function_list_path) && $function_list_path != "")
    {
        require_once($apath.$function_list_path);
    }
    
?>

<?php
    //Page Code Starts Here

    $req_action = "0"; // 0 Means design
    if(isset($_GET['act']) && $_GET['act'] != "" && is_numeric($_GET['act']))
    {
        $req_action = $_GET['act'];
    }
    if($req_action != "1" && $req_action != "2")
    {
        if($design_page != "")
        {
            $design_page = $apath.$design_page;
            require_once($apath."templates/html/header_module.php");
            require_once($design_page);
            require_once($apath."templates/html/footer_module.php");
        }
    } 
    else 
    {
        if($req_action == "2" && $submit_page != "")
        {
            $design_page = $apath.$submit_page;
            require_once($apath."templates/html/header_module.php");
            require_once($design_page);
            require_once($apath."templates/html/footer_module.php");
        }
        else if($submit_page != "")
        {
            $submit_page = $apath.$submit_page;
            require_once($submit_page);
        }
    }
?>
<?php
    /*
     * Extended Design or Not
     * By passing the GET attribute
     */
    //Footer
    if($_GET['act'] != "1")
    {
        $extended = $_GET['extended']==''?$_SESSION['param_session_extended']:$_GET['extended'];
        if(!$extended == "ED455Xx") {
	    $param_session_extended = "";
	    $_SESSION['param_session_extended'] = "";
	}
        else {
	    $param_session_extended = $extended;
	    $_SESSION['param_session_extended'] = $extended;
	}
        if($param_session_extended != "ED455Xx")
        {
            require_once($apath."templates/html/footer_inc.php");
        } else {
            require_once($apath."templates/html/footer_ne_inc.php");
        }   
    }
?>
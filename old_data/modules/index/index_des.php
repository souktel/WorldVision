<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($param_session_check != "zZZz4332W") {
    header("Location: index.php");
}  
?>

<?php if(strtolower($_SERVER["HTTP_HOST"])=='mercycorps.mysouktel.com' || strtolower($_SERVER["HTTP_HOST"])=='www.mercycorps.mysouktel.com') {?>
    <?php require_once 'mc_homepage.php';?>
<?php } else {?>
<div align="center">
    <a href="http://www.souktel.org/" target="_blank"><img border="0" src="<?php echo $param_abs_path_sib;?>souktel.gif" style="border: 0px solid #000000; padding: 1px" align="left" hspace="10" vspace="10"></a>
</div>
<?php }?>

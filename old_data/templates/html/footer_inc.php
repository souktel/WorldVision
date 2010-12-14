</td>
<td valign="top">
    <?php if($function_list_path !="") {?>
    <table border="0" width="234" cellpadding="0" style="border-collapse: collapse" background="<?php echo $param_abs_path_si;?>body-background.gif">
        <tr>
            <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-upper-left.gif">&nbsp;</td>
            <td height="20" background="<?php echo $param_abs_path_si;?>body-upper.gif">&nbsp;</td>
            <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-upper-right.gif">&nbsp;</td>
        </tr>
        <tr>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-left.gif">&nbsp;</td>
            <td><font size="4" face="Trebuchet MS"><?php echo $function_list_title;?></font></td>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-right.gif">&nbsp;</td>
        </tr>
        <tr>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-left.gif">&nbsp;</td>
            <td><hr size="0" noshade></td>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-right.gif">&nbsp;</td>
        </tr>
        <tr>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-left.gif">&nbsp;</td>
            <td>
                <table border="0" width="100%" cellspacing="3" cellpadding="3" style="border-collapse: collapse">
                        <?php for($j=0;$j<sizeof($param_fun_menu);$j++) {
                            if($param_fun_menu[$j][3] != "1") {
                                ?>
                    <tr>
                        <td width="24" align="center">
                            <img border="0" src="<?php echo $param_fun_menu[$j][2];?>" width="24" height="24"></td>
                        <td><b>
                                <font face="Trebuchet MS" size="2"><a href="<?php echo $param_fun_menu[$j][1];?>" <?php if($param_fun_menu[$j][3]=="5") {echo " target=\"_blank\"";}?>><?php echo $param_fun_menu[$j][0];?></a></font></b></td>
                    </tr>
                            <?php
                            }
                        }
                        ?>
                </table>
            </td>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-right.gif">&nbsp;</td>
        </tr>

            <?php if($module_prefix == "Alerts" && $param_session_sys_api_id != '10001') {?>
                <?php
                $count_1 = null;
                $count_2 = null;

                $url = "http://api.mysouktel.com/sms/credit.php?api_id=$param_session_sys_api_id&key=$param_session_sys_api_key";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_G, 1);
                $credit = curl_exec($ch);
                curl_close($ch);

                if(strtoupper($credit) != 'UNLIMITED' && strtoupper($credit) != '@@@') {

                $count_arr = split('@@@', $credit);

                $count_1 = $count_arr[0];
                $count_2 = $count_arr[1];

                ?>
        <tr>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-left.gif">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-right.gif">&nbsp;</td>
        </tr>
        <tr>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-left.gif">&nbsp;</td>
            <td><font size="4" face="Trebuchet MS">Credit</font></td>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-right.gif">&nbsp;</td>
        </tr>
        <tr>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-left.gif">&nbsp;</td>
            <td><hr size="0" noshade></td>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-right.gif">&nbsp;</td>
        </tr>
        <tr>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-left.gif">&nbsp;</td>
            <td><font size="2" face="Trebuchet MS">Jawwal: <?php echo $count_1;?> Messages</font></td>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-right.gif">&nbsp;</td>
        </tr>
        <tr>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-left.gif">&nbsp;</td>
            <td><font size="2" face="Trebuchet MS">International: <?php echo $count_2;?> Messages</font></td>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-right.gif">&nbsp;</td>
        </tr>
            <?php } }?>

        <tr>
            <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-lower-left.gif">&nbsp;</td>
            <td height="20" background="<?php echo $param_abs_path_si;?>body-lower.gif">&nbsp;</td>
            <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-lower-right.gif">&nbsp;</td>
        </tr>
    </table>
    <?php }?>
    <table border="0" width="234" cellpadding="0" style="border-collapse: collapse" background="<?php echo $param_abs_path_si;?>body-background.gif">
        <tr>
            <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-upper-left.gif">&nbsp;</td>
            <td height="20" background="<?php echo $param_abs_path_si;?>body-upper.gif">&nbsp;</td>
            <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-upper-right.gif">&nbsp;</td>
        </tr>
        <tr>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-left.gif">&nbsp;</td>
            <td><font size="4" face="Trebuchet MS">Account</font></td>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-right.gif">&nbsp;</td>
        </tr>
        <tr>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-left.gif">&nbsp;</td>
            <td><hr size="0" noshade></td>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-right.gif">&nbsp;</td>
        </tr>
        <tr>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-left.gif">&nbsp;</td>
            <td>
                <table border="0" width="100%" cellspacing="3" cellpadding="3" style="border-collapse: collapse">
                    <tr>
                        <td width="24" align="center">
                            <img border="0" src="<?php echo $param_abs_path_sib;?>profile.png" width="24" height="24"></td>
                        <td><b>
                                <font face="Trebuchet MS" size="2"><a href="<?php echo $param_server."/modules/profile/index.php";?>">Profile</a></font></b></td>
                    </tr>
                    <tr>
                        <td width="24" align="center">
                            <img border="0" src="<?php echo $param_abs_path_sib;?>logout.gif" width="24" height="24"></td>
                        <td><b>
                                <font face="Trebuchet MS" size="2"><a href="<?php echo $param_server."/logoff.php";?>">Logoff</a></font></b></td>
                    </tr>
                </table>
            </td>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-right.gif">&nbsp;</td>
        </tr>
        <tr>
            <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-lower-left.gif">&nbsp;</td>
            <td height="20" background="<?php echo $param_abs_path_si;?>body-lower.gif">&nbsp;</td>
            <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-lower-right.gif">&nbsp;</td>
        </tr>
    </table>


    <?php if(strtolower($_SERVER["HTTP_HOST"])=='.souktelgaza.org' || strtolower($_SERVER["HTTP_HOST"])=='www.souktelgaza.org') {?>
    <div align="center"><br><img border="0" src="<?php echo $param_abs_path_si;?>homepage/wv.png"></div>
    <?php } else {?>
    <table border="0" width="234" cellpadding="0" style="border-collapse: collapse" background="<?php echo $param_abs_path_si;?>body-background_w.gif">
        <tr>
            <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-upper-left_w.gif">&nbsp;</td>
            <td height="20" background="<?php echo $param_abs_path_si;?>body-upper_w.gif">&nbsp;</td>
            <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-upper-right_w.gif">&nbsp;</td>
        </tr>
        <tr>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-left_w.gif">&nbsp;</td>
            <td>
                <table border="0" width="100%" cellspacing="3" cellpadding="3" style="border-collapse: collapse">
                    <tr>
                        <td>
                            <p align="center">
                                    <?php if(strtolower($_SERVER["HTTP_HOST"])=='souktelgaza.org' || strtolower($_SERVER["HTTP_HOST"])=='www.souktelgaza.org') {?>
                                <img border="0" src="<?php echo $param_abs_path_si;?>buttons/wv.png">
                                    <?php } else {?>
                                <font face="Trebuchet MS" size="6" color="#6B850C"><font color="#660300">Banner</font> Ad</font>
                                    <?php }?>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-right_w.gif">&nbsp;</td>
        </tr>
        <tr>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-left_w.gif">&nbsp;</td>
            <td><hr size="0" noshade></td>
            <td width="20" background="<?php echo $param_abs_path_si;?>body-right_w.gif">&nbsp;</td>
        </tr>
        <tr>
            <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-lower-left_w.gif">&nbsp;</td>
            <td height="20" background="<?php echo $param_abs_path_si;?>body-lower_w.gif">&nbsp;</td>
            <td width="20" height="20" background="<?php echo $param_abs_path_si;?>body-lower-right_w.gif">&nbsp;</td>
        </tr>
    </table>
    <?php }?>


    <table border="0" width="234" cellpadding="0" style="border-collapse: collapse">
        <tr>
            <td width="20" height="20">&nbsp;</td>
            <td height="20">&nbsp;</td>
            <td width="20" height="20">&nbsp;</td>
        </tr>
        <tr>
            <td width="20">&nbsp;</td>
            <td>
                <p align="center">
                    <img border="0" src="<?php echo $param_abs_path_si;?>header.gif" width="200" height="75">
            </td>
            <td width="20">&nbsp;</td>
        </tr>
        <tr>
            <td width="20" height="20">&nbsp;</td>
            <td height="20">&nbsp;</td>
            <td width="20" height="20">&nbsp;</td>
        </tr>
    </table>
</td>
</tr>
</table>
</div>
<hr size="0" noshade width="950">
<p align="center"><font face="Tahoma" size="2">Copyright 2010 © Souktel. All
	Rights Reserved</font></p>

</body>

</html>

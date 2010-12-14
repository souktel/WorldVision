<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */
?>
<html dir="ltr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Content-Language" content="ar-sa">
        <title>Souktel - System Emulator</title>
        <script type="text/javascript">
            /**
             * Souktel v2.0
             * Developed By Tamer A. Qasim
             * +972(0)599358296
             * q.tamer@gmail.com
             */

            var xmlHttp;

            function sendMessage()
            {
                sendSMS(document.getElementById("sc").value, document.getElementById("from").value, document.getElementById("reply_msg").value);
            }

            function sendSMS(str_sc, str_from, str_text)
            {
                if (str_from.length==0 || str_text.length==0 || str_sc.length==0)
                {
                    alert("Please make sure you have entered the right mobile and text message!");
                    return false;
                }
                xmlHttp=GetXmlHttpObject();
                if (xmlHttp==null)
                {
                    alert("Browser does not support HTTP Request");
                    return false;
                }
                var url="http://<?php echo $_SERVER['HTTP_HOST'];?>/modules/sms/index.php?tester_agent=yes1&sc=37190&sc="+str_sc+"&from="+str_from+"&text="+str_text;
                xmlHttp.onreadystatechange=stateChanged;
                xmlHttp.open("GET",url,true);
                xmlHttp.send(null);
                document.getElementById("imgloader").innerHTML = '<img src="http://<?php echo $_SERVER['HTTP_HOST'];?>/emulator/ajax-loader.gif"></img>';
                return false;
            }

            function stateChanged()
            {
                document.getElementById("imgloader").innerHTML = "";
                if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
                {
                    document.getElementById("reply_msg").value = xmlHttp.responseText;
                }
            }
            function GetXmlHttpObject()
            {
                var xmlHttp=null;
                try
                {
                    xmlHttp=new XMLHttpRequest();
                }
                catch (e)
                {
                    try
                    {
                        xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
                    }
                    catch (e)
                    {
                        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
                    }
                }
                return xmlHttp;
            }

        </script>
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

        <div align="center"><br><br><br><br><br><br><br><br><br><br><br><br>
            <img src="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/system/header.gif">
            <hr size="0" noshade width="950">
            <table border="0" width="480" cellpadding="0" style="border-collapse: collapse" background="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/system/body-background.gif">
                <tr>
                    <td width="20" height="20" background="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/system/body-upper-left.gif">&nbsp;</td>
                    <td height="20" background="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/system/body-upper.gif">&nbsp;</td>
                    <td width="20" height="20" background="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/system/body-upper-right.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" background="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/system/body-left.gif">&nbsp;</td>
                    <td><span lang="en-us"><font face="Trebuchet MS" size="4">Souktel - System Emulator</font></span></td>
                    <td width="20" background="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/system/body-right.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" background="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/system/body-left.gif">&nbsp;</td>
                    <td><hr size="0" noshade></td>
                    <td width="20" background="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/system/body-right.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" background="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/system/body-left.gif">&nbsp;</td>
                    <td>
                        <div align="left">
                            <table border="0" width="100%" cellspacing="6" cellpadding="6" style="border-collapse: collapse">
                                <tr>
                                    <td><font face="Trebuchet MS" size="2">ShortCode</font></td>
                                </tr>
                                <tr>
                                    <td>
                                    <input id="sc" type="text" name="sc" size="30" value="37190"></td>
                                </tr>
                                <tr>
                                    <td><font face="Trebuchet MS" size="2">Mobile</font></td>
                                </tr>
                                <tr>
                                    <td>
                                    <input id="from" type="text" name="from" size="30" value="972599358296"></td>
                                </tr>
                                <tr>
                                    <td><font face="Trebuchet MS" size="2">Message/ Reply Message</font></td>
                                </tr>
                                <tr>
                                    <td>
                                        <textarea id="reply_msg" name="reply_msg" ondblclick="javascript:changeDIR();" cols="50" rows="6"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="35" valign="middle">
                                        <input type="button" value="Send/Reply" onclick="javascript:sendMessage();">
                                        &nbsp;<input type="button" value="Clear" onclick="javascript:clearMSG();">
                                        &nbsp;<font id="imgloader"></font>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <script language="javascript">
                            function clearMSG()
                            {
                                document.getElementById("reply_msg").value = "";
                            }
                            function changeDIR()
                            {
                                if(document.getElementById("reply_msg").dir == "ltr" || document.getElementById("reply_msg").dir == "undefined" || document.getElementById("reply_msg").dir == "")
                                {
                                    document.getElementById("reply_msg").dir="rtl";
                                }
                                else
                                {
                                    document.getElementById("reply_msg").dir="ltr";
                                }
                            }
                        </script>
                    </td>
                    <td width="20" background="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/system/body-right.gif">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" height="20" background="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/system/body-lower-left.gif">&nbsp;</td>
                    <td height="20" background="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/system/body-lower.gif">&nbsp;</td>
                    <td width="20" height="20" background="http://<?php echo $_SERVER['HTTP_HOST'];?>/images/system/body-lower-right.gif">&nbsp;</td>
                </tr>
            </table>
            <hr size="0" noshade width="950">
            <p align="center"><font face="Tahoma" size="2">Copyright 2009 © Souktel. All
            Rights Reserved</font></p>
        </div>

    </body>
    
</html>
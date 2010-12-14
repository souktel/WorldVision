<html dir="ltr">

    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="Content-Language" content="ar-sa">
	<title>Souktel</title>

	<style type="text/css">
	    a {
		color: #000000;
	    }

	    a:link {
		text-decoration: none;
	    }
	    a:visited {
		text-decoration: none;
	    }
	    a:hover {
		text-decoration: underline;
	    }
	    a:active {
		text-decoration: none;
	    }
	</style>

	<script LANGUAGE="JavaScript">

	    function populate(objForm,selectIndex) {
		timeA = new Date(objForm.year.options[objForm.year.selectedIndex].text, objForm.month.options[objForm.month.selectedIndex].value,1);
		timeDifference = timeA - 86400000;
		timeB = new Date(timeDifference);
		var daysInMonth = timeB.getDate();
		for (var i = 0; i < objForm.day.length; i++) {
		    objForm.day.options[0] = null;
		}
		for (var ij = 0; ij < daysInMonth; ij++) {
		    objForm.day.options[ij] = new Option(ij+1);
		}
		document.f1.day.options[0].selected = true;
	    }
	    function getYears() {

		// You can easily customize what years can be used
		var years = new Array(1997,1998,1999,2000,2001,2005)

		for (var i = 0; i < document.f1.year.length; i++) {
		    document.f1.year.options[0] = null;
		}
		timeC = new Date();
		currYear = timeC.getFullYear();
		for (var ij = 0; ij < years.length; ij++) {
		    document.f1.year.options[ij] = new Option(years[ij]);
		}
		document.f1.year.options[2].selected=true;
	    }
	    window.onLoad = getYears;

	</script>

	<script language="JavaScript" src="<?php echo $apath."templates/js/"; ?>gen_validatorv31.js" type="text/javascript"></script>
	<script language="JavaScript" src="<?php echo $apath."templates/js/"; ?>validation.js" type="text/javascript"></script>
	<script language="JavaScript" type="text/javascript">
	    function gogo(url)
	    {
		location.href = url;
	    }
	</script>
    </head>

    <body topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginwidth="0" marginheight="0">

	<div align="center">
	    &nbsp;<table border="0" width="950" cellpadding="0" style="border-collapse: collapse" background="<?php echo $param_abs_path_si;?>menu-middle-side.gif" height="45">
		<tr>
		    <td width="19" align="center" background="<?php echo $param_abs_path_si;?>menu-left-side.gif">&nbsp;</td>
		    <?php
		    for($i=0; $i<sizeof($param_header_menu); $i++) {
			if($param_header_menu[$i][3] == "1" && $param_header_menu[$i][4] != "1") {

			    ?>
		    <td align="center" width="80"><span lang="en-us"><b>
				<font face="Trebuchet MS" size="2"><a href="<?php echo $param_header_menu[$i][1];?>"><?php echo $param_header_menu[$i][0];?></a></font></b></span></td>
		    <td width="15" align="center" background="<?php echo $param_abs_path_si;?>menu-seperator.gif">&nbsp;</td>
    <?php
    }
		    }
		    ?>
		    <td align="center">
			<p align="right"><b><font face="Trebuchet MS" size="2">Welcome, <?php echo $param_session_user_name;?></font></b></p>
		    </td>
		    <td width="19" align="center" background="<?php echo $param_abs_path_si;?>menu-right-side.gif">&nbsp;</td>
		</tr>
	    </table>
	</div>
	<div align="center">
	    <br>
	</div>
	<div align="center">
	    <table border="0" width="950" cellpadding="0" style="border-collapse: collapse">
		<tr>
		    <td valign="top">

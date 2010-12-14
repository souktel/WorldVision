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
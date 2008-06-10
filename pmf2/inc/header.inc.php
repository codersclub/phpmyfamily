<?php

	function do_headers_dojo($title, $extra = '') {
		
		$config = Config::getInstance();
		if ($config->dojo) {
		$dojo = "dojo-release-1.1.0";
		$ext = " <style type=\"text/css\">
        @import \"".$dojo."/dijit/themes/tundra/tundra.css\";
        @import \"".$dojo."/dojo/dojo.css\"
    </style>
    <script type=\"text/javascript\" src=\"".$dojo."/dojo/dojo.js\"
    djConfig=\"parseOnLoad: true\"></script>
    <script language=\"JavaScript\" type=\"text/javascript\">
            dojo.require(\"dojo.parser\");
    </script>";
    		$ext .= $extra;
		}
		do_headers($title, $ext);
	}
	// function: do_headers
	// Standardize the html headers
	function do_headers($title, $extra = '') {
		global $clang;
		global $dir;
		global $charset;
		$config = Config::getInstance();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $clang; ?>" lang="<?php echo $clang; ?>" dir="<?php echo $dir; ?>">
<head>
<?php echo $extra;?>
<link rel="stylesheet" href="<?php echo $config->styledir.$_SESSION["style"]; ?>" type="text/css" />
<link rel="shortcut icon" href="images/favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="<?php echo $config->desc; ?>" />
<meta name="page-topic" content="Genealogy" />
<meta name="audience" content="All" />
<meta name="robots" content="INDEX,FOLLOW" />
<meta name="keywords" content="Genealogy phpmyfamily<?php
	$dao = getPeopleDAO();
	$surnames = $dao->getSurnames();
	foreach($surnames AS $per) {
		echo " ".$per->surname;
	}
?>" />
<title><?php echo $title; ?></title>
</head><?php
		// make titles available for later,
		$GLOBALS["title"] = $title;
	}	// end of do_headers()
	
		// function: user_opts
	// display option to users in banner
	function user_opts($person = 0) {
		global $strTrack, $strTracking, $strThisPerson, $tblprefix;
		global $strLoggedIn, $strHome, $strLogout, $strPreferences;
		global $strAdd, $strNewPerson, $strLogin, $strRecoverPwd, $strStop;
		global $strLoggedOut, $strReport, $currentRequest;

		if ($currentRequest->id != 0) {
			echo $strLoggedIn."'".$currentRequest->name."'<br />\n";
			echo "<a href=\"index.php\" class=\"hd_link\">".$strHome."</a> |";
			echo " <a href=\"passthru.php?func=logout\" class=\"hd_link\">".$strLogout."</a> |";
			echo " <a href=\"my.php\" class=\"hd_link\">".$strPreferences."</a><br />\n";
			if ($_SESSION["editable"] == "Y") {
				echo " <a href=\"report.php\" class=\"hd_link\">".$strReport."</a> |";
				echo "<a href=\"edit.php?func=add&amp;area=people\" class=\"hd_link\">".$strAdd." ".$strNewPerson."</a>";
			}
			if ($_SESSION["editable"] == "Y" && $person != 0)
				echo " | ";
			if ($person != 0) {
				$query = "SELECT * FROM ".$tblprefix."tracking WHERE email = '".$currentRequest->email."' AND person_id = ".quote_smart($person);
				$result = mysql_query($query) or die(mysql_error());
				if (mysql_num_rows($result) != 0) {
					echo "<a href=\"passthru.php?func=track&amp;action=dont&amp;person=".$person."\" class=\"hd_link\">".$strStop." ".strtolower($strTracking)." ".$strThisPerson."</a>";
				} else {
					echo "<a href=\"passthru.php?func=track&amp;action=do&amp;person=".$person."\" class=\"hd_link\">".$strTrack." ".$strThisPerson."</a>";
				}
			}
		} else {
			echo $strLoggedOut."<br />\n";
			echo "<a href=\"index.php\" class=\"hd_link\">".$strHome."</a> |";
			echo " <a href=\"my.php\" class=\"hd_link\">".$strLogin."</a> |";
			echo " <a href=\"my.php?state=lost\" class=\"hd_link\">".$strRecoverPwd."</a> <br />\n";
			if ($person != 0) {
				echo "<a href=\"track.php?person=".$person."\" class=\"hd_link\">".$strTrack." ".$strThisPerson." </a>\n";
			}
		}
	}	// end of user_opts()
?>

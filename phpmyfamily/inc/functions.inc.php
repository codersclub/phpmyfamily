<?php
	//phpmyfamily - opensource genealogy webbuilder
	//Copyright (C) 2002 - 2004  Simon E Booth (simon.booth@giric.com)

	//This program is free software; you can redistribute it and/or
	//modify it under the terms of the GNU General Public License
	//as published by the Free Software Foundation; either version 2
	//of the License, or (at your option) any later version.

	//This program is distributed in the hope that it will be useful,
	//but WITHOUT ANY WARRANTY; without even the implied warranty of
	//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	//GNU General Public License for more details.

	//You should have received a copy of the GNU General Public License
	//along with this program; if not, write to the Free Software
	//Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.

	// function: convertstamp
	// convert a timestamp into a proper date/time
	function convertstamp($origdate) {
		$year = substr($origdate, 0, 4);
		$day = substr($origdate, 4, 2);
		$month = substr($origdate, 6, 2);
		$hour = substr($origdate, 8, 2) -1;		// poor correction for server being 1hr
		$minute = substr($origdate, 10, 2);
		$sec = substr($origdate, -2);
		$stamp = mktime($hour,$minute,$sec,$day,$month,$year);
		return $stamp;
	}	// end of convertstamp()

	// function formatdate
	// allows unknown to be displayed when no details kknown
	function formatdate($origdate) {
		global $strUnknown;
		global $nulldate;

		// if there are any non-zero numbers, then display as is
		if ($origdate == $nulldate)
			return $strUnknown;
		// else return unknown
		else
			return $origdate;
	} // end of formatdate()

	// function: listpeeps
	// list all people in database that current request has access to
	function listpeeps($form, $omit = 0, $gender = "A", $default = 0, $auto = 1) {

		// declare global variables used within
		global $restrictdate;
		global $tblprefix;
		global $err_listpeeps;
		global $strOnFile;
		global $strSelect;
		global $strUnknown;

		// create the query based on the parameters
		$query = "SELECT person_id, SUBSTRING_INDEX(name, ' ', -1) AS surname, name, YEAR(date_of_birth) AS year FROM ".$tblprefix."people WHERE person_id <> '".$omit."'";

		// if the user is not logged in, only show people pre $restrictdate
		if ($_SESSION["id"] == 0)
			$query .= " AND date_of_birth < '".$restrictdate."'";

		// need the gender if listing for mother or father selection
		switch ($gender) {
			case "M":
				$query .= " AND gender = 'M'";
				break;
			case "F":
				$query .= " AND gender = 'F'";
				break;
			default:
				break;
		}

		// and sort the query
		$query .= " ORDER BY surname, name";
		$result = mysql_query($query) or die($err_listpeeps);

		// show the number of people in the list
		if ($gender == "A" && $omit == 0)
			echo mysql_num_rows($result)." ".$strOnFile."<br />\n";
		if ($gender == "A" && $omit <> 0)
			echo (mysql_num_rows($result) + 1)." ".$strOnFile."<br />\n";

		// start building the select list
		echo "<select name=\"".$form."\" size=\"1\"";
		//if needed, set form to auto submit
		if ($auto == 1)
			echo " onchange=\"this.form.submit()\"";
		echo ">\n";
		// if no person selected, show generic at top of list
		if ($default == 0)
			echo "<option value=\"0\">".$strSelect."</option>\n";
		//
		while ($row = mysql_fetch_array($result)) {
			$year = $row["year"];
			if ($year == 0)
				$year = $strUnknown;
			echo "<option value=\"".$row["person_id"]."\"";
			if ($row["person_id"] == $default)
				echo " selected=\"selected\"";
				echo ">".$row["surname"].", ".substr($row["name"], 0, strlen($row["name"]) - strlen($row["surname"]))."(b. ".$year.")</option>\n";
		}
		echo "</select>";

		// clean up after self
		mysql_free_result($result);
	}	// end of listpeeps()

	// function: stamppeeps
	// timestamp a particular person for last updated
	function stamppeeps($person) {
		// declare globals used within
		global $tblprefix;
		global $tracking;

		// update the updated column
		$query = "UPDATE ".$tblprefix."people SET updated = NOW() WHERE person_id = '".$person."'";
		$result = mysql_query($query);

		// If we allow tracking by email
		if ($tracking)
			track_person($person);
	}	// end of stamppeeps()

	// function: imagecreate_wrapper
	// see if we have latest imagecreatetrucolor available
	function imagecreate_wrapper($xsize, $ysize) {

		// checking function exists doesn't work
		// function is there, even if it isn't

		// nasty work around
		// FIX ME
		$test = imagecreatetruecolor(1,1);

		if ($test)
			return imagecreatetruecolor($xsize, $ysize);
		else
			return imagecreate($xsize, $ysize);

	}	// end of imagecreate_wrapper()

	// function: processimage
	// process an uploaded image
	function processimage() {
		// define globals used within
		global $tblprefix;
		global $err_image_insert;
		global $img_max;
		global $img_min;

		// image creation needs masses of memory
		// this is set too large! but needs to be to process a 1MB jpg!
		// if left as standard 8M, image creation fails and you get error messages and blank thumbnails
		ini_set("memory_limit", "32M");

		// bit of error checking
		if ($img_max < $img_min) {
			$temp = $img_max;
			$img_max = $img_min;
			$img_min = $temp;
		}

		// get the dimensions of the uploaded file
		$size = getimagesize($_FILES["userfile"]["tmp_name"]);

		// get the image resource from the uploaded file
		switch ($size[2]) {
			case 1:
				// it's a gif
				$incoming = @imagecreatefromgif($_FILES["userfile"]["tmp_name"]);
				break;
			case 2:
				// it's a jpeg
				$incoming = @imagecreatefromjpeg($_FILES["userfile"]["tmp_name"]);
				break;
			case 3:
				// it's a png
				$incoming = @imagecreatefrompng($_FILES["userfile"]["tmp_name"]);
				break;
			default:
				// don't know what it is so just bail-out
				return false;
				break;
		}

		if (!$incoming)
			return false;

		// work out the ratio of width to height
		$ratio = $size[0] / $size[1];

		// create the thumbnail
		$thumbw = 100;
		$thumbh = 100;
		$thumb = imagecreate_wrapper($thumbw, $thumbh);
		if (!$thumb)
			return false;

		$background = imagecolorallocate($thumb, 147, 150, 147);
		imagefill($thumb, 0, 0, $background);

		// do different things depending on orientation of image
		if ($ratio < 1) {		// higher than wide
			if ($size[1] > $img_max) {
				// create a file with maximum height
				$file = imagecreate_wrapper($img_max * $ratio, $img_max);
				imagecopyresized($file, $incoming, 0, 0, 0, 0, ($img_max * $ratio), $img_max, $size[0], $size[1]);
			} elseif ($size[1] < $img_min) {
				// create a file with minimum height
				$file = imagecreate_wrapper($img_min * $ratio, $img_min);
				imagecopyresized($file, $incoming, 0, 0, 0, 0, ($img_min * $ratio), $img_min, $size[0], $size[1]);
			} else {
				// create a file the same size
				$file = imagecreate_wrapper($size[0], $size[1]);
				imagecopyresized($file, $incoming, 0, 0, 0, 0, $size[0], $size[1], $size[0], $size[1]);
			}

			// workout border for thumbnail
			$border = ($thumbw - $thumbw * $ratio) / 2;
			imagecopyresized($thumb, $incoming, $border, 0, 0, 0, ($thumbw * $ratio), $thumbh, $size[0], $size[1]);
		}
		else {					// wider than high
			if ($size[0] > $img_max) {
				// create a file with maximum width
				$file = imagecreate_wrapper($img_max, $img_max / $ratio);
				imagecopyresized($file, $incoming, 0, 0, 0, 0, $img_max, ($img_max / $ratio), $size[0], $size[1]);
			} elseif ($size[0] < $img_min) {
				// create a file with minimum width
				$file = imagecreate_wrapper($img_min, $img_min / $ratio);
				imagecopyresized($file, $incoming, 0, 0, 0, 0, $img_min, ($img_min / $ratio), $size[0], $size[1]);
			} else {
				// create a file the same size
				$file = imagecreate_wrapper($size[0], $size[1]);
				imagecopyresized($file, $incoming, 0, 0, 0, 0, $size[0], $size[1], $size[0], $size[1]);
			}

			// workout border for thumbnail
			$border = ($thumbh - $thumbh / $ratio) / 2;
			imagecopyresized($thumb, $incoming, 0, $border, 0, 0, $thumbw, ($thumbh / $ratio), $size[0], $size[1]);
		}

		if (!$file)
			return false;;

		$iquery = "INSERT INTO ".$tblprefix."images (person_id, title, date, description) VALUES ('".$_REQUEST["person"]."', '".htmlspecialchars($_POST["frmTitle"], ENT_QUOTES)."', '".$_POST["frmDate"]."', '".htmlspecialchars($_POST["frmDesc"], ENT_QUOTES)."')";;
		$iresult = mysql_query($iquery) or die($err_image_insert);
		$image = str_pad(mysql_insert_id(), 5, 0, STR_PAD_LEFT);

		// set as interlaced and save to paths
		imageinterlace($thumb, 1);
		imagejpeg($thumb, "images/tn_".$image.".jpg", 100);
		imageinterlace($file, 1);
		imagejpeg($file, "images/".$image.".jpg", 95);

		return true;
	}	// end of processimage();

	// function: list_enums
	// Produce a select list of an enum column
	function list_enums($table, $col, $name, $value = 0) {
		global $err_list_enums;

		// get an array of the values in the column
		$query = "SHOW COLUMNS FROM ".$table." LIKE '".$col."'";
		$result = mysql_query($query) or die($err_list_enums);

		// do some processing ?
		while ($row = mysql_fetch_array($result)) {
			$enum        = str_replace('enum(', '', $row['Type']);
			$enum        = ereg_replace('\\)$', '', $enum);
			$enum        = explode('\',\'', substr($enum, 1, -1));
			$enum_cnt    = count($enum);
			$default	 = $row["Default"];
		}

		// decide if we want column default, or a value passed as arg
		if (func_num_args() == 4)
			$select = $value;			// we've been given a value to select
		else
			$select = $default;			// just select the column default value

		// do the output
		echo "<select name=".$name." size=1>";
		for ($j = 0; $j < $enum_cnt; $j++) {
			$enum_atom = str_replace('\'\'', '\'', str_replace('\\\\', '\\', $enum[$j]));
			echo '<option value="' . urlencode($enum_atom) . '"';
			if ($enum_atom == $select)
					echo ' selected="selected"';
			echo '>' . htmlspecialchars($enum_atom) . '</option>' . "\n";
		}
		echo "</select>";

		// clean up
		mysql_free_result($result);
	}	// end of list_enums()

	// function: list_censuses
	// Provide a list of censuses
	function list_censuses($name) {
		global $tblprefix;
		global $err_list_census;

		$cquery = "SELECT * FROM ".$tblprefix."census_years WHERE available = 'Y' ORDER BY country, year";
		$cresult = mysql_query($cquery) or die($err_list_census);

		// do the output
		echo "<select name=".$name." size=1>\n";
		while ($crow = mysql_fetch_array($cresult)) {
			echo "<option value=\"".$crow["census_id"]."\">".$crow["year"]." / ".$crow["country"]."</option>\n";
		}
		echo "</select>\n";
		mysql_free_result($cresult);
	}	// end of list_censuses()

	// function: add_quotes
	// detect if magic_quotes is off, and quote a string if needed
	function add_quotes($str) {

		// chck to see if quotes are on
		if (get_magic_quotes_gpc())
			return $str;
		// and add slashes if not
		else
			return addslashes($str);
	}	// end of add_quotes()

	// function: mysql_connect_wrapper
	// use _pconnect if poss, if not invisibly choose _connect
	function mysql_connect_wrapper($server, $username, $password) {

		// see if we have _pconnect available
		if (function_exists("mysql_pconnect"))
			return mysql_pconnect($server, $username, $password);
		else
			return mysql_connect($server, $username, $password);
	}	// end of mysql-connect_wrapper()

	// function: show_gallery
	// show the image gallery for a person
	function show_gallery($person, $dest = "people") {
		global $tblprefix;
		global $strDelete;
		global $strImage;
		global $strNoImages;

		// only run query if user permitted
		$iquery = "SELECT * FROM ".$tblprefix."images WHERE person_id = '".$person."' ORDER BY date";
		$iresult = mysql_query($iquery) or die($err_images);
		if (mysql_num_rows($iresult) == 0) {
			echo "\t".$strNoImages;
		}
		else {
?>
	<table width="100%">
<?php
				$rows = ceil(mysql_num_rows($iresult) / 5);
				$current = 0;
				$currentrow = 1;
					while ($irow = mysql_fetch_array($iresult)) {
						// start a new row every 5 images
						if ($current == 0 || fmod($current, 5) == 0) {
?>
		<tr>
<?php
						}
						// alternate background colours
						if ($current == 0 || fmod($current, 2) == 0)
							$class = "tbl_odd";
						else
							$class = "tbl_even";
						// display image thumbnail
?>
			<td width="20%" class="<?php echo $class; ?>" align="center" valign="top"><a href="image.php?image=<?php echo $irow["image_id"]; ?>"><img src="images/tn_<?php echo $irow["image_id"]; ?>.jpg" width="100" height="100" border="0" title="<?php echo $irow["description"]; ?>" alt="<?php echo $irow["description"]; ?>" /></a><br /><a href="image.php?image=<?php echo $irow["image_id"]; ?>"><?php echo $irow["title"]; ?></a><?php if($_SESSION["id"] != 0) { ?><br /><a href="JavaScript:confirm_delete('<?php echo $irow["title"]; ?>', '<?php echo strtolower($strImage); ?>', 'passthru.php?func=delete&amp;area=image&amp;person=<?php echo $person; ?>&amp;image=<?php echo $irow["image_id"]; ?>&amp;dest=<?php echo $dest; ?>')" class="delete"><?php echo $strDelete; ?></a><?php } ?></td>
<?php
						// close each row every 5 images
						if ($current <> 0 && fmod($current + 1, 5) == 0) {
							$currentrow++;
?>
		</tr>
<?php
						}
						$current++;
					}
				mysql_free_result($iresult);
					// make sure that rows and tables are padded and closed properly
					while ($currentrow <= $rows) {
?>
			<td width="20%"></td>
<?php
						if ($current <> 0 && fmod($current + 1, 5) == 0) {
							$currentrow++;
?>
		</tr>
<?php
						}
						$current++;
					}
?>
	</table>
<?php
			}


	}	// end of show_gallery()

	// function: track_person
	// send an email to everybody tracking an individual
	function track_person($person) {
		global $trackemail;
		global $tblprefix;
		global $err_person;
		global $eTrackSubject;
		global $eTrackBodyTop;
		global $eTrackBodyBottom;
		global $absurl;

		$tquery = "SELECT ".$tblprefix."people.person_id, name, email FROM ".$tblprefix."people, ".$tblprefix."tracking WHERE ".$tblprefix."people.person_id = ".$tblprefix."tracking.person_id AND ".$tblprefix."people.person_id = '".$person."' AND `key` = '' AND expires = '0000-00-00 00:00:00'";
		$tresult = mysql_query($tquery) or die($err_person);
		while ($trow = mysql_fetch_array($tresult)) {
			$headers = "Content-type: text/plain; charset=iso-8859-1\r\n";
			$headers .= "From: <".$trackemail.">\r\n";
			$headers .= "X-Mailer: PHP/" . phpversion();
			$subject = str_replace("$1", $trow["name"], $eTrackSubject);
			$body = str_replace("$1", $trow["name"], $eTrackBodyTop);
			$body = str_replace("$2", $absurl, $body);
			$body .= $absurl."people.php?person=".$trow["person_id"]."\n\n";
			$body .= $eTrackBodyBottom;
			$body .= $absurl."track.php?person=".$trow["person_id"]."&amp;action=unsub&amp;email=".$trow["email"]."&amp;name=".urlencode($trow["name"])."\n";

			mail($trow["email"], $subject, $body, $headers);
		}
		mysql_free_result($tresult);
	}	// eod of track_person()

	// function: do_headers
	// Standardize the html headers
	function do_headers($title) {
		global $clang;
		global $dir;
		global $style;
		global $charset;
		global $desc;
		global $tblprefix;
		global $err_keywords;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $clang; ?>" lang="<?php echo $clang; ?>" dir="<?php echo $dir; ?>">
<head>
<link rel="stylesheet" href="<?php echo $style; ?>" type="text/css" />
<link rel="shortcut icon" href="images/favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $charset; ?>" />
<meta name="description" content="<?php echo $desc; ?>" />
<meta name="page-topic" content="Genealogy" />
<meta name="audience" content="All" />
<meta name="author" content="Simon E Booth" />
<meta name="copyright" content="2002-2003 Simon E Booth" />
<meta name="robots" content="INDEX,FOLLOW" />
<meta name="keywords" content="Genealogy phpmyfamily<?php
	$fname = "SELECT SUBSTRING_INDEX(name, ' ', -1) AS surname, COUNT(*) as count FROM ".$tblprefix."people GROUP BY surname ORDER BY count DESC LIMIT 0,16";
	$rname = mysql_query($fname) or die($err_keywords);
	if (mysql_num_rows($rname) <> 0) {
		while ($row = mysql_fetch_array($rname))
			echo " ".$row["surname"];
	}
?>" />
<title><?php echo $title; ?></title>
</head>
<body>
<?php
		// make titles available for later,
		$GLOBALS["title"] = $title;
	}	// end of do_headers()

	// eof
?>

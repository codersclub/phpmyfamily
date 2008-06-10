<?php


function get_options_edit() {
	$config = Config::getInstance();
	ob_start();
	liststyles("defaultstyle", $config->defaultstyle);
	$styles = ob_get_contents();
	ob_end_clean();
	
	$ret = '<form method="POST" action="modules/admin/process.php">
    <table>
    <tr><th>email</th><th>mailto</th><th>desc</th><th>styledir</th><th>defaultstyle</th>
 <th>lang</th><th>timing</th><th>gedcom</th><th></th></tr>
    <tr>
<td><input type="text" name="email" value="'. $config->email.'"></input></td>
<td><input type="checkbox" name="mailto" '.($config->mailto?'checked="checked"':'').'></input></td>
<td><input type="text" name="desc" value="'. $config->desc.'"></input></td>
<td><input type="text" name="styledir" value="'. $config->styledir.'"></input></td>
<td>'.$styles.'</td>
<td>'.listlangs('lang',$config->lang).'</td>
<td><input type="checkbox" name="timing" '. ($config->timing?'checked="checked"':'').'></input></td>
<td><input type="checkbox" name="gedcom" '. ($config->gedcom?'checked="checked"':'').'></input></td><td></td>
</tr>
<tr><th>dynamicrestict</th><th>restrictyears</th><th>restrictdate</th>
 <th>tracking</th><th>trackemail</th><th>absurl</th>
 <th>bbtracking</th><th>img_max</th><th>img_min</th></tr>
<tr>
<td><select name="restricttype">
<option value="0"';
 if ($config->restricttype == 0) { $ret .= ' selected="selected"';}
$ret .= '>restrictdate</option>\n';
$ret .= '<option value="1"';
 if ($config->restricttype == 1) { $ret .= ' selected="selected"';}
$ret .= '>restrictyears</option>\n';
$ret .='</select>
</td>
<td><input type="text" name="restrictyears" value="'. $config->restrictyears.'"></input></td>
<td><input type="text" name="restrictdate" value="'. $config->restrictdate.'"></input></td>
<td><input type="checkbox" name="tracking" '. ($config->tracking?'checked="checked"':'').'></input></td>
<td><input type="text" name="trackemail" value="'. $config->trackemail.'"></input></td>
<td><input type="text" name="absurl" value="'. $config->absurl.'"></input></td>
<td><input type="checkbox" name="bbtracking" '. ($config->bbtracking?'checked="checked"':'').'></input></td>
<td><input type="text" name="img_max" value="'. $config->img_max.'"></input></td>
<td><input type="text" name="img_min" value="'. $config->img_min.'"></input></td>
</tr>
<tr><th>layout</th><th>gmapskey</th><th>gmapshost</th>
 <th></th><th></th><th></th>
 <th></th><th></th><th></th></tr>
<tr>
<td><select name="layout">
<option value="0"';
 if ($config->layout == 0) { $ret .= ' selected="selected"';}
$ret .= '>classic</option>\n';
$ret .= '<option value="2"';
 if ($config->layout == 2) { $ret .= ' selected="selected"';}
$ret .= '>dojo tabs</option>\n';
$ret .= '<option value="3"';
 if ($config->layout == 3) { $ret .= ' selected="selected"';}
$ret .= '>dojo panes</option>\n';
$ret .='</select>
</td>
<td><input type="text" name="gmapskey" value="'. $config->gmapskey.'"></input></td>
<td><input type="text" name="gmapshost" value="'. $config->gmapshost.'"></input></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td></tr>
<tr><td></td><td><input type="submit" name="<?php echo $strEdit; ?>" /></td><td colspan="15"></td></tr>
    </table>
    </form>';

return($ret);
}
?>

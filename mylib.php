<?php
$style = 'style="font-family: Verdana; font-size: 16pt"';
$alpha = array ('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'á', 'à', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'í', 'ì', 'ỉ', 'ĩ', 'ị', 'ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'đ');
$ALPHA = array ('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ', 'É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ', 'Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị', 'Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ', 'Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự', 'Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ', 'Đ');

function ht_open ($title = 'notitle') {
	global $style;
	return "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" /><title>$title</title></head><body $style>";
}

function ht_close () {
	return '</body></html>';
}

function formHt_open ($title = 'notitle', $method='POST', $action='') {
	global $style;
	$action = ($action=='') ? $GLOBALS ['PHP_SELF'] : $action ;
	return "<html><head><title>$title</title></head><form method = '$method' action='$action' $style>";
}

function formHt_close() {
	return '</form></html>';
}

function textbox ($value='', $name='textbox', $size='', $maxlength='') {	
	global $style;
	$size = ($size=='') ? '' : " size='$size'";
	$maxlength = ($maxlength=='') ? '' : " maxlength='$maxlength'";
	return "<input type='textbox' name='$name' value='$value'{$size}{$maxlength} $style />";
}

function radio ($value=' ', $name='rb', $currentval='', $submit='') {
	$checked = ($currentval==$value) ? ' checked' : '';
	$submit = ($submit=='') ? '' : ' onClick=\'submit()\'';
	return "<input type='radio' name='$name' value='$value'{$checked}{$submit} />";
}

function checkbox ($name='cb', $value='1') {
	return "<input type='checkbox' name='$name' value='$value'>";
}

function cmd ($value='Ok', $name='cmd') {
	global $style;
	return "<input type='submit' name='$name' value='$value' $style /> ";
}

function tblOpen ($width='100%', $border='0', $cellspacing='0', $cellpadding='1' ) {
	return "<table width='$width' border='$border' cellspacing ='$cellspacing' cellpadding='$cellpadding' $style>";
}

function tblClose() {
	return '</table>';
}

function td ($content='&nbsp;', $align='', $width='', $colspan='', $rowspan='', $valign='') {
	$align= ($align=='') ? '' : " align='$align'";
	$valign= ($valign=='') ? '' : " valign='$valign'";
	$width= ($width=='') ? '' : " width='$width'";
	$colspan= ($colspan=='') ? '' : " colspan='$colspan'";
	$rowspan= ($rowspan=='') ? '' : " rowspan='$rowspan'";
	return "<td{$width}{$align}{$valign}{$colspan}{$rowspan}>$content</td>";
}

function tr ($content, $align='', $bgcolor='') {
	$align= ($align=='') ? '' : " align='$align'";
	$bgcolor= ($bgcolor=='') ? '' : " bgcolor='$bgcolor'";
	return "<tr{$align}{$bgcolor}>$content</tr>";
}

function stdName ($astring) {
	//Chuẩn hóa xâu theo định dạng tên địa danh: '  hỒ   cHÍ  mInH   ' =>'Hồ Chí Minh'
	global $alpha, $ALPHA;
	$retval = '';
	$ci = 0;
	$len = mb_strlen ($astring, 'UTF-8');
	while ($ci < $len) {
		while (($ci<$len) && (mb_substr ($astring, $ci, 1, 'UTF-8')==' '))
			$ci++;
		$temp = mb_substr ($astring, $ci, 1, 'UTF-8');
		$retval .= str_replace ($alpha, $ALPHA, $temp);				
		$ci++;
		while (($ci<$len) && (($temp=mb_substr ($astring, $ci, 1, 'UTF-8'))!=' ')) {
			$retval .= str_replace ($ALPHA, $alpha, $temp);
			$ci++;
		}
		$retval .= ($ci < $len) ? ' ' : '';
	}
	return $retval;
}

function listbox ($tblname, $name='lb', $value='ma', $disp='name', $where='', $current='', $onChange='') {
	global $style;
	$where = ($where=='') ? '' : " where $where";
	$onChange = ($onChange=='')? '' : ' onChange=submit()';
	$sql = "select $value as ma, $disp as ten from $tblname $where order by $value";
	$retval = "<select name='$name' $onChange $style>";
	$rst = mysql_query ($sql) or die(mysql_error());
	while ($row = mysql_fetch_array($rst)) {
		$selected = ($row['ma']==$current) ? ' selected' : '';
		$retval .= "<option value='{$row['ma']}'{$selected}>{$row['ten']}</option>";	
	}
	return $retval . '</select>';
}





?>
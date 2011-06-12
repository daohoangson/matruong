<?php

include('mylib.php');

// setup db
mysql_connect('127.0.0.1', 'root', 'mrpaint4321') or die('Không kết nối được db');
mysql_select_db('k53cc') or die('Fuck select db');
mysql_query('
	CREATE TABLE IF NOT EXISTS `truong` (
		`ma` varchar(255) primary key,
		`ten` text,
		`dia_diem` text
	);
');
mysql_query('
	CREATE TABLE IF NOT EXISTS `dia_diem` (
		`ma_dia_diem` varchar(255) primary key,
		`ten_dia_diem` text
	);
');
// setup db - finished

// setup variables
$where = '';
$ten = '';
$ma = '';
$dia_diem = '';
$existing = false;
$errorMessage = false;
// setup variables - finished

// process actions
if (!empty($_POST)) {
	$action = '';
	
	if (!empty($_POST['edit'])) {
		// process edit request
		// load the data from database and display it for modifications
		$action = 'edit';
		$tmp = $_POST['edit'];
		
		$tmp2 = mysql_query('SELECT * FROM `truong` WHERE ma = \'' . mysql_escape_string($tmp) . '\'');
		if (empty($tmp2)) {
			$errorMessage = 'Không tìm thấy dữ liệu!';
		} else {
			// update the existing variable (to be used later)
			$existing = mysql_fetch_array($tmp2);
			
			$ma = $existing['ma'];
			$ten = $existing['ten'];
			$dia_diem = $existing['dia_diem'];
		}
	}
	
	if (!empty($_POST['action'])) {
		// find the actions via POST data
		$tmp = array_keys($_POST['action']);
		$action = array_pop($tmp);
		
		$ma = $_POST['ma'];
		$ten = $_POST['ten'];
		$dia_diem = $_POST['dia_diem'];

		switch ($action) {
			case 'go':
				if (empty($ma) OR empty($ten) OR empty($dia_diem)) {
					$errorMessage = 'Bạn phải nhập đầy đủ thông tin: Mã, Tên, Địa điểm!';
				} else {
					// validated, start updating db
					
					if (empty($existing)) {
						// this is an add request
						mysql_query("INSERT INTO `truong` SET 
								`ma` = '" . mysql_escape_string($ma) . "', 
								`ten` = '" . mysql_escape_string($ten) . "',
								`dia_diem` = '" . mysql_escape_string($dia_diem) . "'
						") or die('Không thể cập nhật dữ liệu: ' . mysql_error());
					} else {
						// this is an update request
						mysql_query("UPDATE `truong` SET 
								`ma` = '" . mysql_escape_string($ma) . "', 
								`ten` = '" . mysql_escape_string($ten) . "',
								`dia_diem` = '" . mysql_escape_string($dia_diem) . "'
								WHERE `ma` = '$existing[ma]'
						") or die('Không thể cập nhật dữ liệu: ' . mysql_error());
					}

					// reset the variables
					$ma = '';
					$ten = '';
					$dia_diem = '';
				}
			break;
			case 'delete':
				// delete 1 or more rows
				if (empty($_POST['ids'])) {
					$errorMessage = 'Bạn phải chọn một hoặc nhiều bản ghi để xóa!';
				} else {
					$ids = $_POST['ids'];
					$idsSafe = array();
					foreach ($ids as $id) {
						$idsSafe[] = "'" . mysql_escape_string($id) . "'";
					}
					
					mysql_query('DELETE FROM `truong` WHERE `ma` IN (' . implode(', ', $idsSafe) . ')');
				}
			break;
			case 'search':
				// search for data...
				if (!empty($ma)) {
					$where[] = "`ma` LIKE '%" . mysql_escape_string($ma) . "%'";
				}
				if (!empty($ten)) {
					$where[] = "`ten` LIKE '%" . mysql_escape_string($ten) . "%'";
				}
				if (!empty($dia_diem)) {
					$where[] = "`dia_diem` = '" . mysql_escape_string($dia_diem) . "'";
				}
			break;
		}
	}
}

echo formHt_open('Quản lý trường');

echo '<h2>Chương trình quản lý Trường Đại học ở Việt Nam</h2><hr/>';

echo tblOpen('60%');
echo tr(td('Tên', 'left', '30%') . td(textbox($ten, 'ten', 40, 30)));
echo tr(td('Mã', 'left') . td(textbox($ma, 'ma', 10, 5)));
echo tr(td('Địa điểm', 'left')  . td(listbox('dia_diem', 'dia_diem', 'ma_dia_diem', 'ten_dia_diem', '', $dia_diem)));
echo tr(
	td(cmd('Nhập', 'action[go]')
	. cmd('Xóa', 'action[delete]')
	. cmd('Tìm kiếm', 'action[search]')
	, 'center', '100%', 2)
);
echo tblClose();

if (!empty($errorMessage)) {
	echo '<div style="color: red; font-weight: bold">', $errorMessage, '</div>';
}

echo tblOpen('90%', 1);
echo tr(td('STT') . td('Xóa', '10%') . td('Sửa ' . radio('', 'edit', $ma, 1), '10%') . td('Mã') . td('Tên') . td('Địa điểm'));

$result = mysql_query('SELECT * FROM `truong` ' . (empty($where) ? '' : ('WHERE ' . implode(' AND ', $where))) . ' ORDER BY `ten` ASC');
$stt = 0;
while ($row = mysql_fetch_array($result)) {
	$stt++;
	
	echo tr(
		td($stt)
		. td(checkbox('ids[]', $row['ma']))
		. td(radio($row['ma'], 'edit', $ma, 1))
		. td($row['ma'])
		. td($row['ten'])
		. td($row['dia_diem'])
	);
}

echo tblClose();

echo formHt_close();
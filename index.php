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

echo formHt_open('Quản lý trường');

echo '<h2>Chương trình quản lý Trường Đại học ở Việt Nam</h2><hr/>';

echo tblOpen('60%');
echo tr(td('Tên', 'left', '30%') . td(textbox($ten, 'ten', 40, 30)));
echo tr(td('Mã', 'left') . td(textbox($ma, 'ma', 10, 5)));
echo tr(td('Địa điểm', 'left')  . td(listbox('dia_diem', 'dia_diem', 'ma_dia_diem', 'ten_dia_diem', '', $dia_diem)));
echo tr(td(cmd('Nhập') . cmd('Xóa') . cmd('Tìm kiếm'), 'center', '100%', 2));
echo tblClose();

if (!empty($errorMessage)) {
	echo '<div style="color: red; font-weight: bold">', $errorMessage, '</div>';
}

echo tblOpen('90%', 1);
echo tr(td('STT') . td('Xóa', '10%') . td('Sửa', '10%') . td('Mã') . td('Tên') . td('Địa điểm'));

$result = mysql_query('SELECT * FROM `truong` ' . $where . ' ORDER BY `ma` ASC');
$stt = 0;
while ($row = mysql_fetch_array($result)) {
	$stt++;
	
	echo tr(
		td($stt)
		. td(checkbox('delete[' . $row['ma'] . ']'))
		. td(radio($row['ma'], 'edit', $ma, 1))
		. td($row['ma'])
		. td($row['ten'])
		. td($row['dia_diem'])
	);
}

echo tblClose();

echo formHt_close();
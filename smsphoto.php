<?php
session_start();
if($_SESSION['smsfilecount'] < 11) {
    $_SESSION['smsfilecount'] = $_SESSION['smsfilecount'] + 1;
}
if( isset( $_POST['my_file_upload'] ) ){  
	// ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно

	$uploaddir = 'C:\xampp\htdocs\dw\tmp'; // . - текущая папка где находится submit.php

	// cоздадим папку если её нет
	if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

	$files      = $_FILES; // полученные файлы
	$done_files = array();

	// переместим файлы из временной директории в указанную
	foreach( $files as $file ){
		$file_name = $file['name'];

		if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
			$done_files[] = $file_name;
		}
	}

	if($_SESSION['smsfilecount']>10) {
        echo 'falses';
    }
    else {
        print($file_name);
    }
}

?>
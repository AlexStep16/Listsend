<?php
session_start();
if( isset( $_POST['my_file_upload'] ) ){  
	// ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно

	$uploaddir = 'C:\xampp\htdocs\dw\tmp'; // . - текущая папка где находится submit.php

	// cоздадим папку если её нет
	if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

	$files      = $_FILES; // полученные файлы
	$done_files = array();

	// переместим файлы из временной директории в указанную
	foreach( $files as $file ){
		$file_name = $_SESSION['filecount'].$file['name'];

		if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
			$done_files[] = $file_name;
		}
	}
    if(isset($file_name)) {
        if($_SESSION['filecount'] < 11) {
            if(!isset($_SESSION['imgdel'])) {
                $_SESSION['filecount'] = $_SESSION['filecount'] + 1;
            }
            else {
                unset($_SESSION['imgdel']);
            }
        }
        if($_SESSION['filecount'] > 10) {
            print('falses');
        }
        else {
                echo $file_name;
        }
    }
}

?>
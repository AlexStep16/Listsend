<?php
session_start();
if( isset( $_POST['my_file_upload'] ) ){  
	// ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно

	$uploaddir = 'C:\xampp\htdocs\dw\noteimage'; // . - текущая папка где находится submit.php

	// cоздадим папку если её нет
	if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );
    $_GET['noteid'] = (int)$_GET['noteid'];
    $_GET['noteid'] = strip_tags($_GET['noteid']);
	$files      = $_FILES; // полученные файлы
	$done_files = array();
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    if($_SESSION['filecount'] >= 10) {
        print('falses');
    }
    else {
        // переместим файлы из временной директории в указанную
        $_SESSION['filecount'] = $_SESSION['filecount'] + 1;
        foreach( $files as $file ){
            for($j = 0;$j<10;$j++) {
                if(is_file('noteimage/'.$j.md5($_GET['noteid']).'.jpg')) {

                }
                else {
                    $file_name = $j.md5($_GET['noteid']).'.jpg';
                    break;
                }
            }
            if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
                $done_files[] = $file_name;
            }
            else {
                print('falses');
            }
        }
        echo $file_name;
    }
}

?>
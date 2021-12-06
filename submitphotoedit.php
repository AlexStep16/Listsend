<?php
session_start();
if( isset( $_POST['my_file_upload'] ) ){  
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
	$uploaddir = 'C:\xampp\htdocs\dw\noteimage';
	$uploaddir2 = 'C:\xampp\htdocs\dw\noteimageedit';
    $_GET['id'] = (int)$_GET['id'];
    $_GET['id'] = strip_tags($_GET['id']);
    $_GET['id'] = htmlspecialchars($_GET['id']);
    $_GET['id'] = addslashes($_GET['id']);
	// cоздадим папку если её нет
	if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

	$files      = $_FILES; // полученные файлы
	$done_files = array();

	// переместим файлы из временной директории в указанную
	foreach( $files as $file ){

                $file_name = md5($_GET['id'].$emailfor).'.jpg';

        move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ;

			print 'noteimage/'.$file_name.'?r'.rand();
	}
}

?>
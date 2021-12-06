<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_GET['noteid'] = (int)$_GET['noteid'];
    $_GET['noteid'] = strip_tags($_GET['noteid']);
    $_GET['id'] = (int)$_GET['id'];
    $_GET['id'] = strip_tags($_GET['id']);
    $_SESSION['filecount'] = $_SESSION['filecount'] - 1;
    unlink('noteimage/'.$_GET['id'].md5($_GET['noteid']).'.jpg');
    print('noteimage/'.$_GET['id'].md5($_GET['noteid']).'.jpg');
?>
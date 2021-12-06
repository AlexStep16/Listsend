<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    date_default_timezone_set('UTC');
    $date = time() - 3600;
    $_POST['suptext'] = htmlspecialchars($_POST['suptext']);
    $_POST['suptext'] = addslashes($_POST['suptext']);
    $_POST['supname'] = htmlspecialchars($_POST['supname']);
    $_POST['supname'] = addslashes($_POST['supname']);
    $_POST['supemail'] = htmlspecialchars($_POST['supemail']);
    $_POST['supemail'] = addslashes($_POST['supemail']);
    if($_POST['supname'] == 2) {
        $_POST['supname'] = 'Не войти в аккаунт';
    }
    if($_POST['supname'] == 1) {
        $_POST['supname'] = 'Ошибки в ленте';
    }
    if($_POST['supname'] == 3) {
        $_POST['supname'] = 'Проблемы с блогом';
    }
    if($_POST['supname'] == 4) {
        $_POST['supname'] = 'Подозрение на взлом';
    }
    if($_POST['supname'] == 5) {
        $_POST['supname'] = 'Другое';
    }
    $_POST['suptext'] = 'Проблема: '.$_POST['supname'].'<br>E-Mail: '.$_POST['supemail'].'<br>Текст проблемы: '.$_POST['suptext'];
    $query = "INSERT into messages(fromem,toem,content,date,login,readmessage) VALUES('support','ListSend','".$_POST['suptext']."','".$date."','ListSend','1')";
    $result = $conn->query($query);
    if (!$result) die ($conn->error);
    print $post;
?>
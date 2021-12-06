<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_GET['top'] = strip_tags($_GET['top']);
    $_GET['top'] = htmlspecialchars($_GET['top']);
    $_GET['top'] = addslashes($_GET['top']);
    $_GET['left'] = strip_tags($_GET['left']);
    $_GET['left'] = htmlspecialchars($_GET['left']);
    $_GET['left'] = addslashes($_GET['left']);
    $query = "UPDATE design SET toppx='".$_GET['top']."',leftpx='".$_GET['left']."' WHERE login='".$_SESSION['login']."'";
    $result = $conn->query($query);
    if (!$result) die ($conn->error);
?>
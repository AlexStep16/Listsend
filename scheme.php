<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_GET['id'] = (int)$_GET['id'];
    $_GET['id'] = strip_tags($_GET['id']);
    $_GET['id'] = htmlspecialchars($_GET['id']);
    $_GET['id'] = addslashes($_GET['id']);
    $query = "UPDATE design SET scheme='".$_GET['id']."' WHERE login='".$_SESSION['login']."'";
    $result = $conn->query($query);
    if (!$result) die ($conn->error);
    $query = "UPDATE design SET backtrans='no',toppx='0',leftpx='0',toppxh1='0',leftpxh1='0',toppxp='0',leftpxp='0' WHERE login='".$_SESSION['login']."'";
    $result = $conn->query($query);
    if (!$result) die ($conn->error);
?>
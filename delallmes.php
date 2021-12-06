<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_GET['login'] = strip_tags($_GET['login']);
    $_GET['login'] = htmlspecialchars($_GET['login']);
    $_GET['login'] = addslashes($_GET['login']);
    $query = "DELETE from messages WHERE fromem='".$_SESSION['login']."' AND toem='".$_GET['login']."' AND login='".$_SESSION['login']."' OR toem='".$_SESSION['login']."'  AND fromem='".$_GET['login']."' AND login='".$_SESSION['login']."'"; 
    $result = $conn->query($query);
    if (!$result) die ($conn->error);
?>
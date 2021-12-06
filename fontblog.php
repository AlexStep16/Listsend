<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_GET['font'] = strip_tags($_GET['font']);
    $_GET['font'] = htmlspecialchars($_GET['font']);
    $_GET['font'] = addslashes($_GET['font']);
    $query = "UPDATE design SET font='".$_GET['font']."' WHERE login='".$_SESSION['login']."'";
    $result = $conn->query($query);
    if (!$result) die ($conn->error);
    print '"'.$_GET['font'].'"';
?>
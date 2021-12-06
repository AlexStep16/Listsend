<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_GET['color'] = strip_tags($_GET['color']);
    $_GET['color'] = htmlspecialchars($_GET['color']);
    $_GET['color'] = addslashes($_GET['color']);
    $query = "UPDATE design SET fontcolor='".$_GET['color']."' WHERE login='".$_SESSION['login']."'";
    $result = $conn->query($query);
    if (!$result) die ($conn->error);
    print '#'.$_GET['color'];
?>
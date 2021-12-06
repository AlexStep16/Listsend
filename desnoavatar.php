<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_GET['bool'] = strip_tags($_GET['bool']);
    $_GET['bool'] = htmlspecialchars($_GET['bool']);
    $_GET['bool'] = addslashes($_GET['bool']);
    $query = "UPDATE design SET checkavatar='".$_GET['bool']."' WHERE login='".$_SESSION['login']."'";
    $result = $conn->query($query);
    if (!$result) die ($conn->error);
?>
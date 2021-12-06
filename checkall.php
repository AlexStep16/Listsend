<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $query = "UPDATE messages SET readmessage='0' WHERE fromem='".$_SESSION['login']."' AND login='".$_SESSION['login']."' OR toem='".$_SESSION['login']."' AND login='".$_SESSION['login']."'"; 
    $result = $conn->query($query);
    if (!$result) die ($conn->error);
?>
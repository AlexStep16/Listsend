<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_GET['login'] = strip_tags($_GET['login']);
    $_GET['login'] = htmlspecialchars($_GET['login']);
    $_GET['login'] = addslashes($_GET['login']);
    $query = "SELECT * from blocked WHERE login='".$_SESSION['login']."' AND who='".$_GET['login']."'"; 
    $result = $conn->query($query);
    $rows = $result->num_rows;
    if($rows == 0) {
         $query = "INSERT into blocked(login,who) VALUES('".$_SESSION['login']."','".$_GET['login']."')";
    }
    else {
        $query = "DELETE from blocked WHERE login='".$_SESSION['login']."' AND who='".$_GET['login']."'";
    }
    $result = $conn->query($query);
    if (!$result) die ($conn->error);
?>
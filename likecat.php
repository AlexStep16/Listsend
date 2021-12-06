<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_GET['cat'] = strip_tags($_GET['cat']);
    $_GET['cat'] = addslashes($_GET['cat']);
    $query = "SELECT * from category WHERE login='".$_SESSION['login']."' AND category='".$_GET['cat']."'";
    $result = $conn->query($query);
    $rows = $result->num_rows;
    if($rows == 1) {
        $query = "DELETE from category WHERE login='".$_SESSION['login']."' AND category='".$_GET['cat']."'";
        $result = $conn->query($query);
    }   
    elseif($rows == 0) {
        $query = "INSERT into category(login,category) VALUES('".$_SESSION['login']."','".$_GET['cat']."')";
        $result = $conn->query($query);
    }
    $query = "SELECT * from category WHERE login='".$_SESSION['login']."'";
    $result = $conn->query($query);
    $rows = $result->num_rows;
    if($rows>2) {
        print('true');
    }
    if (!$result) die ($conn->error);
?>
<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_GET['id'] = strip_tags($_GET['id']);
    $_GET['id'] = htmlspecialchars($_GET['id']);
    $query = "SELECT * from news WHERE id='".$_GET['id']."'";
    $result = $conn->query($query);
    if($result->fetch_array()['comments'] == 'true') {
        print('yes');
    }
    if (!$result) die ($conn->error);
?>
<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_POST['description2'] = htmlspecialchars($_POST['description2']);
    $post = $_POST['description2'];
    $_POST['description2'] = strip_tags($_POST['description2']);
    $_POST['description2'] = addslashes($_POST['description2']);
    $query = "UPDATE design SET description2='".$_POST['description2']."' WHERE login='".$_SESSION['login']."'";
    $result = $conn->query($query);
    if (!$result) die ($conn->error);
    print $post;
?>
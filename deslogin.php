<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_POST['deslogin'] = htmlspecialchars($_POST['deslogin']);
    $post = $_POST['deslogin'];
    $_POST['deslogin'] = strip_tags($_POST['deslogin']);
    $_POST['deslogin'] = addslashes($_POST['deslogin']);
    $query = "UPDATE design SET blogname='".$_POST['deslogin']."' WHERE login='".$_SESSION['login']."'";
    $result = $conn->query($query);
    if (!$result) die ($conn->error);
    print $post;
?>
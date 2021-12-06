<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_POST['description'] = htmlspecialchars($_POST['description']);
    $post = $_POST['description'];
    $_POST['description'] = strip_tags($_POST['description']);
    $_POST['description'] = addslashes($_POST['description']);
    $query = "UPDATE design SET description='".$_POST['description']."' WHERE login='".$_SESSION['login']."'";
    $result = $conn->query($query);
    if (!$result) die ($conn->error);
    print $post;
?>
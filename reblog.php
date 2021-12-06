<?php
    session_start();
    date_default_timezone_set("UTC");
    $datenotif = time();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_GET['id'] = (int)$_GET['id'];
    $_GET['id'] = strip_tags($_GET['id']);
    $_GET['id'] = htmlspecialchars($_GET['id']);
    $_GET['id'] = addslashes($_GET['id']);
    $query = "SELECT * from news WHERE id='".$_GET['id']."'"; 
    $result = $conn->query($query);
    $result->data_seek(0);
    $name = $result->fetch_array()['name'];
    $result->data_seek(0);
    $sod = $result->fetch_array()['sod'];
    $result->data_seek(0);
    $login = $result->fetch_array()['login'];
    $result->data_seek(0);
    $factdate = $result->fetch_array()['factdate'];
    $result->data_seek(0);
    $tags = $result->fetch_array()['tags'];
    $result->data_seek(0);
    $diarid = $result->fetch_array()['diar'];
    $result->data_seek(0);
    $category = $result->fetch_array()['category'];
    $result->data_seek(0);
    $email = $result->fetch_array()['email'];
    $query = "INSERT into news(login,email,name,sod,factdate,tags,diar,realid,category,reblog) VALUES('".$login."','".$email."','".$name."','".$sod."','".$factdate."','".$tags."','".$diarid."','".$_GET['id']."','".$category."','".$_SESSION['login']."')";
    $result = $conn->query($query);
    $query = "INSERT into notification(login,what,who,reading,date,noteid) VALUES('".$login."','repost','".$_SESSION['login']."','1','".$datenotif."','".$_GET['id']."')"; 
    $result = $conn->query($query);
    
?>
<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_GET['id'] = (int)$_GET['id'];
    $_GET['id'] = strip_tags($_GET['id']);
    $_GET['id'] = htmlspecialchars($_GET['id']);
    $_GET['id'] = addslashes($_GET['id']);
    if($_GET['id'] == 1) {
        $query = 'SELECT * from users WHERE email!="'.$_SESSION['email'].'"';
        $result = $conn->query($query);
        $rows = $result->num_rows;
        $not = 0;
        for($j = 0; $j<$rows;$j++) {
            $result->data_seek($j);
            if($result->fetch_array()['email'] == $_POST['email']) {
                $not = 1;
            }
        }
        if($_POST['email'] == $_SESSION['email']) {
            $not = 2; 
        }
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $not = 1;
        }
        print($not);
    }

    if($_GET['id'] == 2) {
        $query = 'SELECT * from users WHERE login!="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $rows = $result->num_rows;
        $not = 0;
        for($j = 0; $j<$rows;$j++) {
            $result->data_seek($j);
            if($result->fetch_array()['login'] == $_POST['login']) {
                $not = 1;
            }
        }
        if($_POST['login'] == $_SESSION['login']) {
            $not = 2; 
        }
        print($not);
    }

    if($_GET['id'] == 3) {
        $not = 0;
        if(file_exists($_POST['sitename'].'.php') || strlen($_POST['sitename'])<4) {
            $not = 1;
        }
        print($not);
    }
    if($_GET['id'] == 4) {
        $not = 0;
        if(strlen($_POST['pass'])<=5) {
            $not = 1;
        }
        print($not);
    }
    if($_GET['id'] == 5) {
        $not = 0;
        if($_POST['pass'] != $_POST['confpass']) {
            $not = 1;
        }
        print($not);
    }
?>
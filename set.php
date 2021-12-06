<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    if($_GET['id'] == '1') {
        $_POST['email'] = htmlspecialchars($_POST['email']);
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) !== false) {
            $query = 'UPDATE users set email="'.$_POST['email'].'" WHERE email="'.$_SESSION['email'].'"';
            $result = $conn->query($query);
            $_SESSION['email'] = $_POST['email'];
            $emailforstar = str_replace('.', '', $_SESSION['email']);
            $emailforstar = str_replace('@', '', $emailforstar);
            $_POST['email'] = addslashes($_POST['email']);
            $query = 'UPDATE news set email="'.$emailforstar.'" WHERE email="'.$emailfor.'"';
            $result = $conn->query($query);
            $query = 'UPDATE comments set email="'.$emailforstar.'" WHERE email="'.$emailfor.'"';
            $result = $conn->query($query);
            $query = 'UPDATE subscribes set emailsubscriber="'.$emailforstar.'" WHERE emailsubscriber="'.$emailfor.'"';
            $result = $conn->query($query);
            $query = 'UPDATE likes set email="'.$emailforstar.'" WHERE email="'.$emailfor.'"';
            $result = $conn->query($query);
         rename('avatar/'.md5('avatar'.$emailfor).'.jpg','avatar/'.md5('avatar'.$emailforstar).'.jpg');
        }
        
    }
    if($_GET['id'] == '2') {
        $_POST['login'] = htmlspecialchars($_POST['login']);
        $_POST['login'] = addslashes($_POST['login']);
        $query = 'UPDATE users set login="'.$_POST['login'].'" WHERE login="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $query = 'UPDATE blocked set login="'.$_POST['login'].'" WHERE login="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $query = 'UPDATE blocked set who="'.$_POST['login'].'" WHERE who="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $query = 'UPDATE category set login="'.$_POST['login'].'" WHERE login="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $query = 'UPDATE comments set login="'.$_POST['login'].'" WHERE login="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $query = 'UPDATE design set login="'.$_POST['login'].'" WHERE login="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $query = 'UPDATE dislike set login="'.$_POST['login'].'" WHERE login="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $query = 'UPDATE dislike set who="'.$_POST['login'].'" WHERE who="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $query = 'UPDATE dontdisturb set who="'.$_POST['login'].'" WHERE who="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $query = 'UPDATE dontdisturb set login="'.$_POST['login'].'" WHERE login="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $query = 'UPDATE message set fromem="'.$_POST['login'].'" WHERE fromem="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $query = 'UPDATE message set toem="'.$_POST['login'].'" WHERE toem="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $query = 'UPDATE message set login="'.$_POST['login'].'" WHERE login="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $query = 'UPDATE news set login="'.$_POST['login'].'" WHERE login="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $query = 'UPDATE notification set login="'.$_POST['login'].'" WHERE login="'.$_SESSION['login'].'"';
        $query = 'UPDATE notification set who="'.$_POST['login'].'" WHERE who="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        rename($_SESSION['login'].'.php',$_POST['login'].'.php');
        $_SESSION['login'] = $_POST['login'];
    }
    if($_GET['id'] == '3') {
        $_POST['sitename'] = strip_tags($_POST['sitename']);
        $_POST['sitename'] = addslashes($_POST['sitename']);
        $query = 'SELECT * from design WHERE login="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        if($result->fetch_array()['sitename']!='') {
            $result->data_seek(0);
            unlink($result->fetch_array()['sitename'].'.php');
        }
        $query = 'UPDATE design SET sitename="'.$_POST['sitename'].'" WHERE login="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        if(is_file($_POST['sitename'].'.php')) {
            
        }
        else {
            $f_hdl = fopen($_POST['sitename'].'.php', 'w');
            $file = 'demo.php';
            copy($file,$_POST['sitename'].'.php');
        }
    }
    if($_GET['id'] == '4') {
        $_POST['gmtselect'] = strip_tags($_POST['gmtselect']);
        $_POST['gmtselect'] = addslashes($_POST['gmtselect']);
        $query = 'UPDATE design SET time="'.$_POST['gmtselect'].'" WHERE login="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
        $_SESSION['timezone'] = $_POST['gmtselect'];
    }
    if($_GET['id'] == '5') {
        $_POST['pass'] = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $query = 'UPDATE users SET password="'.$_POST['pass'].'" WHERE login="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
    }
    if($_GET['id'] == '6') {
        $_POST['push'] = strip_tags($_POST['push']);
        $_POST['push'] = addslashes($_POST['push']);
        $query = 'UPDATE design SET push="'.$_POST['push'].'" WHERE login="'.$_SESSION['login'].'"';
        $result = $conn->query($query);
    }
?>
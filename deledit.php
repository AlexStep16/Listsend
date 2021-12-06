<?php
session_start();
if(isset($_GET['id'])) {
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            if ($conn->connect_error) die($conn->connect_error);
            $emailfor = str_replace('.', '', $_SESSION['email']);
            $emailfor = str_replace('@', '', $emailfor);
            $_GET['id'] = (int)$_GET['id'];
            $_GET['id'] = strip_tags($_GET['id']);
            $_GET['id'] = htmlspecialchars($_GET['id']);
            $_GET['id'] = addslashes($_GET['id']);
            unlink('noteimage/'.md5($_GET['id']).'.jpg'); 
            $result = $conn->query($query);
            if (!$result) die ($conn->error);
}
?>
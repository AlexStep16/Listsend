<?php
session_start();
if(isset($_GET['id'])) {
            $_SESSION['morediar'] = $_SESSION['morediar'] - 1;
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            if ($conn->connect_error) die($conn->connect_error);
            $emailfor = str_replace('.', '', $_SESSION['email']);
            $emailfor = str_replace('@', '', $emailfor);
            $_GET['id'] = (int)$_GET['id'];
            $_GET['id'] = strip_tags($_GET['id']);
            $_GET['id'] = htmlspecialchars($_GET['id']);
            $_GET['id'] = addslashes($_GET['id']);
            $query = "DELETE from diarsnote WHERE id='".$_GET['id']."' AND email='".$emailfor."'"; 
            $result = $conn->query($query);
            if (!$result) die ($conn->error);
}
?>
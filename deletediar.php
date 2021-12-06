<?php
session_start();
if(isset($_GET['post'])) {
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            if ($conn->connect_error) die($conn->connect_error);
            $emailfor = str_replace('.', '', $_SESSION['email']);
            $emailfor = str_replace('@', '', $emailfor);
            $_GET['post'] = strip_tags($_GET['post']);
            $_GET['post'] = htmlspecialchars($_GET['post']);
            $_GET['post'] = addslashes($_GET['post']);
            $query = "DELETE from diars WHERE id='".$_GET['post']."' AND email='".$emailfor."'"; 
            $result = $conn->query($query);
            if (!$result) die ($conn->error);
}
?>
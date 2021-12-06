<?php
session_start();
if(isset($_GET['id'])) {
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            $del = 0;
            $_GET['id'] = (int)$_GET['id'];
            $_GET['id'] = strip_tags($_GET['id']);
            $_GET['id'] = htmlspecialchars($_GET['id']);
            $_GET['id'] = addslashes($_GET['id']);
            if ($conn->connect_error) die($conn->connect_error);
            $emailfor = str_replace('.', '', $_SESSION['email']);
            $emailfor = str_replace('@', '', $emailfor);
            $query = "SELECT * FROM users WHERE email='".$_SESSION['email']."'"; 
            $result = $conn->query($query);
            $result->data_seek(0); 
            $id = $result->fetch_array()['id'];
            $query = "SELECT * from subscribes WHERE userid='".$_GET['id']."'"; 
            $result = $conn->query($query);
            $count = $result->num_rows;
            $count = $count + 1;
            $query = "INSERT into subscribes(userid,subscriberid,emailsubscriber,count) VALUES('".$_GET['id']."','".$id."','".$emailfor."','".$count."')"; 
            $result = $conn->query($query);
            $query = "UPDATE subscribes SET count='".$count."' WHERE userid='".$_GET['id']."'";
            $result = $conn->query($query);
}   

if(isset($_GET['iddel'])) {
            $emailfor = str_replace('.', '', $_SESSION['email']);
            $emailfor = str_replace('@', '', $emailfor);
            $_GET['iddel'] = (int)$_GET['iddel'];
            $_GET['iddel'] = strip_tags($_GET['iddel']);
            $_GET['iddel'] = htmlspecialchars($_GET['iddel']);
            $_GET['iddel'] = addslashes($_GET['iddel']);
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            if ($conn->connect_error) die($conn->connect_error);
            $query = "DELETE from subscribes WHERE userid='".$_GET['iddel']."' AND emailsubscriber='".$emailfor."'"; 
            $result = $conn->query($query);
            $query = "SELECT * from subscribes WHERE userid='".$_GET['iddel']."'"; 
            $result = $conn->query($query);
            $count = $result->num_rows;
            $query = "UPDATE subscribes SET count='".$count."' WHERE userid='".$_GET['iddel']."'";
            $result = $conn->query($query);
}   
?>
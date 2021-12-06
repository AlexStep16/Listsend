<?php
session_start();
function likegram($str) {
                if($str % 10 == 0) {
                    return 'Лайков';
                }
                if($str % 10 == 1) {
                    return 'Лайк';
                }
                if($str % 10 > 1 && $str % 10 < 5) {
                    return 'Лайка';
                }
                if($str % 10 > 5 && $str % 10 < 10) {
                    return 'Лайков';
                }
                if($str / 10 >9 && $str / 10 < 20) {
                    return 'Лайков';
                }
            }
if(isset($_GET['id'])) {
            date_default_timezone_set("UTC");
            $date = time();
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            $del = 0;
            if ($conn->connect_error) die($conn->connect_error);
            $emailfor = str_replace('.', '', $_SESSION['email']);
            $emailfor = str_replace('@', '', $emailfor);
            $_GET['id'] = (int)$_GET['id'];
            $_GET['id'] = strip_tags($_GET['id']);
            $_GET['id'] = htmlspecialchars($_GET['id']);
            $_GET['id'] = addslashes($_GET['id']);
            $query = "SELECT * FROM news WHERE id='".$_GET['id']."'"; 
            $result = $conn->query($query);
            $result->data_seek(0); 
            $login = $result->fetch_array()['login'];
            $query = "SELECT * FROM likes WHERE noteid='".$_GET['id']."'"; 
            $result = $conn->query($query);
            if (!$result) die ($conn->error);
            $rows = $result->num_rows;
            for($j = 0;$j < $rows;$j++) {
                $result->data_seek($j); 
                if($emailfor == $result->fetch_array()['email']) {
                    $del = 1;
                }
            }
            if($del == 0) {
                $query = "INSERT into notification(login,what,who,reading,date,noteid) VALUES('".$login."','like','".$_SESSION['login']."','1','".$date."','".$_GET['id']."')"; 
                $result = $conn->query($query);
                $query = "INSERT into likes(noteid,email) VALUES('".$_GET['id']."','".$emailfor."')"; 
            }
            else {
                $query = "DELETE from notification WHERE login='".$login."' AND what='like' AND who='".$_SESSION['login']."' AND date='".$date."' AND noteid='".$_GET['id']."'"; 
                $result = $conn->query($query);
                $query = "DELETE from likes WHERE email='".$emailfor."' AND noteid='".$_GET['id']."'"; 
            } 
            $result = $conn->query($query);
            if (!$result) die ($conn->error);
            $query = "SELECT * FROM likes WHERE noteid='".$_GET['id']."'"; 
            $result = $conn->query($query);
            if (!$result) die ($conn->error);
            $rows = $result->num_rows;
            print('<span class="likefcount'.$_GET['id'].'">'.$rows.'</span> '.likegram($rows).'');
}   

if(isset($_GET['comment'])) {
            date_default_timezone_set("Europe/Moscow");
            $date = date('d.m.Y H:i:s');
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            $del = 0;
            if ($conn->connect_error) die($conn->connect_error);
            $emailfor = str_replace('.', '', $_SESSION['email']);
            $emailfor = str_replace('@', '', $emailfor);
            $query = "SELECT * FROM likes WHERE noteid='com".$_GET['comment']."'"; 
            $result = $conn->query($query);
            if (!$result) die ($conn->error);
            $rows = $result->num_rows;
            for($j = 0;$j < $rows;$j++) {
                $result->data_seek($j); 
                if($emailfor == $result->fetch_array()['email']) {
                    $del = 1;
                }
            }
            if($del == 0) {
                $query = "INSERT into likes(noteid,email) VALUES('com".$_GET['comment']."','".$emailfor."')"; 
            }
            else {
                $query = "DELETE from likes WHERE email='".$emailfor."' AND noteid='com".$_GET['comment']."'"; 
            } 
            $result = $conn->query($query);
            if (!$result) die ($conn->error);
            $query = "SELECT * FROM likes WHERE noteid='com".$_GET['comment']."'"; 
            $result = $conn->query($query);
            if (!$result) die ($conn->error);
            $rows = $result->num_rows;
            print($rows);
}   
?>
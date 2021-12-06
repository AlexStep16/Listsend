<?php
session_start();
if(isset($_GET['id'])) {
            $_GET['id'] = (int)$_GET['id'];
            $_GET['id'] = strip_tags($_GET['id']);
            $_GET['id'] = htmlspecialchars($_GET['id']);
            $_GET['id'] = addslashes($_GET['id']);
            $more = explode(' ',$_SESSION['more']);
            $mores = $more[1] - 1;
            $_SESSION['more'] = $more[0].' '.$mores;
            $more = explode(' ',$_SESSION['morelikes']);
            $mores = $more[1] - 1;
            $_SESSION['morelikes'] = $more[0].' '.$mores;
            $more = explode(' ',$_SESSION['moresub']);
            $mores = $more[1] - 1;
            $_SESSION['moresub'] = $more[0].' '.$mores;
            $more = explode(' ',$_SESSION['boolmynotemore']);
            $mores = $more[1] - 1;
            $_SESSION['boolmynotemore'] = $more[0].' '.$mores;
            if(isset($_SESSION['find'])) {
                if($_SESSION['boolfind'] != 0) {
                    $tag = explode(' ',$_SESSION['find']);
                    $many = $tag[1]-1;
                    $_SESSION['find'] = $tag[0].' '.$many;
                }
            }
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            if ($conn->connect_error) die($conn->connect_error);
            $emailfor = str_replace('.', '', $_SESSION['email']);
            $emailfor = str_replace('@', '', $emailfor);
            $query = "SELECT * from news WHERE id='".$_GET['id']."' and email='".$emailfor."' or id='".$_GET['id']."' and reblog='".$_SESSION['login']."'"; 
            $result = $conn->query($query);
            $rows = $result->num_rows;
            if($rows == 1) {
                $query = "DELETE from news WHERE id='".$_GET['id']."' and email='".$emailfor."' or id='".$_GET['id']."' and reblog='".$_SESSION['login']."'"; 
                $result = $conn->query($query);
                $query = "DELETE from likes WHERE noteid='".$_GET['id']."'"; 
                $result = $conn->query($query);
                if (!$result) die ($conn->error);
            }
    }
?>
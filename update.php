<?php 
    session_start();
    function finddate($date) {
        $new = substr($date, 0, 2);
        $nowday = date('d');
        if($new == $nowday) {
            $arr = explode(' ',  $date);
            array_shift($arr);
            return 'Сегодня '.implode(' ', $arr);
        }
        $yesterday = date('d', time() - 86400);
        if($new == $yesterday) {
            $arr = explode(' ',  $date);
            array_shift($arr);
            return 'Вчера '.implode(' ', $arr);
        }
    }
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);   
    $_GET['id'] = (int)$_GET['id'];
    $_GET['id'] = strip_tags($_GET['id']);
    $_GET['id'] = htmlspecialchars($_GET['id']);
    $_GET['id'] = addslashes($_GET['id']);
    $notmy = 0;
    $query = "SELECT * from messages WHERE id='".$_GET['id']."' order by id DESC"; 
    $result = $conn->query($query);
    $result->data_seek(0);
    $login = $result->fetch_array()['fromem'];
    $result->data_seek(0);
    if($login == $_SESSION['login']) { 
        $login = $result->fetch_array()['toem']; 
        $notmy = 0;
    }
    else {
        $notmy = 1;
    }
    $query = "SELECT * from messages WHERE fromem='".$_SESSION['login']."' AND toem='".$login."' AND login='".$_SESSION['login']."' AND readmessage='1' OR toem='".$_SESSION['login']."' AND fromem='".$login."' AND login='".$_SESSION['login']."' AND readmessage='1' order by id DESC"; 
    $result = $conn->query($query);
    $rowsread = $result->num_rows;
    $query = "SELECT * from messages WHERE fromem='".$_SESSION['login']."' AND toem='".$login."' AND login='".$_SESSION['login']."' OR toem='".$_SESSION['login']."' AND fromem='".$login."' AND login='".$_SESSION['login']."' order by id DESC"; 
    $result = $conn->query($query);
    $rows = $result->num_rows;
    $result->data_seek(0);
    $content =  $result->fetch_array()['content'];
    $result->data_seek(0);
    $date = finddate($result->fetch_array()['date']);
    $result->data_seek(0);
    $readmessage = $result->fetch_array()['readmessage'];
    $result->data_seek(0);
    $mylogin = $result->fetch_array()['fromem'];
    if($mylogin != $_SESSION['login']) {
        $notmy = 1;
    }
    if($_GET['rows'] != $rows) {
        if($notmy == 1) {
            if($readmessage != 0) {
                $content = '<span style="font-weight:bold;">'.$content.'</span>';
                print('<span class="date">'.$date.'</span><span class="you">Собеседник:</span> '.$content.'<span id="rows'.$_GET['id'].'" style="display:none;">'.$rows.'</span><span class="countread">'.$rowsread.'</span>'); 
            }
            else {
                print('<span class="date">'.$date.'</span><span class="you">Собеседник:</span> '.$content.'<span id="rows'.$_GET['id'].'" style="display:none;">'.$rows.'</span>');
            }
        }
        else {
            print('<span class="date">'.$date.'</span><span class="you">Вы:</span> '.$content.'<span id="rows'.$_GET['id'].'" style="display:none;">'.$rows.'</span>');
        }
    }
    else {
        print($_GET['rows']);
    }
?>
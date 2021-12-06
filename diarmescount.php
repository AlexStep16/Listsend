<?php 
    session_start();
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);              
    $notmy = 0;
    $query = "SELECT * from dontdisturb WHERE login='".$_SESSION['login']."'"; 
    $result = $conn->query($query);
    $rows = $result->num_rows;
    $stop = ' ';
    $stop2 = ' ';
    for($j=0; $j<$rows; $j++) {
        $result->data_seek($j);
        if($result->fetch_array()['login'] == $_SESSION['login']) {
            $result->data_seek($j);
            $stop = $stop." AND fromem!='".$result->fetch_array()['who']."'";
        }
    }
    $query = "SELECT * from messages WHERE fromem='".$_SESSION['login']."' AND login='".$_SESSION['login']."' AND readmessage='1'".$stop." OR toem='".$_SESSION['login']."' AND login='".$_SESSION['login']."' AND readmessage='1'".$stop." order by id DESC";
    $result = $conn->query($query);
    $rows = $result->num_rows;
    print($rows);
?>
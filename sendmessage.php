<?php
    session_start();
    date_default_timezone_set('UTC');
    function whatdate($date) {
        
    if($date == '11') {
        return 'ноя';
    }
    if($date == '12') {
        return 'дек';
    }
    if($date == '01') {
        return 'янв';
    }
    if($date == '02') {
        return 'фев';
    }
    if($date == '03') {
        return 'мар';
    }
    if($date == '04') {
        return 'апр';
    }
    if($date == '05') {
        return 'мая';
    }
    if($date == '06') {
        return 'июн';
    }
    if($date == '07') {
        return 'июл';
    }
    if($date == '08') {
        return 'авг';
    }
    if($date == '09') {
        return 'сен';
    }
    if($date == '10') {
        return 'окт';
    }
    
}
    function finddate($date) {
        $new = date('d',$date);
        $nowday = date('d',time() + $_SESSION['timezone']*3600);
        $yesterday = date('d', time() - 86400 + $_SESSION['timezone']*3600);
        if($new == $nowday) {
            return 'Сегодня в '.date('H:i',$date + $_SESSION['timezone']*3600);
        }
        elseif($new == $yesterday) {
            return 'Вчера в '.date('H:i',$date + $_SESSION['timezone']*3600);
        }
        else {
            $offset = $_SESSION['timezone']; 
            $date = $date + ($offset * 3600);
            $date = date("d.m.Y H:i:s", $date);
            $string = explode('.', $date); 
            $month = whatdate($string[1]);
            $trip = explode(' ',$date);
            $str2 = explode(' ',$string[2]);
            return $string[0].' '.$month.' '.$str2[0].' в '.substr($trip[1],0,-3);
        }
    }
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    date_default_timezone_set("UTC");
    $date = time() - 3600;
    $_GET['id'] = (int)$_GET['id'];
    $_GET['id'] = strip_tags($_GET['id']);
    $_GET['id'] = htmlspecialchars($_GET['id']);
    $_GET['id'] = addslashes($_GET['id']);
    $_POST['message'] = htmlspecialchars($_POST['message']);
    $message2 = $_POST['message'];
    $_POST['message'] = addslashes($_POST['message']);
    $datefall = 'Только что';
    $query = "SELECT * FROM users WHERE login='".$_SESSION['login']."'"; 
    $result = $conn->query($query);
    $result->data_seek(0);
    $myid = $result->fetch_array()['id'];
    $query = "SELECT * FROM users WHERE id='".$_GET['id']."'"; 
    $result = $conn->query($query);
    $result->data_seek(0);
    $login = $result->fetch_array()['login'];
    $query = "SELECT * from blocked WHERE who='".$_SESSION['login']."' AND login='".$login."'"; 
    $result = $conn->query($query);
    $stoped1 = $result->num_rows;
    if($stoped1 == 0) {
    $query = "INSERT into messages(fromem,toem,content,date,login) VALUES('".$_SESSION['login']."','".$login."','".$_POST['message']."','".$date."','".$_SESSION['login']."')"; 
    $result = $conn->query($query);
    $query = "INSERT into messages(fromem,toem,content,date,login,readmessage) VALUES('".$_SESSION['login']."','".$login."','".$_POST['message']."','".$date."','".$login."','1')"; 
    $result = $conn->query($query);
    $query = "SELECT * FROM messages WHERE fromem='".$_SESSION['login']."' AND toem='".$login."' AND login='".$_SESSION['login']."' AND date='".$date."' AND content='".$_POST['message']."'"; 
    $result = $conn->query($query);
    $result->data_seek(0);
    $down = 0;
    $id = $result->fetch_array()['id'];
    $count = explode('***',$_GET['smsphotoname']);
    $countrow = count($count);
    $divimg = '';
    for($j=0; $j<$countrow; $j++) {
        if(is_file('tmp/'.$count[$j])) {
            copy('tmp/'.$count[$j],'smsphoto/'.$j.md5($id.$myid.$_GET['id']).'.jpg');
            unlink('tmp/'.$count[$j]);
            $down = 1;
            $divimg = $divimg.'<img src="smsphoto/'.$j.md5($id.$myid.$_GET['id']).'.jpg" style="max-width:350px;margin-top:5px;border-radius:3px;"><br>';
        }
    }    
    if($message2 == "") {
        $message2 = $message2.$divimg; 
    }
    else {
        $message2 = $message2.'<br>'.$divimg; 
    }
    
    if(is_file('avatar/'.md5('avatar'.$emailfor).'.jpg')) {
        $myimg = 'avatar/'.md5('avatar'.$emailfor).'.jpg';
    }
    else {
        $myimg = 'avatar/123123.jpg';
    }
    print('
    <div class="sms" id="sms'.$id.'">
    <div class="delete"><img src="https://png.icons8.com/windows/20/666666/trash.png" onclick="deletesms(\''.$id.'\')"></div>
        <div class="smscontent">
            <span class="smsdate">'.$datefall.'</span><span class="smslogin">'.$_SESSION['login'].'</span><br>
            <span class="smstext">'.$message2.'</span>
        </div>
        <div class="smsimg"><div style="width:45px;height:45px;background:url('.$myimg.');background-size:cover;background-position:center;display:inline-block;border-radius:100px;"></div></div>
    </div>');
    if($down == 1) {
            print('<style> #sms'.$id.' .delete{bottom:-5px !important;} </style>');
        }
    }
?>

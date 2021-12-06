<?php
    session_start();
    date_default_timezone_set('UTC');
    $login = $_GET['log'];
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
    $query = "SELECT * FROM users WHERE login='".$_GET['log']."'"; 
    $result = $conn->query($query);
    $result->data_seek(0);
    $email = $result->fetch_array()['email'];
    $email = str_replace('.', '', $email);
    $email = str_replace('@', '', $email);
    if(is_file('avatar/'.md5('avatar'.$email).'.jpg')) {
        $img = 'avatar/'.md5('avatar'.$email).'.jpg';
    }
    else {
        $img = 'avatar/123123.jpg';
    }
    if(is_file('avatar/'.md5('avatar'.$emailfor).'.jpg')) {
        $myimg = 'avatar/'.md5('avatar'.$emailfor).'.jpg';
    }
    else {
        $myimg = 'avatar/123123.jpg';
    }
?>

<?php
    $query = "SELECT * FROM messages WHERE fromem='".$_SESSION['login']."' AND toem='".$login."' AND login='".$_SESSION['login']."' OR fromem='".$login."' AND toem='".$_SESSION['login']."' AND login='".$_SESSION['login']."' order by id ASC"; 
    $result = $conn->query($query);
    $rows = $result->num_rows;
    $stet = $rows - $_SESSION['moremes'];
    $stet1 = $rows - $_SESSION['moremes'] - 20;
    $_SESSION['moremes'] = $_SESSION['moremes'] + 20;
    if($rows > $_SESSION['moremes']) {
        print('<div onclick="download(\''.$login.'\')" class="showmore">Показать больше</div>');
    }
    for($j=0;$j<$rows;$j++) {
        if($j > $stet1 && $j < $stet) {
        $result->data_seek($j);
        $fromem = $result->fetch_array()['fromem'];
        $result->data_seek($j);
        $toem = $result->fetch_array()['toem'];
        $query3 = "SELECT * FROM users where login='".$fromem."'"; 
        $result3 = $conn->query($query3);
        $fromemid = $result3->fetch_array()['id'];
        $query3 = "SELECT * FROM users where login='".$toem."'"; 
        $result3 = $conn->query($query3);
        $toemid = $result3->fetch_array()['id'];
        $result->data_seek($j);
        $content = $result->fetch_array()['content'];
        $result->data_seek($j);
        $id = $result->fetch_array()['id'];
        $result->data_seek($j);
        $down = 0;
        $date = finddate($result->fetch_array()['date']);
        if($fromem == $_SESSION['login']) {
            $img2='';
            for($l=0;$l<10;$l++) {
                if(is_file('smsphoto/'.$l.md5($id.$fromemid.$toemid).'.jpg')) {
                    $down = 1;
                    $img2 = $img2.'<img src="smsphoto/'.$l.md5($id.$fromemid.$toemid).'.jpg" style="max-width:350px;margin-top:5px;border-radius:3px;"><br>';
                }
            }
            if($content == "") {
                $content = $content.$img2; 
            }
            else {
                $content = $content.'<br>'.$img2; 
            }
            print('
                <div class="sms" id="sms'.$id.'">
                <div class="delete"><img src="https://png.icons8.com/windows/20/666666/trash.png" onclick="deletesms(\''.$id.'\')"></div>
                    <div class="smscontent">
                        <span class="smsdate">'.$date.'</span><span class="smslogin">'.$_SESSION['login'].'</span><br>
                        <span class="smstext">'.$content.'</span>
                    </div>
                    <div class="smsimg"><div style="width:45px;height:45px;background:url('.$myimg.');background-size:cover;background-position:center;display:inline-block;border-radius:100px;"></div></div>
                </div>');
        }
        else {
            $img2='';
            $idyou = $id-1;
            for($l=0;$l<10;$l++) {
                if(is_file('smsphoto/'.$l.md5($idyou.$fromemid.$toemid).'.jpg')) {
                    $down = 1;
                    $img2 = $img2.'<img src="smsphoto/'.$l.md5($idyou.$fromemid.$toemid).'.jpg" style="max-width:350px;margin-top:5px;border-radius:3px;"><br>';
                }
            }
            if($content == "") {
                $content = $content.$img2;
            }
            else {
                $content = $content.'<br>'.$img2;
            }
            print('
                <div class="sms" style="text-align:left;" id="sms'.$id.'">
                    <div class="smsimg"><div style="width:45px;height:45px;background:url('.$img.');background-size:cover;background-position:center;display:inline-block;border-radius:100px;"></div></div>
                    <div class="smscontent" style="text-align:left;margin-right: 0;margin-left: 5px;">
                        <span class="smslogin">'.$fromem.'</span><span class="smsdate"  style="padding-left: 10px;">'.$date.'</span><br>
                        <span class="smstext">'.$content.'</span>
                    </div>
                    <div class="delete" style="right:0;left:5px;"><img src="https://png.icons8.com/windows/20/666666/trash.png" onclick="deletesms(\''.$id.'\')"></div>
                </div>');
        }
        if($down == 1) {
            print('<style> #sms'.$id.' .delete{bottom:-5px !important;} </style>');
        }
        }
    }
?>
 <script type="text/javascript" src="message.js"></script>
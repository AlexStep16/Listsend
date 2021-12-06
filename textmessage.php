<?php
    session_start();
    $_SESSION['smsfilecount'] = 0;
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
    $_GET['id'] = (int)$_GET['id'];
    $_GET['id'] = strip_tags($_GET['id']);
    $_GET['id'] = htmlspecialchars($_GET['id']);
    $_GET['id'] = addslashes($_GET['id']);
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $query = "SELECT * FROM users WHERE id='".$_GET['id']."'"; 
    $result = $conn->query($query);
    $result->data_seek(0);
    $login = $result->fetch_array()['login'];
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
<div id="messageheader">
        <h1 class="messageh1"><span class="setting"><img src="https://png.icons8.com/windows/25/666666/more.png" onclick="openmenu()"></span><?php print('<img src="'.$img.'" width="30" height="30" class="messageimg"> <span class="messageheaderlogin">'.$login.'</span>'); ?></h1><span class="backto"><div class="help helpba">Вернуться назад</div><img src="https://png.icons8.com/windows/25/666666/back.png" onclick="back()"></span><hr>
</div>
<div class="contentbox">
    <div class="menusms">
        <ul>
            <li onclick="showconfirm()"><img src="https://png.icons8.com/windows/20/ffffff/trash.png"> <span>Удалить все сообщения</span></li>
            <?php
                $query = "SELECT * from dontdisturb WHERE login='".$_SESSION['login']."'"; 
                $result = $conn->query($query);
                $rows = $result->num_rows;
                $stop = 0;
                for($j=0; $j<$rows; $j++) {
                    $result->data_seek($j);
                    if($result->fetch_array()['who'] == $login) {
                        $stop = 1;
                    }
                }
                if($stop != 1) {
                    print('<li class="change" onclick="disturb()"><img src="icobell.ico" width="20" height="20"> <span>Отключить уведомления</span></li>');
                }
                else {
                    print('<li class="change" onclick="disturb()"><img src="https://png.icons8.com/windows/20/ffffff/appointment-reminders.png" width="20" height="20"> <span>Включить уведомления</span></li>');
                }
                $query = "SELECT * from blocked WHERE who='".$_SESSION['login']."' AND login='".$login."'"; 
                $result = $conn->query($query);
                $stoped1 = $result->num_rows;
                $query = "SELECT * from blocked WHERE login='".$_SESSION['login']."'"; 
                $result = $conn->query($query);
                $rows = $result->num_rows;
                $stoped = 0;
                for($j=0; $j<$rows; $j++) {
                    $result->data_seek($j);
                    if($result->fetch_array()['who'] == $login) {
                        $stoped = 1;
                    }
                }
                if($stoped != 1) {
                    print('<li class="block" onclick="block()"><img src="https://png.icons8.com/windows/20/ffffff/no-entry.png"> <span>Заблокировать пользователя</span></li>');
                }
                else {
                    print('<li class="block" onclick="block()"><img src="https://png.icons8.com/windows/20/ffffff/shield.png"> <span>Разблокировать пользователя</span></li>');
                }
            ?>
        </ul>
    </div>
<?php
    $query = "UPDATE messages SET readmessage='0' WHERE fromem='".$_SESSION['login']."' AND toem='".$login."' AND login='".$_SESSION['login']."' OR fromem='".$login."' AND toem='".$_SESSION['login']."' AND login='".$_SESSION['login']."'"; 
    $result = $conn->query($query);
    $query = "SELECT * FROM messages WHERE fromem='".$_SESSION['login']."' AND toem='".$login."' AND login='".$_SESSION['login']."' OR fromem='".$login."' AND toem='".$_SESSION['login']."' AND login='".$_SESSION['login']."' order by id ASC"; 
    $result = $conn->query($query);
    $rows = $result->num_rows;
    if($rows > 20) {
        print('<div onclick="download(\''.$login.'\')" class="showmore">Показать больше</div>');
        $_SESSION['moremes'] = 20;
    }
    for($j=0;$j<$rows;$j++) {
        if($j >= ($rows-20)) {
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
</div>
<?php if($stoped1 == 1) {
     ?>
<div class="sendinput">
    <div class="inin"><form onsubmit="return false;"><input type="text" autocomplete="off" id="messager" value="Этот пользователь заблокировал вас" readonly></form></div>
    <div class="submit stoped" onclick="return false;">Отправить</div>
</div>
<?php
}
else {
?>
<div class="sendinput">
    <div class="inin"><form id="sms" onsubmit="return false;"><input type="text" autocomplete="off" placeholder="Введите текст сообщения..." name="message" id="messager" onkeydown="keydown(this,event)"><div class="smsphotoname" style="display:none;"></div></form><img src="https://png.icons8.com/windows/23/c8c8c8/unsplash.png" onclick="smsphoto();"><input type="file" id="smsphoto" name="smsphoto" style="display:none;"></div>
    <div class="submit" onclick="sms('<?php echo $_GET['id']; ?>');">Отправить</div>
    <div id="photo"></div>
</div>
<?php
}
?>
<script type="text/javascript" src="message.js"></script>
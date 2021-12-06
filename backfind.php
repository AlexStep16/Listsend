<div id="messageheader">
                <h1>Мои сообщения</h1><span class="setting"><div class="help helpdel">Пометить всё как прочитанное</div><img src="https://png.icons8.com/windows/25/666666/ok.png" onclick="checkall()"></span><span class="entermes" onclick="make()"><img src="https://png.icons8.com/windows/13/ffffff/plus-math.png">Написать сообщение</span><hr>
            </div>
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
                $query = "SELECT * from messages WHERE BINARY fromem='".$_SESSION['login']."' AND BINARY login='".$_SESSION['login']."' OR BINARY toem='".$_SESSION['login']."' AND BINARY login='".$_SESSION['login']."' order by id DESC"; 
                $result = $conn->query($query);
                $rows = $result->num_rows;
                if($rows !=0 ) print('<ul>');
                
                for($j = 0;$j<$rows;$j++) {
                    $result->data_seek($j);
                    if($result->fetch_array()['toem'] == $_SESSION['login']) {
                        $result->data_seek($j);
                        $men = $result->fetch_array()['fromem'];
                    }
                    $result->data_seek($j);
                    if($result->fetch_array()['fromem'] == $_SESSION['login']) {
                        $result->data_seek($j);
                        $men = $result->fetch_array()['toem'];
                    }
                    for($i = 0;$i<$j;$i++) {
                        $result->data_seek($i);
                        $swdgj = $result->fetch_array()['toem'];
                        $result->data_seek($i);
                        if($men == $result->fetch_array()['fromem'] || $men == $swdgj) {
                            $men = 1;
                        }
                    }
                    if($men != 1) {
                        $query2 = "SELECT * from users WHERE BINARY login='".$men."'"; 
                        $result2 = $conn->query($query2);
                        $emailred = str_replace('.', '', $result2->fetch_array()['email']);
                        $emailred = str_replace('@', '', $emailred);
                        $result2->data_seek(0);
                        $id = $result2->fetch_array()['id'];
                        $query2 = "SELECT * from messages WHERE fromem='".$_SESSION['login']."' AND toem='".$men."' AND login='".$_SESSION['login']."' AND readmessage='1' OR toem='".$_SESSION['login']."' AND fromem='".$men."' AND login='".$_SESSION['login']."' AND readmessage='1' order by id DESC"; 
                        $result2 = $conn->query($query2);
                        $rowsreadmessages = $result2->num_rows;
                        if($rowsreadmessages != 0) {
                            $rowsreadmessages = '<span class="countread">'.$rowsreadmessages.'</span>';
                        }
                        else {
                            $rowsreadmessages = '';
                        }
                        $query2 = "SELECT * from messages WHERE fromem='".$_SESSION['login']."' AND toem='".$men."' AND login='".$_SESSION['login']."' OR toem='".$_SESSION['login']."' AND fromem='".$men."' AND login='".$_SESSION['login']."' order by id DESC"; 
                        $result2 = $conn->query($query2);
                        $rowsread = $result2->num_rows;
                        $result2->data_seek(0);
                        $content = $result2->fetch_array()['content'];
                        $result2->data_seek(0);
                        $read = $result2->fetch_array()['readmessage'];
                        $result2->data_seek(0);
                        $date = finddate($result2->fetch_array()['date']);
                        $result2->data_seek(0);
                        $idintab = $result2->fetch_array()['id'];
                        $result2->data_seek(0);
                        if(is_file('avatar/'.md5('avatar'.$emailred).'.jpg')) {
                            $img = 'avatar/'.md5('avatar'.$emailred).'.jpg';
                        }
                        else {
                            $img = 'avatar/123123.jpg';
                        }
                        if($result2->fetch_array()['fromem'] == $men) {
                            $content = '<span class="you">Собеседник:</span> '.$content;
                        }
                        else {
                            $content = '<span class="you">Вы:</span> '.$content;
                        }
                        if($read == 1) {
                            $content = '<span style="font-weight:bold;" class="reading">'.$content.'</span>';
                        }
                        print('<li onclick="send2(\''.$id.'\')" id="box'.$idintab.'">
                    <div class="avatar">
                        <div style="width:50px;height:50px;background:url('.$img.');background-size:cover;background-position:center;display:inline-block;border-radius:100px;"></div>
                    </div>
                    <div class="info">
                        <span class="spanlogin">'.$men.'</span><br>
                        <p class="text"><span class="date">'.$date.'</span><span id="rows'.$idintab.'" style="display:none;">'.$rowsread.'</span>'.$content.$rowsreadmessages.'</p>
                        <script> update(\''.$idintab.'\'); </script>
                    </div>
                </li><hr>');
                    }
                }
                if($rows !=0 ) print('</ul>');
                else {
            ?>
            <div class="content">
                <img src="https://png.icons8.com/ios/100/cccccc/secured-letter.png">
                <p>У вас нет сообщений</p>
            </div>
          <?php  }
            ?>
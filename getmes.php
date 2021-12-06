<?php
    session_start();
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    # Взять все значения из таблицы dontdisturb чтобы не приходили уведомления в сообщения
    $query = "SELECT * from dontdisturb WHERE BINARY login='".$_SESSION['login']."'";

    $result = $conn->query($query);
    $rows = $result->num_rows;

    # Переменная показывающая, кого не нужно учитывать в сообщениях
    $stop = ' ';

    for($j=0; $j<$rows; $j++) {
        $result->data_seek($j);
        
        # Если найдено поле с моим логином, то присвоить переменной stop кого не учитывать
        if($result->fetch_array()['login'] == $_SESSION['login']) {
            $result->data_seek($j);
            $stop = $stop." AND BINARY fromem!='".$result->fetch_array()['who']."'";
        }
        
    }
    # Берем из message сообщения, которые не прочитаны 
    $query = "SELECT * from messages WHERE BINARY fromem='".$_SESSION['login']."' AND BINARY login='".$_SESSION['login']."' AND readmessage='1'".$stop." OR BINARY toem='".$_SESSION['login']."' AND BINARY login='".$_SESSION['login']."' AND readmessage='1'".$stop." order by id DESC LIMIT 1";
    $result = $conn->query($query);
    $login = $result->fetch_array()['fromem'];
    $query = "SELECT * from users WHERE BINARY login='".$login."'";
    $result = $conn->query($query);
    $email = $result->fetch_array()['email'];
    $email = str_replace('.', '', $email);
    $email = str_replace('@', '', $email);
    if(is_file('avatar/'.md5('avatar'.$email).'.jpg')) {
        print('<div class="getmessage" style="animation:show 0.5s ease;" onclick="location.href=\'message.php\'">
                    <div class="fromgetavatar"><div class="favatar" style="background:url(avatar/'.md5('avatar'.$email).'.jpg);background-size:cover;background-position:center;"></div></div>
                    <div class="fromget"><div class="fcontent">Вы получили сообщение от:<br><span>'.$login.'</span></div></div>
                </div>');
    }
    else {
         print('<div class="getmessage" style="animation:show 0.5s ease;" onclick="location.href=\'message.php\'">
                    <div class="fromgetavatar"><div class="favatar" style="background:url(avatar/123123.jpg);background-size:cover;background-position:center;"></div></div>
                    <div class="fromget"><div class="fcontent">Вы получили сообщение от:<br><span>'.$login.'</span></div></div>
                </div>');
    }
?>
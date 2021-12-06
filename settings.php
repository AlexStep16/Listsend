<!DOCTYPE html>
<?php 
    session_start();
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
                
    function notdate($date) {
                $offset = $_SESSION['timezone']; 
                $date = $date + ($offset * 3600);
                $date = date("d.m.Y H:i:s", $date);
                $string = explode('.', $date); 
                                if($string[0] == date('d',time() + ($offset * 3600))) {
                                    $time1 = time()+$offset*3600;
                                    $time2 = strtotime($date);
                                    $diff = $time1 - $time2;
                                    if($diff < 3600) {
                                        if(gmdate('i', $diff) % 10 == 1) {
                                            $min = "минута";
                                        }
                                        elseif(gmdate('i', $diff) % 10 > 1 && gmdate('i', $diff) % 10 < 5) {
                                            $min = "минуты";
                                        }
                                        elseif(gmdate('i', $diff) % 10 >= 5) {
                                            $min = "минут";
                                        }
                                        elseif(gmdate('i', $diff) % 10 == 0) {
                                            $min = "минут";
                                        }
                                        if(gmdate('i', $diff) >= 10 && gmdate('i', $diff) <= 20) {
                                            $min = "минут";
                                        }
                                        if(gmdate('s', $diff) < 60 && gmdate('i', $diff) == 0 && gmdate('H', $diff) == 0) {
                                            if(gmdate('s', $diff) % 10 == 1) {
                                                $sek = "секунда";
                                            }
                                            elseif(gmdate('s', $diff) % 10 > 1 && gmdate('s', $diff) % 10 < 5) {
                                                $sek = "секунды";
                                            }
                                            elseif(gmdate('s', $diff) % 10 >= 5) {
                                                $sek = "секунд";
                                            }
                                            elseif(gmdate('s', $diff) % 10 == 0) {
                                                $sek = "секунд";
                                            }
                                            if(gmdate('s', $diff) >= 10 && gmdate('s', $diff) <= 20) {
                                                $sek = "секунд";
                                            }
                                            return 1*gmdate('s', $diff)." ".$sek." назад";
                                        }
                                        else {
                                            return 1*gmdate('i', $diff)." ".$min." назад";
                                        }
                                    }
                                    else {
                                        return "Сегодня в ".date('H:i',strtotime(substr($date, strrpos($date," ")+1)));
                                    }
                                }
             
                                elseif($string[0] == date('d', strtotime('yesterday') + ($offset * 3600))) {
                                    return "Вчера в ".date('H:i',strtotime(substr($date, strrpos($date," ")+1)));
                                }
                                else {
                                    $month = whatdate($string[1]);
                                    $trip = explode(' ',$date);
                                    $str2 = explode(' ',$string[2]);
                                    return $string[0].' '.$month.' '.$str2[0].' в '.substr($trip[1],0,-3);
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
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);             
    $notmy = 0;
    $query = "SELECT * from messages WHERE fromem='".$_SESSION['login']."' AND login='".$_SESSION['login']."' AND readmessage='1' OR toem='".$_SESSION['login']."' AND login='".$_SESSION['login']."' AND readmessage='1' order by id DESC"; 
    $result = $conn->query($query);
    $rows = $result->num_rows;
    if($rows != 0 ) {
        $rows = '<span class="messagecount">'.$rows.'</span>';
    }
    else {
        $rows = '<span class="messagecount" style="display:none;">'.$rows.'</span>';
    }

    # Берем все из notification, где уведомления не прочтены
    $query = "SELECT * from notification WHERE login='".$_SESSION['login']."' AND reading='1' AND who!='".$_SESSION['login']."' order by id DESC"; 
    $result = $conn->query($query);
    $rowsnotification = $result->num_rows;

    # Указываем фактическое количество непрочтенных уведомлений
    $ros = $rowsnotification;
    
    # Если количество уведомлений не равно 0, выводим их
    if($rowsnotification != 0 ) {
        $rowsnotification = '<span class="notifcount">'.$rowsnotification.'</span>';
    }
    
    # Если количество уведомлений равно 0, выводим, но не показываем их
    else {
        $rowsnotification = '<span class="notifcount" style="display:none;">'.$rowsnotification.'</span>';
    }

    $query = "SELECT * from design WHERE login='".$_SESSION['login']."'"; 
    $result = $conn->query($query);
    $bord = $result->fetch_array()['avatarform'];
    $result->data_seek(0);
    $gmt = $result->fetch_array()['time'];
    $result->data_seek(0);
    $push = $result->fetch_array()['push'];
    if($push == 'on')  {
        $push = "checked";
    }
    $result->data_seek(0);
    $adres = $result->fetch_array()['sitename'];
    if($adres == '') {
        $adres = $_SESSION['login'];
    }
?>
<html>
    <head>
        <link href="settings.css?id=443646" rel="stylesheet">
        <script src='http://code.jquery.com/jquery-3.2.1.min.js'></script> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="autosize.js"></script>
        <script type="text/javascript" src="settings.js"></script>
        <link href="ring.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <title>ListSend | Настройки</title>
    </head>
    <body>
        <div id="header">
            
            <h1><a href="index.php" class="logo">ListSend</a></h1>
            <div class="findls">
                <form id="findlsform" method="post" onsubmit="return false;">
                    <img src="314478-24.png"><input type="text" placeholder="Поиск в ListSend..." name="findls" onkeydown="findls()" onclick="findls()" type="search" maxlength="400" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" aria-autocomplete="list">
                    <div class="findlsnote"></div>
                </form>
            </div>
            <?php
                if(is_file('avatar/'.md5('avatar'.$emailfor).'.jpg')) {
                    $headerav = 'avatar/'.md5('avatar'.$emailfor).'.jpg';
                }
                else {
                    $headerav = 'avatar/123123.jpg';
                }
            ?>
            <a href="javascript:void(0)" class="avatarselect" onclick="menuuser()" id="not1">
                <div style="background-image:url(<?php print($headerav); ?>);background-size:cover;background-position:center;border-radius:<?php echo $bord; ?>;" class="headerlogimg"></div>
            </a>
            
            <a href="javascript:void(0)" onclick="notification()" id="not">
                <span style="position:relative;"><img src="https://png.icons8.com/windows/25/ffffff/appointment-reminders.png"><?php echo $rowsnotification; ?></span><span class="headerspan">Уведомления</span>
            </a>
            
            <a href="message.php">
                <span style="position:relative;"><img src="https://png.icons8.com/windows/25/ffffff/sms.png"><?php echo $rows; ?></span><span class="headerspan">Сообщения</span>
            </a>
            
            <a href="index.php">
                <img src="https://png.icons8.com/windows/25/ffffff/home.png"> <span class="headerspan">Главная</span>
            </a>
            
        </div>
        <div class="allnote">
                <div class="black"></div>
                    <div class="notecontent">
                        <h1>Уведомления<span class="closenotes" onclick="shownotes()">Закрыть</span></h1>
                        <div class="mainnote">
                        <ul>
                        <?php
                        $query = "SELECT * from notification WHERE login='".$_SESSION['login']."' AND who !='".$_SESSION['login']."' order by id DESC"; 
                        $result = $conn->query($query);
                        $ros = $result->num_rows;
                        if($ros == 0) {
                            print('<div class="nonenot">Уведомлений нет</div>');
                        }
                        for($j = 0;$j<$ros;$j++) {
                            $result->data_seek($j);
                            $what = $result->fetch_array()['what'];
                            $result->data_seek($j);
                            if($what == 'like') {
                                $string = '<b>'.$result->fetch_array()['who'].'</b> оценил(а) вашу <b>запись</b>';
                            }
                            if($what == 'comment') {
                                $string = '<b>'.$result->fetch_array()['who'].'</b> отетил(а) вам';
                            }
                            $result->data_seek($j);
                            if($what == 'repost') {
                                $string = '<b>'.$result->fetch_array()['who'].'</b> поделился(ась) вашей <b>записью</b>';
                            }
                            $result->data_seek($j);
                            $string = '<div class="star" style="display:inline-block;">'.$string.'<br><span style="color:rgba(90,90,90,0.7);font-size:14px;">'.notdate($result->fetch_array()['date']).'</span></div>';
                            $result->data_seek($j);
                            $query2 = "SELECT email from users WHERE login='".$result->fetch_array()['who']."' order by id DESC"; 
                            $result2 = $conn->query($query2);
                            $result->data_seek($j);
                            $emailimg = str_replace('.', '', $result2->fetch_array()['email']);
                            $emailimg = str_replace('@', '', $emailimg);
                            if(is_file('avatar/'.md5('avatar'.$emailimg).'.jpg')) {
                                $ava = 'avatar/'.md5('avatar'.$emailimg).'.jpg';
                            }
                            else {
                                $ava = 'avatar/123123.jpg';
                            }
                            if($what == 'like') {
                                print('<li><div style="width: 40px;position:relative;cursor:pointer;display:inline-block;" onclick="location.href=\''.$result->fetch_array()['who'].'.php\'"><div style="background-image:url('.$ava.');background-size:cover;background-position:center;border-radius:30px;width: 35px;height: 35px;"></div><img src="icons8-heart-outline-20.png" class="userlike" width="25" height="25"></div> 
                                '.$string.'</li>');
                            }
                            if($what == 'repost') {
                                print('<li><div style="width: 40px;position:relative;display:inline-block;"><img src="avatar/'.md5('avatar'.$emailimg).'.jpg" width="35" height="35"><img src="Untitled-1.png" width="35" height="35" class="userrepost"></div> 
                                '.$string.'</li>');
                            }  
                            if($what == 'comment') {
                                print('<li><div style="width: 40px;position:relative;display:inline-block;"><img src="avatar/'.md5('avatar'.$emailimg).'.jpg" width="35" height="35"><img src="nu.ico" width="15" height="15"  class="commentnot"></div> 
                                '.$string.'</li>');
                            }   
                        }
                        ?>
                        </ul>
                        </div>
                    </div>
            </div>
            <div class="support">
                <div class="black2"></div>
                    <div class="notecontent" style="height:auto;margin-top:-230px;">
                        <h1>Форма поддержки<span class="closenotes" onclick="shownotes3()">Закрыть</span></h1>
                        <div class="mainnote">
                            <span>Проблема:</span><br>
                            <form id="supform">
                                <select name="supname">
                                    <option value="1">Ошибки в работе ленты</option>
                                    <option value="2">Не войти в аккаунт</option>
                                    <option value="3">Проблемы с блогом</option>
                                    <option value="4">Подозрения на взлом</option>
                                    <option value="5">Другие</option>
                                </select><br><br>
                                <span>Опишите проблему более подробно:</span><br>
                                <textarea name="suptext"></textarea><br>
                                <span>E-mail для связи:</span><br>
                                <input name="supemail" type="text" value="<?php if(isset($_SESSION['email'])) {print($_SESSION['email']);} ?>"><br><br>
                            </form>
                            <a href="#" onclick="support()">Отправить</a>
                        </div>
                    </div>
                
            </div>
        <div class="notifbox">
                <div class="noth1">Ваши уведомления <span id="shownotes" onclick="shownotes()">Показать все</span></div><hr>
                <ul>
                    <script> notificationupdate(); </script>
                </ul>
        </div>
        <div class="userbox">
                <ul>
                    <h4><?php echo $_SESSION['login']; ?></h4>
                    <li onclick="location.href='<?php echo $_SESSION['login']; ?>.php'"><img src="https://png.icons8.com/windows/20/666666/gender-neutral-user.png"> <span>Мой блог</span></li><hr><li onclick="location.href='privacy.php'"><img src="https://png.icons8.com/windows/20/666666/rules.png"> <span>Конфиденциальность</span></li><hr>
                    <li onclick="location.href='settings.php'"><img src="https://png.icons8.com/windows/20/666666/settings.png"> <span>Настройки</span></li><hr>
                    <li onclick="shownotes3()"><img src="https://png.icons8.com/windows/20/666666/help.png"> <span>Помощь</span></li><hr>
                    <a href="exit.php"><li><img src="https://png.icons8.com/windows/20/666666/export.png"> <span>Выход</span></li></a>
                </ul>
            </div>
        <div class="content">
            <div class="contentdiv">
                <form id="formset">
                <h1>Учетная запись</h1><hr>
                <div class="line">
                    <span>E-mail:</span><br>
                    <input type="text" placeholder="E-mail" value="<?php echo $_SESSION['email']; ?>" onkeydown="check('1')" onchange="check('1')" id="1" name="email">
                    <div id="s1" class="savebutton" onclick="set('1')">Сохранить</div>
                </div>
                <div class="line">
                    <span>Логин:</span><br>
                    <input type="text" placeholder="Логин" value="<?php echo $_SESSION['login']; ?>" onkeydown="check('2')" onchange="check('2')" id="2" name="login">
                    <div id="s2" class="savebutton" onclick="set('2')">Сохранить</div>
                </div>
                <div class="line">
                    <span>Адрес блога:</span><br>
                    <div style="border: 1px solid rgba(0,0,0,0.1);width:312px;border-radius:2px;padding-left:5px;box-sizing:border-box;margin-top:5px;display: inline-block;" id="3">
                    <span style="position:relative;bottom:5px;">https://listsend.ru/</span>
                    <input type="text" placeholder="Адрес" value="<?php echo $adres; ?>" style="border:none;padding-left:0;width:180px;position:relative;right:3px;margin:0;" onkeydown="check('3')" onchange="check('3')" name="sitename">
                    </div>
                    <div id="s3" class="savebutton" style="bottom:5px;" onclick="set('3')">Сохранить</div>
                </div>
                <div class="line">
                    <span>Часовой пояс:</span><br>
                    <select name="gmtselect" onchange="set('4')">
                      <option value="2">(GMT +02:00) - Россия, Эстония, Финляндия, Литва, Украина</option>
                      <option value="3">(GMT +03:00) - Россия, Белоруссия, Украина, Турция</option>
                      <option value="4">(GMT +04:00) - Россия, Грузия, Армения, Азербайджан</option>
                      <option value="5">(GMT +05:00) - Россия, Казахстан, Узбекистан, Туркмения</option>
                      <option value="6">(GMT +06:00) - Россия, Казахстан, Киргизия, Бутан</option>
                      <option value="7">(GMT +07:00) - Россия, Монголия, Таиланд, Лаос</option>
                      <option value="8">(GMT +08:00) - Россия, Монголия, Китай, Тайвань, Филиппины</option>
                      <option value="9">(GMT +09:00) - Россия, Республика Корея, Япония, Индонезия</option>
                      <option value="10">(GMT +10:00) - Россия, Папуа — Новая Гвинея, Австралия</option>
                      <option value="11">(GMT +11:00) - Россия, Соломоновы Острова, Новая Каледония</option>
                      <option value="12">(GMT +12:00) - Россия, Маршалловы Острова, Кирибати</option>
                    </select>
                </div>
                
                <h1>Безопасность</h1><hr>
                <div class="line">
                    <span>Пароль:</span><br>
                    <input type="password" placeholder="E-mail" value="123456">
                </div>
                <div class="line">
                    <span>Новый пароль:</span><br>
                    <input type="password" placeholder="Введите пароль" name="pass" onchange="check('4')" id="4">
                </div>
                <div class="line">
                    <span>Подтвердите пароль:</span><br>
                    <input type="password" placeholder="Введите пароль" name="confpass" onchange="check('5')" onkeydown="check('5')" id="5">
                    <div id="s5" class="savebutton" style="bottom:2px;" onclick="set('5')" >Сохранить</div>
                </div>
                
                <h1>Уведомления</h1><hr>
                <div class="line">
                    <span>Отключить уведомления</span>
                    <input type="checkbox" name="push" onchange="set('6')" <?php echo $push; ?>>
                </div>
                <div class="line">
                    <span>Черный список уведомлений:</span>
                    <?php
                        $query = "SELECT * from dontdisturb WHERE login='".$_SESSION['login']."'"; 
                        $result = $conn->query($query);
                        $rows = $result->num_rows;
                        for($j=0;$j<$rows;$j++) {
                            $result->data_seek($j);
                            $who = $result->fetch_array()['who'];
                            if($j == $rows-1) {
                                print('<a href="'.$who.'.php" style="color:blue;">'.$who.'</a>');
                            }
                            else {
                                print('<a href="'.$who.'.php" style="color:blue;">'.$who.'</a>, ');
                            }
                        }
                        if($rows == 0) {
                            print('Пусто');
                        }
                        
                    ?>
                </div>
                
                <h1>Черный список</h1><hr>
                <div class="line">
                    <span>Заблокированные пользователи:</span> 
                    <?php
                        $query = "SELECT * from blocked WHERE login='".$_SESSION['login']."'"; 
                        $result = $conn->query($query);
                        $rows = $result->num_rows;
                        for($j=0;$j<$rows;$j++) {
                            $result->data_seek($j);
                            $who = $result->fetch_array()['who'];
                            if($j == $rows-1) {
                                print('<a href="'.$who.'.php" style="color:blue;">'.$who.'</a>');
                            }
                            else {
                                print('<a href="'.$who.'.php" style="color:blue;">'.$who.'</a>, ');
                            }
                        }
                        if($rows == 0) {
                            print('Пусто');
                        }
                        
                    ?>
                </div>
                </form>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">
    $('option[value="<?php echo $gmt; ?>"]').attr("selected", "selected");
</script>
<script type="text/javascript">
        $(document).mouseup(function (e){
            var div = $(".sendhide"); // тут указываем ID элемента
		if (!div.is(e.target) // если клик был не по нашему блоку
		    && div.has(e.target).length === 0) { // и не по его дочерним элементам
			div.css({'display':'none'}); // скрываем его
		}
        var block = $(".notifbox");
        var block2 = $('#not span');
        if (!block.is(e.target)
            && block.has(e.target).length === 0 && !block2.is(e.target)) {
            block.removeClass('makeanoteopen');
        }
        var block3 = $(".userbox");
        var block4 = $('#not1 div');
        if (!block3.is(e.target)
            && block3.has(e.target).length === 0 && !block4.is(e.target)) {
            block3.removeClass('userboxshow');
        }
        });
    $(document).ready(function(){
            $('.black').on('click',function(){
                $('.allnote').toggleClass('block'); 
            });
            $('.black2').on('click',function(){
                $('.support').toggleClass('block'); 
            });
        });
    </script>
<script type="text/javascript" src="settings.js"></script>
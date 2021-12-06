<!DOCTYPE html>
<?php 
    session_start();
    date_default_timezone_set('UTC');
    function whatdate($date) {
    if($date == '11') {
        return 'ноя';
    }
    if($date == '12') {
        return 'декабря';
    }
    if($date == '01') {
        return 'января';
    }
    if($date == '02') {
        return 'февраля';
    }
    if($date == '03') {
        return 'марта';
    }
    if($date == '04') {
        return 'апреля';
    }
    if($date == '05') {
        return 'мая';
    }
    if($date == '06') {
        return 'июня';
    }
    if($date == '07') {
        return 'июля';
    }
    if($date == '08') {
        return 'августа';
    }
    if($date == '09') {
        return 'сентября';
    }
    if($date == '10') {
        return 'октября';
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
    $_SESSION['filecount'] = 0;
    # Функция обрезающая строку по символам
    function updatestring($string) {
                $limit = 42;
                $words = explode(' ', $string);
                if (sizeof($words) <= $limit) {
                    return preg_replace('~(?:\r?\n){2,}~',"\n\n",$string); 
                }
                $words = array_slice($words, 0, $limit); // укорачиваем массив до нужной длины
                $out = implode(' ', $words);
                return $out."<br>"; //возвращаем строку + символ/строка завершения
            }
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);  
    
    $query = "SELECT * FROM design WHERE login='".$_SESSION['login']."'"; 
    $result = $conn->query($query);
    $result->data_seek(0);
    $avatarsize = $result->fetch_array()['avatarform'];
    
    $query = "SELECT * FROM category WHERE login='".$_SESSION['login']."'"; 
    $result = $conn->query($query);
    if (!$result) die ($conn->error);
    $rows = $result->num_rows;
    if($rows < 3) {
        header("Location: choose.php");
    }

    # Показать что это я в рекомендациях присвоив переменной notmy 0
    $notmy = 0;

    # Взять все значения из таблицы dontdisturb чтобы не приходили уведомления в сообщения
    $query = "SELECT * from dontdisturb WHERE login='".$_SESSION['login']."'";

    $result = $conn->query($query);
    $rows = $result->num_rows;

    # Переменная показывающая, кого не нужно учитывать в сообщениях
    $stop = ' ';

    for($j=0; $j<$rows; $j++) {
        $result->data_seek($j);
        
        # Если найдено поле с моим логином, то присвоить переменной stop кого не учитывать
        if($result->fetch_array()['login'] == $_SESSION['login']) {
            $result->data_seek($j);
            $stop = $stop." AND fromem!='".$result->fetch_array()['who']."'";
        }
        
    }

    # Берем из message сообщения, которые не прочитаны 
    $query = "SELECT * from messages WHERE fromem='".$_SESSION['login']."' AND login='".$_SESSION['login']."' AND readmessage='1'".$stop." OR toem='".$_SESSION['login']."' AND login='".$_SESSION['login']."' AND readmessage='1'".$stop." order by id DESC";
    $result = $conn->query($query);
    $rows = $result->num_rows;

    # Если количество сообщений не равно 0, то показываем их
    if($rows != 0 ) {
        $rows = '<span class="messagecount">'.$rows.'</span>';
    }

    # Если количество сообщений равно 0, выводим но не показываем их
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

?>
<html>
    <head>
        <link href="board.css?id=443646" rel="stylesheet">
        <link href="ring.css" rel="stylesheet">
        <script src='http://code.jquery.com/jquery-3.2.1.min.js'></script> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="autosize.js"></script>
        <script type="text/javascript" src="main.js"></script>  
        <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link href="quil_snow.css" rel="stylesheet">
        <link href="quil_bubble.css" rel="stylesheet">
        <script src="https://cdn.quilljs.com/1.3.4/quill.js"></script>
        <title>ListSend | Ваши записи</title>
    </head>
    <body>
        <div id="header">
            
            <h1><a href="index.php" class="logo">ListSend</a></h1>
            <div class="findls">
                <form id="findlsform" method="post" onsubmit="return false;">
                    <img src="314478-24.png"><input type="text" placeholder="Поиск в ListSend..." name="findls" onkeydown="findlss()" onclick="findlss()" type="search" maxlength="400" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" aria-autocomplete="list">
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
            <a href="javascript:void(0)" class="avatarselect" onclick="menuuser()" id='not1'>
                <div style="background-image:url(<?php print($headerav); ?>);background-size:cover;background-position:center;border-radius:<?php echo $avatarsize; ?>;" class="headerlogimg"></div>
            </a>
            
            <a href="javascript:void(0)" onclick="notification()" id='not'>
                <span style="position:relative;"><img src="https://png.icons8.com/windows/25/ffffff/appointment-reminders.png"><?php echo $rowsnotification; ?></span><span class="headerspan">Уведомления</span>
            </a>
            
            <a href="message.php">
                <span style="position:relative;"><img src="https://png.icons8.com/windows/25/ffffff/sms.png"><?php echo $rows; ?></span><span class="headerspan">Сообщения</span>
            </a>
            
            <a href="index.php">
                <img src="https://png.icons8.com/windows/25/ffffff/home.png"> <span class="headerspan">Главная</span>
            </a>
            
        </div>
        <div class="main">
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
                            $noteid1 = $result->fetch_array()['noteid'];
                            $result->data_seek($j);
                            if($what == 'like') {
                                $string = '<b>'.$result->fetch_array()['who'].'</b> оценил(а) вашу <a href="'.$noteid1.'.php"><b>запись</b></a>';
                            }
                            if($what == 'comment') {
                                $string = '<b>'.$result->fetch_array()['who'].'</b> <a href="'.$noteid1.'.php"><b>ответил(а)</b></a> вам';
                            }
                            $result->data_seek($j);
                            if($what == 'repost') {
                                $string = '<b>'.$result->fetch_array()['who'].'</b> поделился(ась) вашей <a href="'.$noteid1.'.php"><b>записью</b></a>';
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
            <div class="scroolup"><img src="https://png.icons8.com/windows/40/888888/circled-up-2.png"></div>
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
            <div class="main1">
                <div class="menu">
                    <ul>
                        <li id="make" onclick="make();" class="idmake"><img src="https://png.icons8.com/windows/30/ffffff/plus-math.png"></li>
                        <li onclick="newssub()" class="friendcolor"><img src="https://png.icons8.com/windows/30/ffffff/news.png" style="position:relative;left:1px;bottom:1px;"></li>
                        <li id="news" onclick="news();" class="newscolor"><img src="https://png.icons8.com/windows/30/ffffff/globe.png"></li>
                        <li onclick="diaryup()" class="notescolor"><img src="https://png.icons8.com/windows/30/ffffff/note.png"></li>
                        <li onclick="newslike()" class="likecolor"><img src="https://png.icons8.com/windows/30/ffffff/hearts.png"></li>
                    </ul>
                </div>
                <div style="display:inline-block;vertical-align:top;margin:0 20px;">
                    <div class="makeanote">
                        <h1 id="makeh1">Создание записи</h1><img src="https://png.icons8.com/windows/30/333333/more.png" style="position:absolute;right:8px;top:4px;cursor:pointer" onclick="slidem()"><hr>
                        <form action="makeanote.php" name="makeanote" id="makeanote">
                            <div class="morem">
                            <ul>
                                <li><input type="checkbox" name="comments" id="comments"> Отключить комментирование</li>
                                <li><input type="checkbox" name="locked" id="locked"> Закрытая запись</li>
                            </ul>
                            </div>
                            <input type="text" name="name" placeholder="Заголовок" autocomplete="off" maxlength="300">
                            <div placeholder="Введите текст" id="makeatext" name="sod" onkeydown="checkword()"></div>
                            <div class="allimage"></div>
                            <div class="photo"><div class="photocontent"><img src="https://png.icons8.com/windows/26/999999/camera.png" onclick="takeaphoto();" id="takeaph" style="cursor:pointer;" onmouseover="changeimg()" onmouseout="changeimg2()">&nbsp;<img src="gif2.png" id="takeaph2" width="32" height="32" style="position:relative;top:2px;cursor:pointer;" onclick="takeaphoto();" onmouseover="changeimg3()" onmouseout="changeimg4()"><span class="counter"><span id="countword">4000</span></span></div></div>
                            <div class="editable" onclick="editclick()"><div class="contented"><span class="alltags"></span><div class="maketags" placeholder="#хэштeги" onkeydown="stack(event);" contenteditable="true"></div></div>
                            </div>
                            <input type="file" id="photo" accept=".jpg, .gif, .jpeg, .png">
                            <input type="file" id="photo213" accept=".jpg, .gif, .jpeg, .png" style="display:none">
                        </form>
                        
                        <div class="makeline">
                            <span id="makenote" onclick="makenote();">Создать</span>
                            <span class="close" id="closeline" onclick="closeline();">Закрыть</span>
                        </div>
                        
                    </div>
                    <div id="allbox">
                        
                    </div>
                </div>
                <div style="display:inline-block;vertical-align:top;">
                    <div class="find">
                        <form id="findform" method="post" onsubmit="return false;">
                        <img src="314478-24.png"><input type="text" placeholder="Поиск записи..." name="find" onkeydown="finds()" onclick="finds()" type="search" maxlength="400" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" aria-autocomplete="list">
                            <div class="findnote"></div>
                        </form>
                    </div>
                    <div class="whatselect">
                        <ul>
                            <li id="lifriends" onclick="newssub()">Новости<div class="lifriendsspin"></div></li>
                            <li id="linews" onclick="news()">Рекомендации<div class="linewsspin"></div></li>
                            <li onclick="diaryup()" id="lidiar">Мои записи<div class="lidiarspin"></div></li>
                            <li id="lilike" onclick="newslike()">Понравившиеся посты<div class="lilikespin"></div></li>
                        </ul>
                    </div>
                     <div class="suggest tagsli">
                        <h1>Актуальные теги</h1>
                         <ul>
                         <?php
                            $query = "SELECT tags, COUNT(*) FROM news WHERE tags!='' GROUP BY news.tags order by COUNT(*) DESC";
                            $result = $conn->query($query);
                            $rows = $result->num_rows;
                            if($rows < 20) {
                                $r = $rows;
                            }
                             else {
                                $r = 10;
                            }
                             
                            $array = array();
                            for($j = 0; $j<$r;$j++) {
                                $result->data_seek($j);
                                $tags = $result->fetch_array()['tags'];
                                $tags = explode(' ',$tags);
                                $rowstags = count($tags);
                                for($l = 0;$l<$rowstags;$l++) {
                                    $array[$j][$l] = $tags[$l];
                                }
                                for($i = 0;$i<$j;$i++) {
                                    $result->data_seek($i);
                                    $tags2 = $result->fetch_array()['tags'];
                                    $tags2 = explode(' ',$tags2);
                                    $rowstags2 = count($tags2);
                                    for($l = 0;$l<$rowstags2;$l++) {
                                        for($c = 0;$c<$rowstags;$c++) {
                                            if(isset($array[$j][$c])) {
                                                if($array[$j][$c] == $array[$i][$l]) {
                                                    $array[$j][$c] = 'nopel';
                                                }
                                            }
                                        }
                                    }
                                }
                                for($l = 0;$l<$rowstags;$l++) {
                                    if($array[$j][$l] != 'nopel') {
                                        if($tags[$l] != '') {
                                            print('<li id="tag'.$j.$l.'" onclick="findtag(\''.$j.$l.'\')" style="cursor:pointer;">#'.$tags[$l].'</li>');
                                        }
                                    }
                                }
                            }
                         ?>
                         </ul>
                        </div>
                    <div class="suggest">
                        <h1>Могут быть интересны</h1>
                        <ul>
                            <?php 
                                
                                # Выбираем наш id
                                $query = "SELECT id from users WHERE email='".$_SESSION['email']."'";
                                $result = $conn->query($query);
                                $myid = $result->fetch_array()['id'];
                                
                                # Выбираем уникальных пользователей с наибольшим кол-вом подписчиков
                                $query = "SELECT DISTINCT userid from subscribes order by count DESC"; 
                                $result = $conn->query($query);
                            
                                # Выводим 4 последних
                                for($j = 0; $j < 4; $j++) {
                                    
                                    # Я не подписан
                                    $answer = 0;
                                    
                                    $result->data_seek($j);
                                    
                                    # Пользователь с текущим id
                                    $query3 = "SELECT * from subscribes WHERE userid='".$result->fetch_array()['userid']."'"; 
                                    $result3 = $conn->query($query3);
                                    $rows3 = $result->num_rows;
                                    
                                    # Это не я
                                    $fill = 0;
                                    
                                    # Ищем есть ли мы среди подписчиков
                                    for($i = 0;$i<$rows3;$i++) {
                                        $result3->data_seek($i);
                                        
                                        # Если id пользователя совпадает с моим, то я подписан
                                        $notmyid = $result3->fetch_array()['subscriberid'];
                                        if($myid == $notmyid) {
                                            # Это я
                                            $answer = 1;
                                        }
                                        
                                    }

                                    $result->data_seek($j);
                                    $userid = $result->fetch_array()['userid'];
                                    
                                    # Если я не подписан
                                    if($answer == 0) {
                                        # Если мой id совпадает с id пользователя, то это я
                                        if($myid == $userid) {
                                            # Не выводить кнопку
                                            $divsubs = '';
                                            # Это я 
                                            $fill = 1;
                                        }
                                        # Если мой id не совпадает с id пользователя, то это не я
                                        else {
                                            $divsubs = '<div class="following"><a href="javascript:void(0)" onclick="subscribe(\''.$userid.'\')" id="follow'.$userid.'">Читать</a></div>';
                                        }
                                    }
                                    # Если я подписан, сказать об этом
                                    else {
                                        $divsubs = '<div class="following abcd1"><a href="javascript:void(0)" id="follow'.$userid.'" class="youcheck" onclick="deletesub(\''.$userid.'\')" onmouseover="$(this).html(\'Не читать?\')" onmouseout="$(this).html(\'Вы читаете\')">Вы читаете</a></div>';
                                    }
                                    
                                    $result->data_seek($j);
                                    
                                    # Узнать логин и E-Mail пользователя
                                    $query2 = "SELECT * from users WHERE id='".$result->fetch_array()['userid']."'";
                                    $result2 = $conn->query($query2);
                                    $user = $result2->fetch_array()['login'];
                                    if(strlen($user) > 20) {
                                        $userupdate = substr($user,0,20).'...';
                                    }
                                    else {
                                        $userupdate = $user;
                                    }
                                    
                                    $query3 = "SELECT * from design WHERE login='".$user."'"; 
                                    $result3 = $conn->query($query3);
                                    $desborder = $result3->fetch_array()['avatarform'];
                                    
                                    
                                    $result2->data_seek(0);
                                    $emailnot = str_replace('.', '', $result2->fetch_array()['email']);
                                    $emailnot = str_replace('@', '', $emailnot);
                                    
                                    # Возможный аватар пользователя
                                    $avatars = md5('avatar'.$emailnot).'.jpg';
                                    if(is_file('avatar/'.$avatars)) {
                                        $avatarsphoto = 'avatar/'.$avatars;
                                    }
                                    else {
                                        $avatarsphoto = 'avatar/123123.jpg';
                                    }
                                    
                                    # Узнать сколько подписчиков у пользователя
                                    $query2 = "SELECT * from subscribes WHERE userid='".$userid."'";
                                    $result2 = $conn->query($query2);
                                    $countsub = $result2->num_rows;
                                    
                                    # Узнаем описание
                                    $query8 = "SELECT * from design WHERE login='".$user."'"; 
                                    $result8 = $conn->query($query8);
                                    $description = $result8->fetch_array()['description'];
                                    if($description == '') {
                                        $description = 'Описание не указано';
                                    }
                                    $result8->data_seek(0);
                                    $blogname = $result8->fetch_array()['blogname'];
                                    if($blogname == '') {
                                        $blogname = $user;
                                    }
                                    
                                    # Узнать сколько постов у пользователя
                                    $query2 = "SELECT * from news WHERE login='".$user."'";
                                    $result2 = $conn->query($query2);
                                    $countnote = $result2->num_rows;  
                                    
                                    # По умолчанию я не подписан
                                    $subconfirm = '<div class="userboxsub" style="font-size:12px;">Вы не читаете</div>';
                                    
                                    # Если я подписан, то вывести это
                                    if($answer != 0) {
                                            $subconfirm = '<div class="userboxsub" style="font-size:14px;">Вы читаете</div>';
                                    }
                                    # Если я не подписан, то вывести это
                                    else {
                                        if($fill == 1) {
                                            $subconfirm = '<div class="userboxsub">Это вы</div>';
                                        }
                                    }
                                    
                                    # Если есть обложка, показать её
                                    if(is_file('background/'.md5('background'.$emailnot).'.jpg')) {
                                        $background = 'background/'.md5('background'.$emailnot).'.jpg';
                                    }
                                    # Если нет взять стандарт
                                    else {
                                        $background = 'sunrise-1014711_1920.jpg';
                                    }
                                    
                                    # Собрать в кучу информацию о пользователе
                                    $usercover = '<div class="usercover" style="background-image:url(\''.$background.'\');background-size:cover;background-position:center;"><div class="backfon"><div class="userph" style="background-image:url(\'avatar/'.md5('avatar'.$emailnot).'.jpg\');background-size:cover;background-position:center;"></div></div></div><div class="allusbox"><div class="usersubline"></div><div class="usersodline"><h1>'.$blogname.'</h1><p>'.$description.'<br><span><a href="'.$user.'.php">https://listsend.ru/'.$user.'</a></span></p></div><div class="userinfoline"></div><div class="usersubscline"><div class="usersubsc" style="margin-right:10px;"><span>Подписчиков</span><br>'.$countsub.'</div><div class="usersubsc" style="margin-left:10px;"><span>Записей</span><br>'.$countnote.'</div></div>'.$subconfirm.'</div>';
                                    
                                    # Вывести список
                                    print('<li id="userli'.$userid.'" onmouseout="userprofile2(\''.$userid.'\');"><div style="background:url('.$avatarsphoto.');background-size:cover;background-position:center;width:35px;height:35px;display:inline-block;border-radius:'.$desborder.';position:relative;top:2px;cursor:pointer;" class="imgloguser" onclick="document.location.href = \''.$user.'.php\'" onmouseover="userprofile(\''.$userid.'\');" onmouseout="userprofile2(\''.$userid.'\')"><div class="user" id="user'.$userid.'">'.$usercover.'</div></div><span class="userlogin"><a href="'.$user.'.php">'.$blogname.'</a></span>'.$divsubs.'</li>');
                            }
                        ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="infoblock"></div>
        <div class="infoblock2"></div>
    </body>                        
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
    </script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript">
        message();
        var toolbarOptions = ['bold', 'italic', 'underline', 'strike', 'link', { 'list': 'ordered'}, { 'list': 'bullet' }, 'clean'];
        $(document).ready(function(){
            $('.black').on('click',function(){
                $('.allnote').toggleClass('block'); 
            });
            $('.black2').on('click',function(){
                $('.support').toggleClass('block'); 
            });
            $('.infoavatar').draggable();
            autosize( $('textarea') );
            $(window).scroll(function (){
                if ($(this).scrollTop() > 400){
                    $('.scroolup').fadeIn();
                } else{
                    $('.scroolup').fadeOut();
                }
            });
            $('.scroolup').click(function (){
                $('body,html').animate({
                    scrollTop:0
                }, 800);
                return false;
            });
        });
        var quill = new Quill('#makeatext', {
            theme: 'bubble',
            placeholder: 'Введите текст',
            modules: {
                toolbar: toolbarOptions
              }
          });
    </script>
    <?php 
    if(isset($_SESSION['boolnews']) || isset($_SESSION['boolsub']) || isset($_SESSION['boollike']) || isset($_SESSION['boolmynote']))
        {
                if($_SESSION['boolnews'] == 1) {
                    print('<script>news();</script>');
                }
                elseif($_SESSION['boolsub'] == 1) {
                    print('<script>newssub();</script>');
                }
                elseif($_SESSION['boollike'] == 1) {
                    print('<script>newslike();</script>');
                }
                elseif($_SESSION['boolmynote'] == 1) {
                    print('<script>diaryup();</script>');
                }
                else {
                    print('<script>newssub();</script>');
                }
        }
        else {
            print('<script>newssub();</script>');
        }
    ?>
        <script type="text/javascript" src="main.js"></script>
</html>
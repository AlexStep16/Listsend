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
    function finddate($date) {
        $new = date('d',$date);
        $nowday = date('d',time() + $_SESSION['timezone']*3600);
        if($new == $nowday) {
            return 'Сегодня в '.date('H:i',$date + $_SESSION['timezone']*3600);
        }
        $yesterday = date('d', time() - 86400 + $_SESSION['timezone']*3600);
        if($new == $yesterday) {
            return 'Вчера в '.date('H:i',$date + $_SESSION['timezone']*3600);
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
?>
<html>
    <head>
        <link href="privacy.css?id=443646" rel="stylesheet">
        <script src='http://code.jquery.com/jquery-3.2.1.min.js'></script> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="autosize.js"></script>
        <script type="text/javascript" src="message.js"></script>
        <link href="ring.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <title>ListSend | Конфиденциальность</title>
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
        <div class="notifbox">
                <div class="noth1">Ваши уведомления <span id='shownotes' onclick="shownotes()">Показать все</span></div><hr>
                <ul>
                    <script> notificationupdate(); </script>
                </ul>
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
        <div class="userbox">
                <ul>
                    <h4><?php echo $_SESSION['login']; ?></h4>
                    <li onclick="location.href='<?php echo $_SESSION['login']; ?>.php'"><img src="https://png.icons8.com/windows/20/666666/gender-neutral-user.png"> <span>Мой блог</span></li><hr><li><img src="https://png.icons8.com/windows/20/666666/rules.png"> <span>Конфеденциальность</span></li><hr>
                    <li onclick="location.href='settings.php'"><img src="https://png.icons8.com/windows/20/666666/settings.png"> <span>Настройки</span></li><hr>
                    <li onclick="shownotes3()"><img src="https://png.icons8.com/windows/20/666666/help.png"> <span>Помощь</span></li><hr>
                    <a href="exit.php"><li><img src="https://png.icons8.com/windows/20/666666/export.png"> <span>Выход</span></li></a>
                </ul>
        </div>
        
        <div class="content">
            <div class="privacy">
                <h1>Политика конфиденциальности</h1>
                <p>
                    Настоящая политика конфиденциальности персональных данных (далее - Политика конфиденциальности) распространяется в отношении всей информации, которую сайт listsend.ru (а также его субдомены), может получать о Пользователе во время использования сайта listsend.ru (а также его субдоменов).
                </p>
                <h2>Что мы собираем с пользователя сайта</h2>
                <p>
                    При регистрации вы указываете свой E-Mail, пароль и имя пользователя. Пароль и E-mail используются для идентификации Пользователя, зарегистрированного на сайте для его дальнейшей авторизации, а также для связи с Пользователем.<br><br>
                    <b>Как используется E-Mail для связи:</b>&nbsp; К вам на почту могут приходить электронные письма для восстановления пароля или учетной записи, информационные оповещания. Мы никогда не будем просить у вас через электронную почту пароль и личную информацию (если вам придет письмо с подобной просьбой, мы рекомендуем вам обратиться в нашу поддержку для выяснения обстоятельств).<br><br>
                    <b>Местоположение:</b>&nbsp; В некотрых случаях мы используем ваше местоположения путем преобразования вашего IP-адреса. Это необходимо для предотвращения мошенничества или подбирая для вас соответствующий контент.
                </p>
                <h2>Способы и сроки обработки персональной информации</h2>
                <p>
                    Обработка персональных данных Пользователя осуществляется без ограничения срока, любым законным способом, в том числе в информационных системах персональных данных с использованием средств автоматизации или без использования таких средств.<br><br>
                    В некоторых случаях мы обязаны предоставлять вашу персональную информацию уполномоченным органам государственной власти Российской Федерации только по основаниям и в порядке, установленным законодательством Российской Федерации.<br><br>
                    Мы можем принять меры для защиты персональных данных Пользователя от неправомерного или случайного доступа, уничтожения, изменения, блокирования, копирования, распространения, а также от иных неправомерных действий третьих лиц.
                </p>
                <h2>Распространение персональных данных</h2>
                <p>
                    Ваши персональные данные не будут известны лицам не состоящих в организации сайта, и мы будем пытаться сделать всё, чтобы предотвратить неправомерные действия третьих лиц.
                </p>
                <h2>Права и обязанности сторон</h2>
                <p>
                    <b>Пользователь вправе:</b><br> 1. Предоставлять персональные данные и давать согласие на их обработку.<br> 2. Обновить, дополнить предоставленную информацию о персональных данных в случае изменения данной информации.<br> 3.  Пользователь имеет право на получение у Администрации информации, касающейся обработки его персональных данных, если такое право не ограничено в соответствии с федеральными законами. Пользователь вправе требовать от Администрации уточнения его персональных данных, их блокирования или уничтожения в случае, если персональные данные являются неполными, устаревшими, неточными, незаконно полученными или не являются необходимыми для заявленной цели обработки, а также принимать предусмотренные законом меры по защите своих прав. Для этого достаточно уведомить Администрацию по указаному E-mail адресу.<br><br><b>Администрация вправе:</b><br>1. Использовать полученную информацию исключительно для целей, указанных в Политике конфиденциальности.<br>2. Обеспечить хранение конфиденциальной информации в тайне, не разглашать без предварительного письменного разрешения Пользователя, а также не осуществлять продажу, обмен, опубликование, либо разглашение иными возможными способами переданных персональных данных Пользователя, за исключением правил указанных в Политике Конфиденциальности<br>3. Принимать меры предосторожности для защиты конфиденциальности персональных данных Пользователя согласно порядку, обычно используемого для защиты такого рода информации в существующем деловом обороте.
                </p>
                <h2>Безопасность вашей информации</h2>
                <p>
                    Ваш аккаунт защищен паролем для вашей конфиденциальности и безопасности данных. Вы должны создать уникальный, безопасный пароль для предотвращения несанкционированного доступа к вашему аккаунту. Мы не можем гарантировать вам полную безопасность ваших данных. Несанкционированный доступ, сбой работы сайта и др. могут угрожать безопасности данных.
                </p>
                <h2>Выкладываемая информация</h2>
                <p>
                    Когда вы выкладываете пост на сайте вы должны помнить, что он будет виден всем пользователям сайта listsend. Пост будет общедоступным и любой человек сможет скопировать его содержимое.
                </p>
                <h2>Ответственность сторон</h2>
                <p>
                    Администрация, не исполнившая свои обязательства, несёт ответственность за убытки, понесённые Пользователем в связи с неправомерным использованием персональных данных, в соответствии с законодательством Российской Федерации, за исключением случаев, указанных в Политике Конфиденциальности.<br><br>В случае утраты или разглашения Конфиденциальной информации Администрация не несёт ответственность, если данная конфиденциальная информация:<br>
                    1. Стала публичным достоянием до её утраты или разглашения.<br>
                    2. Была получена от третьей стороны до момента её получения Администрацией Ресурса.<br>
                    3. Была разглашена с согласия Пользователя.<br><br> Пользователь несет полную ответственность за соблюдение требований законодательства РФ, в том числе законов о рекламе, о защите авторских и смежных прав, об охране товарных знаков и знаков обслуживания, но не ограничиваясь перечисленным, включая полную ответственность за содержание и форму материалов.<br><br> Пользователь признает, что ответственность за любую информацию (в том числе, но не ограничиваясь: файлы с данными, тексты и т. д.), к которой он может иметь доступ как к части сайта, несет лицо, предоставившее такую информацию.
                </p>
                <h2>Изменение в Политике конфиденциальности</h2>
                <p>
                    Мы имеем право вносить изменения в Политику конфиденциальности без разрешения пользователя (с условием Политики которая была акутальна на тот момент).<br><br> Действующая политика расположена по адресу https://listsend.ru/privacy
                </p>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="message.js"></script>
    <script type="text/javascript">
    $(document).mouseup(function (e){
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
</html>
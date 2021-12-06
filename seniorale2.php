<!DOCTYPE html>
<?php
    $path_parts = pathinfo(__FILE__);
    $mainlog =  $path_parts['filename'];
    session_start();  
    if(!isset($_SESSION['email'])) {
        $_SESSION['email'] = 123313;
        $_SESSION['login'] = 123313;
        $_SESSION['timezone'] = 3;
    }
    # Показать что выбраны новости
    $_SESSION['boolnews'] = 0;
    $_SESSION['boollike'] = 0;
    $_SESSION['boolsub'] = 0;
    $_SESSION['boolcat'] = 0;
    $_SESSION['boolmynote'] = 0;
    $_SESSION['boolfind'] = 0;
    $_SESSION['boolblog'] = 1;
    $_SESSION['boolblogfind'] = 0;
            
    # Объявить сессию, показывающую сколько сейчас записей показывается в новостях
    $_SESSION['boolblogmore'] = $mainlog.' 5';
    function right($count,$what) {
        if($what == 1) {
            if($count < 11 || $count > 19) {
                if($count % 10 == 0) {
                    return 'Подписчиков';
                }
                if($count % 10 == 1) {
                    return 'Подписчик';
                }
                if($count % 10 > 1 && $count % 10 < 5) {
                    return 'Подписчика';
                }
                if($count % 10 > 4) {
                    return 'Подписчиков';
                }
            }
            else {
                return 'Подписчиков';
            }
        }
        elseif($what == 2) {
            if($count < 11 || $count > 19) {
                if($count % 10 == 0) {
                    return 'Записей';
                }
                if($count % 10 == 1) {
                    return 'Запись';
                }
                if($count % 10 > 1 && $count % 10 < 5) {
                    return 'Записи';
                }
                if($count % 10 > 4) {
                    return 'Записей';
                }
            }
            else {
                return 'Записей';
            }
        }
        elseif($what == 3) {
            if($count < 11 || $count > 19) {
                if($count % 10 == 0) {
                return 'Подписок';
                }
                if($count % 10 == 1) {
                    return 'Подписка';
                }
                if($count % 10 > 1 && $count % 10 < 5) {
                    return 'Подписки';
                }
                if($count % 10 > 4) {
                    return 'Подписок';
                }
            }
            else {
                return 'Подписок';
            }
        }
        else {
            return 'Неверное значение';
        }
    }
    
    # Функция обрезающая строку по символам
    function updatestring($string) {
                        $limit = 32;
                        $words = explode(' ', $string);
                        if (sizeof($words) <= $limit) {
                            return preg_replace('~(?:\r?\n){2,}~',"\n\n",$string); 
                        }
                        $words = array_slice($words, 0, $limit); // укорачиваем массив до нужной длины
                        $out = implode(' ', $words);
                        return $out."<br>"; //возвращаем строку + символ/строка завершения
                    }

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

    function likegram($str) {
                if($str % 10 == 0) {
                    return 'Лайков';
                }
                if($str % 10 == 1) {
                    return 'Лайк';
                }
                if($str % 10 > 1 && $str % 10 < 5) {
                    return 'Лайка';
                }
                if($str % 10 > 5 && $str % 10 < 10) {
                    return 'Лайков';
                }
                if($str / 10 >9 && $str / 10 < 20) {
                    return 'Лайков';
                }
            }
    function comgram($str) {
                if($str % 10 == 0) {
                    return 'Комментариев';
                }
                if($str % 10 == 1) {
                    return 'Комментарий';
                }
                if($str % 10 > 1 && $str % 10 < 5) {
                    return 'Комментария';
                }
                if($str % 10 > 5 && $str % 10 < 10) {
                    return 'Комментариев';
                }
                if($str / 10 >9 && $str / 10 < 20) {
                    return 'Комментариев';
                }
            }
    function repgram($str) {
                if($str % 10 == 0) {
                    return 'Репостов';
                }
                if($str % 10 == 1) {
                    return 'Репост';
                }
                if($str % 10 > 1 && $str % 10 < 5) {
                    return 'Репоста';
                }
                if($str % 10 > 5 && $str % 10 < 10) {
                    return 'Репостов';
                }
                if($str / 10 >9 && $str / 10 < 20) {
                    return 'Репостов';
                }
            }

    $notlog = 0;
    $hr2="<hr>";
    $hr="<hr>";
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $query = "SELECT * from design WHERE login='".$mainlog."'"; 
    $result = $conn->query($query);
    $site = $result->fetch_array()['sitename'];
    if($site != '') {
        header('Location:'.$site.'.php');
    }
    $query = "SELECT * from messages WHERE fromem='".$_SESSION['login']."' AND login='".$_SESSION['login']."' AND readmessage='1' OR toem='".$_SESSION['login']."' AND login='".$_SESSION['login']."' AND readmessage='1' order by id DESC"; 
    $result = $conn->query($query);
    $rows = $result->num_rows;
    if($rows != 0 ) {
        $rowst = '<span class="messagecount">'.$rows.'</span>';
    }
    else {
        $rowst = '<span class="messagecount" style="display:none;">'.$rows.'</span>';
    }
    $query = "SELECT * from users WHERE login='".$mainlog."' order by id DESC"; 
    $result = $conn->query($query);
    $result->data_seek(0); 
    $emailfor = str_replace('.', '', $result->fetch_array()['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $emailformy = str_replace('.', '', $_SESSION['email']);
    $emailformy = str_replace('@', '', $emailformy);
    $result->data_seek(0); 
    $userid = $result->fetch_array()['id'];
    if($mainlog != $_SESSION['login']) {
        $notlog = 1;
    }
    $query = "SELECT * from subscribes WHERE userid='".$userid."'"; 
    $result = $conn->query($query);
    $subuserrows = $result->num_rows;
    $query = "SELECT * from news WHERE login='".$mainlog."'"; 
    $result = $conn->query($query);
    $noterows = $result->num_rows;$
    $query = "SELECT * from subscribes WHERE subscriberid='".$userid."'"; 
    $result = $conn->query($query);
    $suburows = $result->num_rows;
    
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

    $query = "SELECT * FROM design WHERE login='".$mainlog."'";
    $result = $conn->query($query);
    $result->data_seek(0);
    if($result->fetch_array()['blogname'] != "") {
        $result->data_seek(0);
        $blogname = $result->fetch_array()['blogname'];
    }
    else {
        $blogname = $mainlog;
    }
    $result->data_seek(0);
    if($result->fetch_array()['description'] != "") {
        $result->data_seek(0);
        $description = $result->fetch_array()['description'];
    }
    else {
        $description = '';
    }

    $result->data_seek(0);
    $bgcolor = $result->fetch_array()['backgrcolor'];
    $result->data_seek(0);
    $color = $result->fetch_array()['fontcolor'];
    $result->data_seek(0);
    $font = $result->fetch_array()['font'];
    $result->data_seek(0);
    $scheme = $result->fetch_array()['scheme'];
    $result->data_seek(0);
    $avaform = $result->fetch_array()['avatarform'];
    if($avaform == '5px') {
        $square = 'style="border:2px solid black"';
        $circle = '';
    }
    else {
        $circle = 'style="border:2px solid black"';
        $square = '';
    }
    $result->data_seek(0);
    $blogsize = $result->fetch_array()['namesize'];
    $result->data_seek(0);
    $descriptionsize = $result->fetch_array()['descriptionsize'];
    $result->data_seek(0);
    $desavatarsize = $result->fetch_array()['avatarsize'];
    $result->data_seek(0);
    $toppx = $result->fetch_array()['toppx'];
    $result->data_seek(0);
    $leftpx = $result->fetch_array()['leftpx'];
    $result->data_seek(0);
    $toppxh1 = $result->fetch_array()['toppxh1'];
    $result->data_seek(0);
    $leftpxh1 = $result->fetch_array()['leftpxh1'];
    $result->data_seek(0);
    $toppxp = $result->fetch_array()['toppxp'];
    $result->data_seek(0);
    $leftpxp = $result->fetch_array()['leftpxp'];
    $result->data_seek(0);
    $backsize = $result->fetch_array()['backsize'];
    $result->data_seek(0);
    $descript = $result->fetch_array()['description2'];
    $result->data_seek(0);
    $bool = $result->fetch_array()['checkavatar'];
    if($bool == 'no') {
        $bool='display:none;';
        $checked = "";
    }
    else {
        $bool='display:inline-block;';
        $checked = "checked";
    }
    $result->data_seek(0);
    $booltrans = $result->fetch_array()['backtrans'];
    if($booltrans != 'no') {
        if($scheme != 4) {
            $booltrans='background:transparent;';
            $checktrans = "checked";
        }
        else {
            $booltrans = '';
            $checktrans = "";
        }
    }
    else {
        $booltrans = '';
        $checktrans = "";
    }
?>
<html>
    <head>
        <link href="user.css" rel="stylesheet">
        <link href="ring.css" rel="stylesheet">
        <script src='http://code.jquery.com/jquery-3.2.1.min.js'></script> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="autosize.js"></script>
        <script type="text/javascript" src="main.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <script type="text/javascript" src="farbtastic.js"></script>
        <link rel="stylesheet" href="farbtastic.css" type="text/css" />
        <title><?php echo $blogname; ?></title>
    </head>
    <body style="background:#<?php echo $bgcolor; ?>">
        <div class="body">
            <?php
            if($scheme != '4'){
                 print('<style>#scheme'.$scheme.' {border:2px solid white;padding-bottom:5px;}</style>');
            }
            else {
                print('<style>#scheme'.$scheme.' {border:2px solid white;}</style>');
            }
            ?>
        <div class="settings">
            <div class="setallcontent">
            <div class='seth1'><h1>Изменение дизайна</h1></div>
            <div class="content">
                <p>Схема расположения:</p>
                <div class="scheme" onclick="scheme('4')" id="scheme4">
                    <div class="scheme4">
                        <div class="scheme4login"></div><div class="scheme4subscr"></div><div class="scheme4avatar"></div><div class="scheme4content"></div>
                    </div>
                </div>
                
                <div class="scheme" onclick="scheme('1')" id="scheme1">
                    <div class="scheme1">
                        <div class="scheme1login"></div><div class="scheme1subscr"></div><div class="scheme1avatar"></div><div class="scheme1content"></div>
                    </div><div class="factcontent"></div>
                </div>
                
                <div class="scheme" onclick="scheme('2')" id="scheme2">
                    <div class="scheme2">
                        <div class="scheme2login"></div><div class="scheme2subscr"></div><div class="scheme2avatar"></div><div class="scheme2content"></div>
                    </div><div class="factcontent"></div>
                </div>
                
                <div class="scheme" onclick="scheme('3')" id="scheme3">
                    <div class="scheme3">
                        <div class="scheme3login"></div><div class="scheme3avatar"></div><div class="scheme3content"></div>
                    </div><div class="factcontent"></div>
                </div>
                
                
                <p>Настройки оформления:</p>
                <div class="design">
                    <form id="dessetform">
                    <div class="desbox">
                        <span>Заголовок</span>
                        <input type="text" id="deslogin" name="deslogin" placeholder="Название блога" value='<?php echo $blogname; ?>' onkeydown="deslogins()">
                    </div>
                    <div class="desbox">
                        <span>Цитата блога</span>
                        <input type="text" id="description" name="description" value='<?php echo $description; ?>' placeholder="Что-нибудь хорошее" onkeydown="descriptions()">
                    </div>
                    <div class="desbox">
                        <span>Описание блога</span>
                        <input type="text" id="description2" name="description2" value='<?php echo $descript; ?>' placeholder="Напишите о чем блог" onkeydown="description2s()">
                    </div>
                    <div class="desbox">
                        <span>Фон обложки</span><span><img src="https://png.icons8.com/windows/20/666666/unsplash.png" style="cursor:pointer;" onclick="background()"></span>
                    </div>
                    <div class="desbox">
                        <span>Аватар</span><span><img src="https://png.icons8.com/windows/20/666666/unsplash.png" style="cursor:pointer;" onclick="avatar()"></span>
                    </div>
                    <div class="desbox">
                        <input type="text" id="pick1" value="#<?php echo $bgcolor; ?>" style="display:none" onclick="desback()">
                        <span>Цвет заднего фона</span><div class="colorcircle2" onclick="pick2()" style="background-color:#<?php echo $bgcolor; ?>;"></div>
                    </div>
                    <div id="colorpicker2"></div>
                    <div class="desbox">
                        <input type="text" id="pick2" value="#<?php echo $color; ?>" style="display:none" onclick="descolor()">
                        <span>Цвет заголовка</span><div class="colorcircle" style="background-color:#<?php echo $color; ?>;" onclick="pick()"></div>
                    </div>
                    <div id="colorpicker"></div>
                    <div class="desbox">
                        <span>Показывать аватар</span>
                        <input type="checkbox" id='noavatar' name="noavatar" onchange="desnoavatar()" <?php echo $checked; ?> ><label for="noavatar"></label>
                    </div>
                    <?php if($scheme != 4) { ?>
                    <div class="desbox">
                        <span>Прозрачная обложка</span>
                        <input type="checkbox" id='noback' name="noback" onchange="desnoback()" <?php echo $checktrans; ?>><label for="noback"></label>
                    </div>
                    <?php } else { ?>
                    <div class="desbox">
                            <span style="color:rgba(150,150,150,0.7)">Прозрачная обложка</span><input type="checkbox" id='noback' name="noback"<?php echo $checktrans; ?>><label for="noback"></label>
                    </div>
                    <?php } ?>
                    <div class="desbox">
                        <span>Включить перемещение</span>
                        <input type="checkbox" id='space' name="space" onchange="desspace()"  ><label for="space"></label>
                        <div class="warning"><div style="height:51px;position:relative;">Не рекомендуется перемещать объекты дальше 300px в каждую сторону <img src="https://png.icons8.com/color/20/000000/box-important.png"></div></div>
                    </div>
                    <div class="desbox">
                        <span>Форма аватара</span><div class="avatarformcircle" <?php echo $circle; ?> onclick="descircle()"></div><div class="avatarformsquare" onclick="dessquare()" <?php echo $square; ?>></div>
                    </div>
                    <div class="desbox">
                        <span>Размер заголовка</span><input type="range" id="range" onmousemove="ranges()" value="<?php echo $blogsize; ?>" max="70" min="10"><input type="text" class="output" onkeydown="range2()">
                    </div>
                    <div class="desbox">
                        <span>Размер цитаты</span><input type="range" id="range2" onmousemove="range3s()" value="<?php echo $descriptionsize; ?>" max="70" min="10"><input type="text" class="output2" onkeydown="range4()">
                    </div>
                    <div class="desbox">
                        <span>Размер изображения</span><input type="range" id="range3" onmousemove="range5()" value="<?php echo $desavatarsize; ?>" max="200" min="40"><input type="text" class="output3" onkeydown="range6()">
                    </div>
                    <div class="desbox">
                        <span>Шрифт заголовка</span><div class="font" style="font-family:'<?php echo $font; ?>'" onclick="showstyle()"><?php echo $font; ?></div>
                        <div class="fontbox">
                            <ul>
                                <li class="liRoboto" onclick="font('Roboto')">Roboto</li>
                                <li class="liArvo" onclick="font('Arvo')">Arvo</li>
                                <li class="liOswald" onclick="font('Oswald')">Oswald</li>
                                <li class="liPlay" onclick="font('Play')">Play</li>
                                <li class="liOpenSans" onclick="font('Open Sans')">Open Sans</li>
                                <li class="liAmaticSC" onclick="font('Amatic SC')">Amatic SC</li>
                                <li class="liPTSans" onclick="font('PT Sans')">PT Sans</li>
                                <li class="liRobotoCondensed" onclick="font('Roboto Condensed')">Roboto Condensed</li>
                            </ul>
                        </div>
                    </div>
                    
                    <?php if($scheme != 4) { ?>
                    <div class="desbox">
                        <span>Высота обложки</span><input type="range" id="range4" onmousemove="range7()" value="<?php echo $backsize; ?>" max="600" min="200"><input type="text" class="output4" onkeydown="range8()">
                    </div>
                    <?php } else { ?>
                    <div class="desbox">
                            <span style="color:rgba(150,150,150,0.7)">Высота обложки</span><input type="range" id="range4" value="<?php echo $backsize; ?>" style="background:rgba(150,150,150,0.7)" max="600" min="200"><input type="text" class="output4" onkeydown="range8()" style="color:rgba(150,150,150,0.7)">
                    </div>
                    <?php } ?>
                    </form>
                </div>
            </div>
            </div>
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
            <div class="allsub">
                <h1>Читатели блога<span class="closenotes" onclick="shownotes2()">Закрыть</span></h1>
                <?php
                    # Выбираем мой id
                    $query = "SELECT id from users WHERE login='".$_SESSION['login']."'";
                    $result = $conn->query($query);
                    $myid = $result->fetch_array()['id'];
                                
                    # Выбираем id страницы
                    $query = "SELECT id from users WHERE login='".$mainlog."'";
                    $result = $conn->query($query);
                    $pageid = $result->fetch_array()['id'];
                    
                    # Выбираем наших подписчиков
                    $query = "SELECT * from subscribes WHERE userid='".$pageid."'"; 
                    $result = $conn->query($query);
                    $rows = $result->num_rows;
                    print('<div class="subcontent">');
                    for($j = 0;$j < $rows;$j++) { 
                        $result->data_seek($j);
                        $query2 = "SELECT * from users WHERE id='".$result->fetch_array()['subscriberid']."'";
                        $result2 = $conn->query($query2);
                        $result2->data_seek(0);
                        $user = $result2->fetch_array()['email'];
                        $result2->data_seek(0);
                        $userlog = $result2->fetch_array()['login'];
                        $query2 = "SELECT * from design WHERE login='".$userlog."'";
                        $result2 = $conn->query($query2);
                        $result2->data_seek(0);
                        $form = $result2->fetch_array()['avatarform'];
                        $user = str_replace('.', '', $user);
                        $user = str_replace('@', '', $user);
                        print('<div width="60" height="60" style="background:url(avatar/'.md5('avatar'.$user).'.jpg);background-size:cover;background-position:center;width:55px;height:55px;border-radius:50px;margin:10px 0;border-radius:'.$form.';display:inline-block;margin-right:10px;cursor:pointer;" onclick="location.href=\''.$userlog.'.php\'" title="'.$userlog.'"></div>');
                    }
                print('</div>');
                ?>
            
            </div>
            <div id="header">
                <div class="blackfon" style="background:linear-gradient(to bottom,rgba(0,0,0,0.3),rgba(0,0,0,0.07))"></div>
                <h1><a href="index.php" class="logo">LS</a></h1>
                <div class="findblog">
                    <form id="findblogform" method="post" onsubmit="return false;">
                        <img src="314478-24.png"><input type="text" placeholder="Поиск в <?php echo $mainlog ?>..." name="findblog" onkeydown="findblogs('<?php echo $userid; ?>')" onclick="findblogs('<?php echo $userid; ?>')" type="search" maxlength="400" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" aria-autocomplete="list">
                        <div class="findblognote"></div>
                    </form>
                </div>
                
                <?php if($mainlog == $_SESSION['login']) { ?>
                <a href="javascript:void(0)" onclick="settings()">
                    <img src="https://png.icons8.com/windows/25/ffffff/settings.png"> <span class="headerspan"></span>
                </a>
                <?php } 
                if($_SESSION['email'] != 123313) {
                ?>
                
                <a href="javascript:void(0)" onclick="notification()">
                    <span style="position:relative;"><img src="https://png.icons8.com/windows/25/ffffff/appointment-reminders.png"><?php echo $rowsnotification; ?></span><span class="headerspan"></span>
                </a>

                <a href="message.php">
                    <span style="position:relative;"><img src="https://png.icons8.com/windows/25/ffffff/sms.png"><?php echo $rowst; ?></span><span class="headerspan"></span>
                </a>

                <a href="index.php">
                    <img src="https://png.icons8.com/windows/25/ffffff/home.png"> <span class="headerspan"></span>
                </a>
                <?php } else {?>
                <div class="enterg" onclick="location.href='index.php'">Войти</div>
                <div class="sign" onclick="location.href='register.php'">Зарегистрироваться</div>
                <?php } ?>
            </div>
            <div class="notifbox">
                <div class="noth1">Ваши уведомления <span id="shownotes" onclick="shownotes()">Показать все</span></div><hr>
                <ul>
                    <script> notificationupdate(); </script>
                </ul>
            </div>
            <div class="house">
                <?php
                    if($scheme == '3') {
                        $padding = $backsize - 30;
                        if($padding < 0) {
                            $padding = $padding * -1;
                        }
                        print('<style>
                        .background {
                            height: '.$backsize.'px;
                        }
                        
                        .allbox {
                            padding-top:'.$padding.'px;
                        }
                        
                        </style>');
                    }
                    if($scheme == '2') {
                        $padding = $backsize + 110;
                        if($padding < 0) {
                            $padding = $padding * -1;
                        }
                        print('<style>
                        .background {
                            height: '.$backsize.'px;
                        }
                        
                        .infoavatar {
                            top: 105%!important;
                        }
                        
                        .allbox {
                            padding-top:'.$padding.'px;
                        }
                        
                        </style>');
                        if($mainlog != $_SESSION['login']) {
                            $padding2 = $padding + 40;
                            print('<style>
                                .allbox {
                                    padding-top:'.$padding2.'px;
                                }
                            </style>');
                        }
                    }
                    $br = '<br>';
                    if($scheme == '1') {
                        $padding = $backsize - 10;
                        if($padding < 0) {
                            $padding = $padding * -1;
                        }
                        print('<style>
                        .background {
                            height: '.$backsize.'px;
                        }
                        
                        .infoavatar {
                            top: 55%;
                            left:30px;
                            margin:0;
                            width:90%;
                            text-align:left;
                        }
                        
                        .description {
                            width:500px;
                            text-align:left;
                            padding-left: 3px;
                        }
                        
                        .titlein {
                            width:500px;
                            text-align:left;
                        }
                        
                        .avatar {
                            display:inline-block;
                        }
                        
                        .allbox {
                            padding-top: '.$padding.'px;
                        }
                        .titledescription {
                            width: 500px;
                            display: inline-block;
                            vertical-align: top;
                            position: relative;
                            top:10px;
                            left: 20px;
                        }
                        
                        </style>');
                        $br = '';
                    }
                ?>
                <div class="background" style="<?php echo $booltrans; ?>">
                    <?php 
                        if($mainlog == $_SESSION['login']) {
                            if(is_file('background/'.md5('background'.$emailformy).'.jpg')) 
                            print('<style> .background {background: url(background/'.md5('background'.$emailformy).'.jpg?r'.rand().') center center / cover no-repeat;} </style>');
                        }
                       else {
                            if(is_file('background/'.md5('background'.$emailfor).'.jpg')) 
                            print('<style> .background {background: url(background/'.md5('background'.$emailfor).'.jpg?r'.rand().') center center / cover no-repeat;} </style>');
                       }
               
                    ?>
                    <div class="blackfon" style="<?php echo $booltrans; ?>">
                        <div class="change"><input type="file" id="filing" style="display:none;">
                            <?php if($mainlog == $_SESSION['login']) {  ?>
                            <div class="help helpdel">Изменить обложку</div>
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAHgSURBVEhL7ZU/S5tRGMXToYo6BJRCpRCc1E2lUJcW1zhIPoBO8Q+IIHQTdC1UwWJouzqIk3RxLP0ELgrq0Kr9CnUSQSVvf+e+h+BtQnxjRnvgcLm/c+7zgCYk93RUrVbH8KckSfb+tbhyVx8nBkzhO3yD/zSwuPIpP2ldPD7HP/ELo0jizs+MHhbld3iNP8VHzgqntOK4oZSrRH+LQ+/WNMdxLIINle8L9gv3u9JQ5K/U85OaYOuupIKNAqUd3Gf8KOk93tUwNGIcgrl0fzJsVCeybnqTuIyLujuqk+ZoGL1Zo7BkURAVjCLBF+hcppVU3PXpmnclEnHBnUWj5kvI3ivgPMHT+A2ewafmy67WpDnOHl4C1z/1Gh/gTuMg3c2vePfSOEhzNIws05Il87dGkcgnFEbDEKilJZuCnD1GkcSdbxoFaY55piX6Yqo8aBQJPuR81ShIc8wzLRkX5KwYRYJ/Ca+S5LVREPfsSySyfSx9wF1mXb5L30LxnjRHw8iyLYHlyb8r5LzFFzp9F8+7WhOs6ZIBo0jwZ3RKeFuDfZbEXYmkORpGJ1oyaVg2akua43lFo7C5A3CE9QP0g3vdr2BW673nHHJ/7hWpgL34Kz7Gv9uw3n/GvR79X60ol/sL+guHu1XTG+MAAAAASUVORK5CYII=" onclick="background();" style="cursor:pointer;">
                            <?php } ?>
                        </div>
                        <?php 
                            $avatar123 = md5('avatar'.$emailfor).'.jpg';
                            if(is_file('avatar/'.$avatar123)) {
                                $avatar='width:'.$desavatarsize.'px;height:'.$desavatarsize.'px;border-radius:'.$avaform.';background:url(avatar/'.$avatar123.'?id=12312);background-size:cover;background-position:center;'.$bool;
                            } 
                            else {
                                $avatar= "width:".$desavatarsize."px;height:".$desavatarsize."px;border-radius:".$avaform.";background:url(avatar/123123.jpg?id=12312);background-size:cover;background-position:center;".$bool;
                            }
                        ?>
                        <div class="infoavatar">
                            <?php if($notlog == 1) { ?>
                                <div class="avatar" title="Аватар пользователя <?php echo $mainlog; ?>" style="top:<?php echo $toppx; ?>px;left:<?php echo $leftpx; ?>px;<?php echo $avatar; ?>cursor:default;"></div><?php echo $br; ?>
                            <?php } else {?>
                                <div class="avatar" style="top:<?php echo $toppx; ?>px;left:<?php echo $leftpx; ?>px;<?php echo $avatar; ?>"></div><?php echo $br; ?>
                            <?php } ?>
                            <div class="titledescription">
                            <div class="titlein" style="top:<?php echo $toppxh1 ?>px;left:<?php echo $leftpxh1 ?>px;"><h1 style="font-size:<?php echo $blogsize; ?>px;font-family:'<?php echo $font; ?>';color:#<?php echo $color; ?>"><?php echo $blogname; ?></h1>
                            </div>
                            <div class="description" style="top:<?php echo $toppxp ?>px;left:<?php echo $leftpxp ?>px;"><p style="font-size:<?php echo $descriptionsize; ?>px"><?php echo $description; ?></p></div>
                            <?php if($notlog != 0) { 
                                $query = "SELECT * FROM subscribes WHERE userid='".$userid."' AND emailsubscriber='".$emailformy."'"; 
                                $result = $conn->query($query);
                                if (!$result) die ($conn->error);
                                $rows = $result->num_rows;
                                $toppxp = $toppxp - 7;
                                if($rows == 1) {
                                    print('<div class="following abcd1" style="top:'.$toppxp.'px;left:'.$leftpxp.'px;"><a href="javascript:void(0)" id="follow'.$userid.'" class="youcheck" onclick="deletesub(\''.$userid.'\')" onmouseover="$(this).html(\'Не читать?\')" onmouseout="$(this).html(\'Вы читаете\')">Вы читаете</a></div>');
                                }
                                else {
                                    print('<div class="following" style="top:'.$toppxp.'px;left:'.$leftpxp.'px;"><a href="javascript:void(0)" onclick="subscribe(\''.$userid.'\')" id="follow'.$userid.'"><img src="https://png.icons8.com/windows/15/ffffff/plus.png">Читать</a></div>');
                                } 
                        } ?>
                            </div>
                        </div>
                        <!--
                        <div class="subscribers">
                            <div class="sub sub1"><?php echo $subuserrows; ?><br><span><?php print(right($subuserrows,1)); ?></span></div>
                            <div class="sub"><?php echo $noterows; ?><br><span><?php print(right($noterows,2)); ?></span></div>
                            <div class="sub sub3"><?php echo $suburows; ?><br><span><?php print(right($suburows,3)); ?></span></div>
                        </div>
                        -->
                    </div>
                <input type="file" name="avatar" style="display:none;" id="avatar">
                </div>
                <div class="allbox">
                    <?php
                        # Выбираем мой id
                        $query = "SELECT * from design WHERE login='".$mainlog."'";
                        $result = $conn->query($query);
                        $category = $result->fetch_array()['category'];
                        if($descript == '') {
                            $descript = 'Не указано';
                        }
                    ?>
                    <div class="infobox">
                        <h2><img src="https://png.icons8.com/windows/20/999999/info.png"> Информация о блоге</h2><hr>
                        <div style="margin:10px 0;">
                        <span>Тематика блога:</span>&nbsp;&nbsp;<?php echo $category; ?><br>
                        <div style="padding-top:5px;">
                            <span>Описание блога:</span>&nbsp;&nbsp;<span class="description2"><?php echo $descript; ?></span>
                        </div>
                        </div>
                    </div><br>
                    <?php
                    
                    # Выбираем мой id
                    $query = "SELECT id from users WHERE login='".$_SESSION['login']."'";
                    $result = $conn->query($query);
                    $myid = $result->fetch_array()['id'];
                                
                    # Выбираем id страницы
                    $query = "SELECT id from users WHERE login='".$mainlog."'";
                    $result = $conn->query($query);
                    $pageid = $result->fetch_array()['id'];
                    
                    # Выбираем наших подписчиков
                    $query = "SELECT * from subscribes WHERE userid='".$pageid."'"; 
                    $result = $conn->query($query);
                    $rows = $result->num_rows;
                    print('<div class="subscribersline"><h2 style="cursor:pointer;" onclick="shownotes2()"><img src="https://png.icons8.com/windows/20/999999/user-male-circle.png"> Читатели блога <span>'.$rows.'</span></h2><hr>');
                    for($j = 0;$j < $rows;$j++) { 
                        $result->data_seek($j);
                        $query2 = "SELECT * from users WHERE id='".$result->fetch_array()['subscriberid']."'";
                        $result2 = $conn->query($query2);
                        $result2->data_seek(0);
                        $user = $result2->fetch_array()['email'];
                        $result2->data_seek(0);
                        $userlog = $result2->fetch_array()['login'];
                        $query2 = "SELECT * from design WHERE login='".$userlog."'";
                        $result2 = $conn->query($query2);
                        $result2->data_seek(0);
                        $form = $result2->fetch_array()['avatarform'];
                        $user = str_replace('.', '', $user);
                        $user = str_replace('@', '', $user);
                        print('<div width="60" height="60" style="background:url(avatar/'.md5('avatar'.$user).'.jpg);background-size:cover;background-position:center;width:55px;height:55px;border-radius:50px;margin:10px 0;border-radius:'.$form.';display:inline-block;margin-right:10px;cursor:pointer;" onclick="location.href=\''.$userlog.'.php\'"></div>');
                    }
                    print('</div><br>');
                    $query = "SELECT * from news WHERE login='".$mainlog."' AND reblog='' OR reblog='".$mainlog."' order by id DESC LIMIT 5"; 
                    $result = $conn->query($query);
                    $rows = $result->num_rows;
                for($j = 0;$j < $rows;$j++) {
                    $result->data_seek($j);
                    # Смотрим сколько лайков у записи
                    $queryn = "SELECT * from likes WHERE noteid='".$result->fetch_array()['id']."'"; 
                    # Пока моего лайка не стоит
                    $del = 0;
                    $resulta = $conn->query($queryn);
                    if (!$resulta) die ($conn->error);
                    $likes = $resulta->num_rows;
                
                    for($i = 0;$i < $likes;$i++) {
                        $resulta->data_seek($i); 
                            # Если мой емаил совпадает с емаилом в лайках
                            if($emailformy == $resulta->fetch_array()['email']) {
                                # Мой лайк стоит
                                $del = 1;
                            }
                    }
                    $result->data_seek($j);
                
                    # С какого дневника запись
                    $diarid1 = $result->fetch_array()['diar'];
                
                    $result->data_seek($j); 
                
                    # id записи
                    $id = $result->fetch_array()['id'];
                    $query2 = "SELECT * from news WHERE realid='".$id."' AND reblog !='' "; 
                    $result2 = $conn->query($query2);
                    $repcount = $result2->num_rows;
                    # Если мой лайк не стоит
                    if($del == 0) {
                        $divlike = '<span class="like like'.$id.'" onclick="like(\''.$id.'\'); changelike(\''.$id.'\');"><span class="likef likef'.$id.'"><span class="likefcount'.$id.'">'.$likes.'</span> '.likegram($likes).'</span><span class=" imglike'.$id.'"><img src="https://png.icons8.com/windows/21/000000/hearts.png"></span>&nbsp;</span>';
                    }
                    # Если мой лайк стоит
                    else {
                        $divlike = '<span class="like like'.$id.'" onclick="like(\''.$id.'\'); changelike2(\''.$id.'\');"><span class="likef likef'.$id.'"><span class="likefcount'.$id.'">'.$likes.'</span> '.likegram($likes).'</span><span class=" imglike'.$id.'"><img src="https://png.icons8.com/color/20/000000/filled-like.png"></span>&nbsp;</span>';
                    }
                
                    $result->data_seek($j); 
                    $email = $result->fetch_array()['email'];
                    $emailforuser = str_replace('.', '', $email);
                    $emailforuser = str_replace('@', '', $emailforuser);
                    $result->data_seek($j); 
                    $name = $result->fetch_array()['name'];
                    $result->data_seek($j); 
                    $reblog = $result->fetch_array()['reblog'];
                    $result->data_seek($j); 
                    $sod = $result->fetch_array()['sod'];
                    $result->data_seek($j); 
                    $factdate = $result->fetch_array()['factdate'];
                    $result->data_seek($j); 
                    $tags = $result->fetch_array()['tags'];
                    $result->data_seek($j); 
                    $lock = $result->fetch_array()['locked'];
                    $result->data_seek($j); 
                    $commentbool = $result->fetch_array()['comments'];
                    $result->data_seek($j); 
                    $login = $result->fetch_array()['login'];
                    $result->data_seek($j); 
                    $realid = $result->fetch_array()['id'];
                    $result->data_seek($j); 
                    $realidreal = $result->fetch_array()['realid'];
                    if($reblog != '') {
                        $result->data_seek($j);
                        $realid = $result->fetch_array()['realid'];
                    }
                    
                    # Узнаем сколько у записи комментариев
                    $querys = "SELECT * from comments WHERE noteid='".$id."' order by id DESC"; 
                    $results = $conn->query($querys);
                    $commentrows = $results->num_rows;
                    $commentrowsfalse = $commentrows;
                
                    # Не больше 3 комментариев
                    $morecom = 0;
                    
                    # Если комментариев больше 3 показываем что можно посмотреть больше
                    if($commentrows > 3) {
                        $querys = "SELECT * from comments WHERE noteid='".$id."' order by id DESC Limit 3"; 
                        $results = $conn->query($querys);
                        $commentrows = $results->num_rows;
                        $commentrowsfalse = $commentrowsfalse - $commentrows;
                        $morecom = 1;
                    }
                    $avatar = md5('avatar'.$email).'.jpg';  
                    $deleten = '';
                
                    # Проверяем аватар пользователя
                    if(is_file('avatar/'.$avatar)) {
                        $avatarphoto = 'avatar/'.$avatar;
                    }
                    else {
                        $avatarphoto = 'avatar/123123.jpg';
                    }
                    $divtags = '';
                    # Есть ли теги
                    if($tags == '') {
                        $divtags = '';
                    }
                    else {
                        $array = explode(' ',$tags);
                        $resultarray = count($array);
                        
                        for($l=0;$l<$resultarray;$l++) {
                            if($l!=($resultarray)) {
                                if($array[$l] != '') {
                                    $divtags = $divtags.'<span class="hash">#'.$array[$l].'</span> ';
                                }
                            }
                            
                        }
                        $divtags = '<div class="tags"><span>'.$divtags.'</span></div>';
                    }
                    
                    # Есть ли содержимое
                    if($sod == '' || $sod == '<p><br></p>') {
                        $divsod = "";
                        $hr="";
                    }
                    else {
                        $divsod = '<div id="namenote'.$id.'">'.$sod.'</div>';
                        $hr="<hr>";
                        $hr2 = "<hr>";
                    }
                    
                    # Есть ли заголовок
                    if($name == "") {
                        $h1_name = "";
                        print('<style>#namenote'.$id.' {padding-top: 10px !important;padding-bottom: 0 !important;}</style>');
                    }
                    else {
                        $h1_name = '<h1>'.$name.'</h1>';
                        $hr= '<hr>';
                    }
                    
                    # Если это моя запись, я могу ее удалить
                    if($login == $_SESSION['login'] || $reblog == $_SESSION['login']) {
                        $deleten = '<div class="help helpdelete">Удалить запись</div><img src="https://png.icons8.com/windows/20/666666/delete-sign.png" onclick="deletenewsconfirm(\''.$id.'\');" style="cursor:pointer;">';
                        if($lock == 'false' || $lock == '') {
                            $block = '';
                        }
                        else {
                            $block = '<img src="https://png.icons8.com/windows/20/666666/lock-2.png">';
                        }
                    }
                    else {
                        if($lock == 'false' || $lock == '') {
                            $block = '';
                        }
                        else {
                            $block = '';
                        }
                        $deleten = '';
                    }
                    
                    # Нормальное понятие даты
                    $factdate = notdate($factdate);
                    
                    # Узнаем наш id
                    $query8 = "SELECT id from users WHERE login='".$_SESSION['login']."'";
                    $result8 = $conn->query($query8);
                    $myligo = $result8->fetch_array()['id'];
                    
                    # Узнаем id этого пользователя
                    $query8 = "SELECT id from users WHERE login='".$login."'";
                    $result8 = $conn->query($query8);
                    $ligo = $result8->fetch_array()['id'];
                    
                    # Узнаем сколько у него подписчиков
                    $query8 = "SELECT * from subscribes WHERE userid='".$ligo."'";
                    $result8 = $conn->query($query8);
                    $countsub = $result8->num_rows;
                    
                    # Узнаем сколько у него записей
                    $query8 = "SELECT * from news WHERE login='".$login."'";
                    $result8 = $conn->query($query8);
                    $countnote = $result8->num_rows;
                        
                    # Узнаем описание
                    $query8 = "SELECT * from design WHERE login='".$login."'"; 
                    $result8 = $conn->query($query8);
                    $result8->data_seek(0);
                    $description = $result8->fetch_array()['description'];
                    if($description == '') {
                        $description = 'Описание не указано';
                    }
                    $result8->data_seek(0);
                    $blogname = $result8->fetch_array()['blogname'];
                    if($blogname == '') {
                        $blogname = $login;
                    }    
                
                    # Узнаем подписан ли я
                    $query8 = "SELECT * from subscribes WHERE userid='".$ligo."' AND subscriberid='".$myligo."' order by count DESC"; 
                    $result8 = $conn->query($query8);
                    $rows8 = $result8->num_rows;
                    
                    # По умолчанию не подписан
                    $subconfirm = '<div class="userboxsub" style="font-size:12px;">Вы не подписаны</div>';
                    
                    # Если нашлась строка, значит я подписан
                    if($rows8 != 0) {
                            $subconfirm = '<div class="userboxsub" style="font-size:14px;">Вы подписаны</div>';
                    }
                    else {
                        if($login == $_SESSION['login']) {
                            $subconfirm = '<div class="userboxsub">Это вы</div>';
                        }
                    }
                    
                    # Проверяем есть ли обложка
                    if(is_file('background/'.md5('background'.$emailforuser).'.jpg')) {
                        $background = 'background/'.md5('background'.$emailforuser).'.jpg';
                    }
                    else {
                        $background = 'sunrise-1014711_1920.jpg';
                    }
                    
                    # Выводим обложку
                    $usercover = '<div class="usercover" style="background-image:url(\''.$background.'\');background-size:cover;background-position:center;"><div class="backfon"><div class="userph" style="background-image:url(\'avatar/'.md5('avatar'.$emailforuser).'.jpg\');background-size:cover;background-position:center;"></div></div></div><div class="allusbox"><div class="usersubline"></div><div class="usersodline"><h1>'.$blogname.'</h1><p>'.$description.'<br><span><a href="'.$login.'.php">https://listsend.ru/'.$login.'</a></span></p></div><div class="userinfoline"></div><div class="usersubscline"><div class="usersubsc" style="margin-right:10px;"><span>Подписчиков</span><br>'.$countsub.'</div><div class="usersubsc" style="margin-left:10px;"><span>Записей</span><br>'.$countnote.'</div></div>'.$subconfirm.'</div>';
                        $div = '';
                        $countimg = 0;
                        for($m=0;$m<10;$m++) {
                            # Возможное фото в записи
                            $imgname = $m.md5($realid).'.jpg';
                            # Если оно есть, выводим
                            if(is_file('noteimage/'.$imgname)) {
                                $div = $div.'<img src="noteimage/'.$imgname.'" width="100%">';
                                $countimg = $countimg+1;
                            }
                        }
                        if($countimg == 0) {
                            $div = '';
                        }

                        else {
                            $div = '<div class="notephoto">'.$div.'</div>';
                            if($tags == '') {
                                $hr2 = "";
                            }
                            else {
                                $hr2 = "<hr>";
                            }
                        }
                    if($mainlog != $_SESSION['login'] && $lock == 'true' || $_SESSION['email'] == 123313 && $lock == 'true') {
                        
                    }
                    else {
                    # Выводим запись
                    print('
                            <div class="box-line" id="note'.$id.'" style="animation:show 1s ease;">');
                            if($reblog == $mainlog) {
                                print('<div class="reblog"><img src="https://png.icons8.com/windows/15/000000/data-in-both-directions.png"><a href="'.$reblog.'.php" style="color:rgba(0,0,0,0.7);">'.$reblog.'</a> поделился(ась) записью</div><hr>');
                            }
                            print('
                                    <div id="boxheader">
                                        <div class="avatarimg" id="avataruser'.$id.'" style="background-image:url(\''.$avatarphoto.'\');cursor:pointer;" onmouseover="userprofile3(\''.$id.'\');" onmouseout="userprofile4(\''.$id.'\')"><div class="user" id="user'.$id.'"><div class="coverus"></div>'.$usercover.'</div></div>
                                        <span>'.$blogname.'</span><span class="lock">'.$block.'</span>
                                        <span class="deletenews">'.$deleten.'</span>
                                        <span class="date">'.$factdate.'</span>
                                    </div><div style="position:relative;"><div class="tolike tolike'.$id.'"><img src="icons8-love-100.png"></div>'.$hr.$h1_name.$divsod.$div.$divtags.$hr2.'</div><div class="likes"><div class="number"><span class="span"></div><div class="allinlikes">'.$divlike.'<span onclick="docom(\''.$id.'\')" class="commenty"><span class="comf" id="komnum"><span class="countcomf'.$id.'">'.$commentrows.'</span> '.comgram($commentrows).'</span><img src="https://png.icons8.com/metro/16/333333/topic.png" style="top:3px;">&nbsp;&nbsp;</span><span onclick="repostconfirm(\''.$id.'\')" class="repost"><span class="repf"><span class="countrepf">'.$repcount.'</span> '.repgram($repcount).'</span><img src="https://png.icons8.com/material/21/333333/refresh.png">&nbsp;&nbsp;</span></span></div></div><br>');
                if($_SESSION['email'] != 123313) {
                    # Выводим блок с комментариями
                    print('<div class="blockcomments"><hr><div class="allcom'.$id.'">'); 
                    # Если есть больше комментариев чем 3, говорим что можно посмотреть еще
                    if($morecom == 1) {
                        print('<div class="morecom"><span onclick="showmorecom(\''.$id.'\')">Показать остальные комментарии ('.$commentrowsfalse.')</span></div><hr>');
                    }
                    # Проверяем есть ли у нас автара
                    $myavatarcoment = md5('avatar'.$emailformy).'.jpg';    
                    if(is_file('avatar/'.$myavatarcoment)) {
                            $myavatarphotocoment = 'avatar/'.$myavatarcoment;
                    }
                    else {
                            $myavatarphotocoment = 'avatar/123123.jpg';
                    }
                    
                    
                    for($i = $commentrows-1;$i >= 0;$i--) {
                            $results->data_seek($i); 
                            $logincom = $results->fetch_array()['login'];
                            $results->data_seek($i); 
                            $sod = $results->fetch_array()['sod'];
                            $results->data_seek($i); 
                            $comentemail = $results->fetch_array()['email'];
                            $results->data_seek($i); 
                            $idcom = $results->fetch_array()['id'];
                            $results->data_seek($i); 
                            $datecom = notdate($results->fetch_array()['date']);
                            if($datecom == 'fall') {
                                $results->data_seek($i); 
                                $datecom = $results->fetch_array()['date'];
                            }
                            # Узнаем сколько лайков у комментария
                            $query3 = "SELECT * FROM likes WHERE noteid='com".$idcom."'"; 
                            $result3 = $conn->query($query3);
                            $rows3 = $result3->num_rows;
                            if($rows3 == 0) {
                                $rows3 = '';
                            }
                        
                            # Узнаем есть ли у владельца комментария аватар
                            $avatarcoment = md5('avatar'.$comentemail).'.jpg';    
                            if(is_file('avatar/'.$avatarcoment)) {
                                $avatarphotocoment = 'avatar/'.$avatarcoment;
                            }
                            else {
                                $avatarphotocoment = 'avatar/123123.jpg';
                            }
                            
                            # По умолчанию не надо жаловаться, потому что это мой комментарий
                            $fals = '';
                            
                            # По умолчанию можно удалить комментарий
                            $delcomm = '<span class="delcomm"><img src="https://png.icons8.com/windows/20/666666/trash.png" style="cursor: pointer;" onclick="delcomm(\''.$idcom.'\');"></span>';
                            
                            # Если комментарий не мой, то можно пожаловаться, но удалить нельзя
                            if($logincom != $_SESSION['login']) {
                                $fals = '<span>Пожаловаться</span>';
                                $delcomm = '';
                            }
                            
                            # Я не поставил лайк комментарию
                            $del = 0;
                            for($b = 0;$b < $rows3;$b++) {
                                $result->data_seek($b); 
                                # Я поставил лайк
                                if($emailfor == $result3->fetch_array()['email']) {
                                    $del = 1;
                                }
                            }   
                            
                            # Если я не поставил, то нужно поставить
                            if($del == 0) {
                                $likespan='<span id="imgcomlike'.$idcom.'"  onclick="commentlike(\''.$idcom.'\');changelike3(\''.$idcom.'\')"><img src="https://png.icons8.com/metro/17/666666/like.png"></span>';
                            }
                            # Если я поставил, то нужно удалить
                            else {
                                $likespan='<span id="imgcomlike'.$idcom.'"  onclick="commentlike(\''.$idcom.'\');changelike4(\''.$idcom.'\')"><img src="https://png.icons8.com/material/17/666666/filled-like.png"></span>';
                            }
                        
                            # Выводиm комментарий
                            print('<div class="comment" id="comment'.$idcom.'"><div style="background-image:url('.$avatarphotocoment.');background-size:cover;background-position:center;" class="comimglog"></div><div class="commenttitle"><span id="comid'.$idcom.'">'.$logincom.'</span>'.$delcomm.'<span class="titledate">'.$datecom.'</span></div><p>'.$sod.'</p><div class="rewrite"><span onclick="reply(\''.$idcom.'\',\''.$id.'\')" style="cursor:pointer;">Ответить</span>'.$fals.'<span class="comlike"><span class="likecomnum likecomnum'.$idcom.'">'.$rows3.'</span>'.$likespan.'</span></div><hr></div>');
                    }
                    
                    # Выводим форму для отправки комментария
                    if($commentbool != 'true') {
                    # Выводим форму для отправки комментария
                    print('</div><div class="sendcomment"><div class="comimgmylog" style="background-image:url('.$myavatarphotocoment.');background-size:cover;background-position:center;"></div><form name="comment" id="formcomment" class="commentsend'.$id.'"><textarea placeholder="Прокомментируйте запись..." class="textarea'.$id.'" id="sendcomment" name="sendcomment" onclick="showsend(\''.$id.'\')"></textarea></form><div class="sendhide sends'.$id.'"><hr><span id="comins'.$id.'"></span><input type="submit" name="commentsend" onclick="commentsend(\''.$id.'\');"></div></div></div>');
                        print('</div><br>');
                    }
                    else {
                        print('</div></div></div><br>');
                    }

                    
                    
                }
                else {
                    print('</div><br>');
                }
                        }
                    
            } 
                        
                ?>
                </div>
                <!--
                <div class="friends"><h1>Подписчики</h1><hr>
                        <ul>
                            <?php 
                                /*# Выбираем мой id
                                $query = "SELECT id from users WHERE login='".$_SESSION['login']."'";
                                $result = $conn->query($query);
                                $myid = $result->fetch_array()['id'];
                                
                                # Выбираем id страницы
                                $query = "SELECT id from users WHERE login='".$mainlog."'";
                                $result = $conn->query($query);
                                $pageid = $result->fetch_array()['id'];
                                
                                # Выбираем наших подписчиков
                                $query = "SELECT * from subscribes WHERE userid='".$pageid."'"; 
                                $result = $conn->query($query);
                                $rows = $result->num_rows;    
                            
                                # Выводим 4 последних
                                if($rows > 3) {
                                    $rows = 4;
                                }
                                for($j = 0; $j < $rows; $j++) {
                                    
                                    # Я не подписан
                                    $answer = 0;
                                    
                                    $result->data_seek($j);
                                    
                                    # Пользователь с текущим id
                                    $query3 = "SELECT * from subscribes WHERE userid='".$result->fetch_array()['subscriberid']."'"; 
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
                                            # Я не подписан
                                            $answer = 1;
                                        }
                                        
                                    }

                                    $result->data_seek($j);
                                    $userid = $result->fetch_array()['subscriberid'];
                                    
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
                                            $divsubs = '';
                                        }
                                    }
                                    # Не нужно кнопок
                                    else {
                                        $divsubs = '';
                                    }
                                    
                                    $result->data_seek($j);
                                    
                                    # Узнать логин и E-Mail пользователя
                                    $query2 = "SELECT * from users WHERE id='".$result->fetch_array()['subscriberid']."'";
                                    $result2 = $conn->query($query2);
                                    $user = $result2->fetch_array()['login'];
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
                                    
                                    # Узнать сколько постов у пользователя
                                    $query2 = "SELECT * from news WHERE login='".$user."'";
                                    $result2 = $conn->query($query2);
                                    $countnote = $result2->num_rows;  
                                    
                                    # По умолчанию я не подписан
                                    $subconfirm = '<div class="userboxsub" style="font-size:12px;">Вы не подписаны</div>';
                                    
                                    # Если я подписан, то вывести это
                                    if($answer != 0) {
                                            $subconfirm = '<div class="userboxsub" style="font-size:14px;">Вы подписаны</div>';
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
                                        $background = 'background/landscape-914148_1920.jpg';
                                    }
                                    
                                    # Собрать в кучу информацию о пользователе
                                    $usercover = '<div class="usercover" style="background-image:url(\''.$background.'\');background-size:cover;background-position:center;"><div class="backfon"><div class="userph" style="background-image:url(\'avatar/'.md5('avatar'.$emailnot).'.jpg\');background-size:cover;background-position:center;"></div></div></div><div class="allusbox"><div class="usersubline"></div><div class="usersodline"><h1>'.$user.'</h1><p>Лучший канал про животных и все остальное<br><span><a href="'.$user.'.php">https://listsend.ru/'.$user.'</a></span></p></div><div class="userinfoline"></div><div class="usersubscline"><div class="usersubsc" style="margin-right:10px;"><span>Подписчиков</span><br>'.$countsub.'</div><div class="usersubsc" style="margin-left:10px;"><span>Записей</span><br>'.$countnote.'</div></div>'.$subconfirm.'</div>';
                                    
                                    # Вывести список
                                    print('<li id="userli'.$userid.'" onmouseout="userprofile2(\''.$userid.'\');"><div style="background:url('.$avatarsphoto.');background-size:cover;background-position:center;width:35px;height:35px;display:inline-block;border-radius:100px;position:relative;top:2px;cursor:pointer;" class="imgloguser" onclick="document.location.href = \''.$user.'.php\'" onmouseover="userprofile(\''.$userid.'\');" onmouseout="userprofile2(\''.$userid.'\')"><div class="user" id="user'.$userid.'">'.$usercover.'</div></div><span class="userlogin"><a href="'.$user.'.php">'.$user.'</a></span>'.$divsubs.'</li>');
                            }*/
                        ?>
                    </ul>
                </div>-->
            </div>
            <div class="scroolup"><img src="https://png.icons8.com/windows/40/888888/circled-up-2.png"></div>
        </div>
        </div>
        <script type="text/javascript" src="main.js"></script>
        <script type="text/javascript">
            message();
            $('.black').on('click',function(){
                $('.allnote').toggleClass('block'); 
            });
            $(document).mouseup(function (e){ // событие клика по веб-документу
                var div = $(".sendhide"); // тут указываем ID элемента
                if (!div.is(e.target) // если клик был не по нашему блоку
                    && div.has(e.target).length === 0) { // и не по его дочерним элементам
                    div.css({'display':'none'}); // скрываем его
                }
                $('.scroolup').click(function (){
                    $('.main').animate({
                        scrollTop:10
                    }, 800);
                    return false;
                });
            });
            $('.main').scroll(function() {
                if  ($('.main').scrollTop() > $('.allbox').height()-700) 
                 {
                    downloadblog();
                 }
                if ($(this).scrollTop() > 400){
                    $('.scroolup').fadeIn();
                } else{
                    $('.scroolup').fadeOut();
                }
            });
            
            $(document).ready(function(){
                $('#colorpicker').farbtastic('.colorcircle, #pick2');
                $('#colorpicker2').farbtastic('.colorcircle2, #pick1');
                autosize( $('textarea') );
            }); 
            $('.background').css({top:'0'});
            $('.output').val($('#range').val());
            $('.output2').val($('#range2').val());
            $('.output3').val($('#range3').val());
            $('.output4').val($('#range4').val());
        </script>
        <?php
            if($scheme == '4') {
                print('<script type="text/javascript">
                $(".main").on("scroll", function() {
                    if ($(this).scrollTop() > 0) {
                        $(".background").css({"top":"-100%"});
                    }
                    if($(this).scrollTop() == 0) {
                        $(".background").css({"top":"0"});
                    }
                });
                </script>');
            }
            if($scheme == '3') {
                print('<script type="text/javascript">
                $(".main").on("scroll", function() {
                    if ($(this).scrollTop() > 0) {
                        $(".background").css({"top":"-100%"});
                        $(".allbox").css({"padding-top":"150px"});
                    }
                    if($(this).scrollTop() == 0) {
                        $(".background").css({"top":"0"});
                        $(".allbox").css({"padding-top":"370px"});
                    }
                });
                </script>');
            }
            if($scheme == '2') {
                print('<script type="text/javascript">
                $(".main").on("scroll", function() {
                    if ($(this).scrollTop() > 0) {
                        $(".background").css({"top":"-100%"});
                        $(".allbox").css({"padding-top":"100px"});
                    }
                    if($(this).scrollTop() == 0) {
                        $(".background").css({"top":"0"});');
                if($mainlog == $_SESSION['login']) {
                    print('$(".allbox").css({"padding-top":"'.$padding.'px"});
                    }
                    });
                    </script>');
                }
                else {
                    $padding = $padding + 40;
                    print('$(".allbox").css({"padding-top":"'.$padding.'px"});
                    }
                    });
                    </script>');
                }
                   
            }
            if($scheme == '1') {
                print('<script type="text/javascript">
                $(".main").on("scroll", function() {
                    if ($(this).scrollTop() > 0) {
                        $(".background").css({"top":"-100%"});
                        $(".allbox").css({"padding-top":"100px"});
                    }
                    if($(this).scrollTop() == 0) {
                        $(".background").css({"top":"0"});');
                if($mainlog == $_SESSION['login']) {
                    print('$(".allbox").css({"padding-top":"'.$padding.'px"});
                    }
                    });
                    </script>');
                }
                else {
                    $padding = $padding + 40;
                    print('$(".allbox").css({"padding-top":"'.$padding.'px"});
                    }
                    });
                </script>');
            }
            }
        if($_SESSION['email'] == 123313) {
            print('<script>function like(){location.href="index.php"} function deletesub(){location.href="index.php"} function 
            subscribe(){location.href="index.php"} function repostconfirm(){location.href="index.php"} function docom(){location.href="index.php"} function changelike(){location.href="index.php"}</script>');
        }
        ?>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </body>
</html>
 
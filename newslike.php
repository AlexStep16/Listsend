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

            $_SESSION['boolnews'] = 0;
            $_SESSION['boollike'] = 1;
            $_SESSION['boolsub'] = 0;
            $_SESSION['boolcat'] = 0;
            $_SESSION['boolmynote'] = 0;
            $_SESSION['boolfind'] = 0;
            $_SESSION['boolblog'] = 0;
            $_SESSION['boolblogfind'] = 0;
            $_SESSION['morelikes'] = 5;
            $hr2="<hr>";
            $hr="<hr>";
            $emailfor = str_replace('.', '', $_SESSION['email']);
            $emailfor = str_replace('@', '', $emailfor);
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            if ($conn->connect_error) die($conn->connect_error);
            $query = "SELECT * from likes WHERE email='".$emailfor."' order by id DESC LIMIT 5"; 
            $result = $conn->query($query);
            $rows = $result->num_rows;
            $result->data_seek(0);
            $_SESSION['morelike'] = $result->fetch_array()['id'].' '.'5';
            $dif = 0;
            for($j = 0;$j < $rows;$j++) {
                $result->data_seek($j); 
                if(substr($result->fetch_array()['noteid'],0,3) != 'com') {
                    $result->data_seek($j); 
                    $query2 = "SELECT * from likes WHERE noteid='".$result->fetch_array()['noteid']."'"; 
                    $result2 = $conn->query($query2);
                    $likes = $result2->num_rows;
                    $result->data_seek($j); 
                    $query2 = "SELECT * from news WHERE id='".$result->fetch_array()['noteid']."' AND reblog='' AND locked!='true'";
                    $result2 = $conn->query($query2);
                    $result2->data_seek(0); 
                    $email = $result2->fetch_array()['email'];
                    $result2->data_seek(0); 
                    $name = $result2->fetch_array()['name'];
                    $result2->data_seek(0); 
                    $sod = $result2->fetch_array()['sod'];
                    $result2->data_seek(0);
                    $factdate = $result2->fetch_array()['factdate'];
                    $result2->data_seek(0); 
                    $tags = $result2->fetch_array()['tags'];
                    $result2->data_seek(0); 
                    $login = $result2->fetch_array()['login'];
                    $result2->data_seek(0); 
                    $realid = $result2->fetch_array()['id'];
                    $result2->data_seek(0); 
                    $diarid1 = $result2->fetch_array()['diar'];
                    $result2->data_seek(0); 
                    $id = $result2->fetch_array()['id'];
                    $result2->data_seek(0); 
                    $commentbool = $result2->fetch_array()['comments'];
                    $query3 = "SELECT * from news WHERE realid='".$id."' AND reblog !='' "; 
                    $result3 = $conn->query($query3);
                    $repcount = $result3->num_rows;
                    
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
                    if(is_file('avatar/'.$avatar)) {
                        $avatarphoto = 'avatar/'.$avatar;
                    }
                    else {
                        $avatarphoto = 'avatar/123123.jpg';
                    }
                    $divtags = '';
                    $hr2 = '<hr>';
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
                                    $divtags = $divtags.'<span class="hash" style="cursor:pointer;" id="tag'.$l.$j.'n" onclick="findtag(\''.$l.$j.'n\')">#'.$array[$l].'</span> ';
                                }
                            }
                            
                        }
                        $divtags = '<div class="tags"><span>'.$divtags.'</span></div>';
                        $hr2 = "<hr>";
                    }
                    # Есть ли содержимое
                    if($sod == '' || $sod == '<p><br></p>') {
                        $divsod = "";
                        $hr="";
                    }
                    else {
                        $check = strip_tags($sod);
                        if(mb_strlen($check) >= 800) {
                            $divsod = '<div style="position:relative;overflow: hidden;"><div id="namenote'.$id.'" style="height:353px;overflow:hidden;position:relative;">'.$sod.'</div><div class="shows" onclick="turn(\''.$id.'\')">Развернуть</div></div>';
                        }
                        else {
                            $divsod = '<div id="namenote'.$id.'">'.$sod.'</div>';
                        }
                        $hr="<hr>";
                        $hr2 = "<hr>";
                    }
                    if($name == "") {
                        $h1_name = "";
                        print('<style>#namenote'.$id.' {padding-top: 10px !important;padding-bottom: 10px !important;}</style>');
                    }
                    else {
                        $h1_name = '<h1>'.$name.'</h1>';
                        $hr= '<hr>';
                        print('<style>#namenote'.$id.' {padding-bottom: 5px !important;}</style>');
                    }

                    $factdate = notdate($factdate);
                    
                        $query8 = "SELECT id from users WHERE login='".$_SESSION['login']."'";
                        $result8 = $conn->query($query8);
                        $myligo = $result8->fetch_array()['id'];
                    
                        # Узнаем описание
                        $query8 = "SELECT * from design WHERE login='".$login."'"; 
                        $result8 = $conn->query($query8);
                        $description = $result8->fetch_array()['description'];
                    
                        if($description == '') {
                            $description = 'Описание не указано';
                        }
                        $result8->data_seek(0);
                        $blogname = $result8->fetch_array()['blogname'];
                        if($blogname == '') {
                            $blogname = $login;
                        }
                        $query8 = "SELECT id from users WHERE login='".$login."'";
                        $result8 = $conn->query($query8);
                        $ligo = $result8->fetch_array()['id'];
                        
                        $query8 = "SELECT * from subscribes WHERE userid='".$ligo."'";
                        $result8 = $conn->query($query8);
                        $countsub = $result8->num_rows;
                        
                        $query8 = "SELECT * from news WHERE login='".$login."'";
                        $result8 = $conn->query($query8);
                        $countnote = $result8->num_rows;
                        
                        
                        $query8 = "SELECT * from subscribes WHERE userid='".$ligo."' AND subscriberid='".$myligo."' order by count DESC"; 
                        $result8 = $conn->query($query8);
                        $rows8 = $result8->num_rows;
                        
                        $subconfirm = '<div class="userboxsub" style="font-size:12px;">Вы не подписаны</div>';
                                if($rows8 != 0) {
                                        $subconfirm = '<div class="userboxsub" style="font-size:14px;">Вы подписаны</div>';
                                }
                                else {
                                    if($login == $_SESSION['login']) {
                                        $subconfirm = '<div class="userboxsub">Это вы</div>';
                                    }
                                }
                    if(is_file('background/'.md5('background'.$email).'.jpg')) {
                            $background = 'background/'.md5('background'.$email).'.jpg';
                        }
                        else {
                            $background = 'background/landscape-914148_1920.jpg';
                        }
                    $usercover = '<div class="usercover" style="background-image:url(\''.$background.'\');background-size:cover;background-position:center;"><div class="backfon"><div class="userph" style="background-image:url(\'avatar/'.md5('avatar'.$email).'.jpg\');background-size:cover;background-position:center;"></div></div></div><div class="allusbox"><div class="usersubline"></div><div class="usersodline"><h1>'.$blogname.'</h1><p>'.$description.'<br><span><a href="'.$login.'.php">https://listsend.ru/'.$login.'</a></span></p></div><div class="userinfoline"></div><div class="usersubscline"><div class="usersubsc" style="margin-right:10px;"><span>Подписчиков</span><br>'.$countsub.'</div><div class="usersubsc" style="margin-left:10px;"><span>Записей</span><br>'.$countnote.'</div></div>'.$subconfirm.'</div>';
                    
                    $div = '';
                    $countimg = 0;
                    for($m=0;$m<10;$m++) {
                        # Возможное фото в записи
                        $imgname = $m.md5($id).'.jpg';
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
                    
                        print('<div class="box-line" id="note'.$id.'" style="animation:show 1s ease;">
                                <div id="boxheader">
                                    <div onclick="location.href=\''.$login.'.php\'" class="avatarimg" id="avataruser'.$id.'" style="background-image:url(\''.$avatarphoto.'\');cursor:pointer;" onmouseover="userprofile3(\''.$id.'\');" onmouseout="userprofile4(\''.$id.'\')"><div class="user" id="user'.$id.'"><div class="coverus"></div>'.$usercover.'</div></div>
                                    <span>'.$blogname.'</span>
                                    <span class="date">'.$factdate.'</span>
                                </div><div style="position:relative;"><div class="tolike tolike'.$id.'"><img src="icons8-love-100.png"></div>'.$hr.$h1_name.$divsod.$div.$divtags.$hr2.'</div><div class="likes"><div class="number"><span class="span"></div><div class="allinlikes"><span class="like like'.$id.'" onclick="like(\''.$id.'\'); changelike2(\''.$id.'\');"><span class="likef likef'.$id.'"><span class="likefcount'.$id.'">'.$likes.'</span> '.likegram($likes).'</span><span class=" imglike'.$id.'"><img src="https://png.icons8.com/color/20/000000/filled-like.png"></span>&nbsp;</span><span onclick="docom(\''.$id.'\')" class="commenty"><span class="comf" id="komnum"><span class="countcomf'.$id.'">'.$commentrows.'</span> '.comgram($commentrows).'</span><img src="https://png.icons8.com/metro/16/333333/topic.png" style="top:3px;">&nbsp;&nbsp;</span><span onclick="repostconfirm(\''.$id.'\')" class="repost"><span class="repf"><span class="countrepf">'.$repcount.'</span> '.repgram($repcount).'</span><img src="https://png.icons8.com/material/21/333333/refresh.png">&nbsp;&nbsp;</span></span></div></div><br>');
                    
                    print('<div class="blockcomments"><hr><div class="allcom'.$id.'">');
                    if($morecom == 1) {
                        print('<div class="morecom"><span onclick="showmorecom(\''.$id.'\')">Показать остальные комментарии ('.$commentrowsfalse.')</span></div><hr>');
                    }
                    $myavatarcoment = md5('avatar'.$emailfor).'.jpg';    
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
                        $idcom = $results->fetch_array()['id'];
                        $results->data_seek($i); 
                        $comentemail = $results->fetch_array()['email'];
                        $results->data_seek($i); 
                        $datecom = $results->fetch_array()['date'];
                        $query3 = "SELECT * FROM likes WHERE noteid='com".$idcom."'"; 
                        $result3 = $conn->query($query3);
                        $rows3 = $result3->num_rows;
                        if($rows3 == 0) {
                            $rows3 = '';
                        }
                        $avatarcoment = md5('avatar'.$comentemail).'.jpg';    
                        if(is_file('avatar/'.$avatarcoment)) {
                            $avatarphotocoment = 'avatar/'.$avatarcoment;
                        }
                        else {
                            $avatarphotocoment = 'avatar/123123.jpg';
                        }
                        $fals = '';
                        $delcomm = '<span class="delcomm"><img src="https://png.icons8.com/windows/20/666666/trash.png" style="cursor: pointer;" onclick="delcomm(\''.$idcom.'\');"></span>';
                        if($logincom != $_SESSION['login']) {
                                    $fals = '<span>Пожаловаться</span>';
                                    $delcomm = '';
                        }
                        $query4 = "SELECT * FROM likes WHERE noteid='com".$idcom."'"; 
                        $result4 = $conn->query($query4);
                        $rows4 = $result4->num_rows;
                        $del = 0;
                        for($b = 0;$b < $rows4;$b++) {
                            $result->data_seek($b); 
                            if($emailfor == $result4->fetch_array()['email']) {
                                $del = 1;
                            }
                        }
                        if($del == 0) {
                            $likespan='<span id="imgcomlike'.$idcom.'"  onclick="commentlike(\''.$idcom.'\');changelike3(\''.$idcom.'\')"><img src="https://png.icons8.com/metro/17/666666/like.png"></span>';
                        }
                        else {
                            $likespan='<span id="imgcomlike'.$idcom.'"  onclick="commentlike(\''.$idcom.'\');changelike4(\''.$idcom.'\')"><img src="https://png.icons8.com/material/17/666666/filled-like.png"></span>';
                        }
                        print('<div class="comment" id="comment'.$idcom.'"><div style="background-image:url('.$avatarphotocoment.');background-size:cover;background-position:center;" class="comimglog"></div><div class="commenttitle"><span id="comid'.$idcom.'">'.$logincom.'</span>'.$delcomm.'<span class="titledate">'.notdate($datecom).'</span></div><p>'.$sod.'</p><div class="rewrite"><span onclick="reply(\''.$idcom.'\',\''.$id.'\')" style="cursor:pointer;">Ответить</span>'.$fals.'<span class="comlike"><span class="likecomnum likecomnum'.$idcom.'">'.$rows3.'</span>'.$likespan.'</span></div><hr></div>');
                            }
                    if($commentbool != 'true') {
                        print('</div><div class="sendcomment"><div class="comimgmylog" style="background-image:url('.$myavatarphotocoment.');background-size:cover;background-position:center;"></div><form name="comment" id="formcomment" class="commentsend'.$id.'"><textarea placeholder="Прокомментируйте запись..." class="textarea'.$id.'" id="sendcomment" name="sendcomment" onclick="showsend(\''.$id.'\')"></textarea></form><div class="sendhide sends'.$id.'"><hr><span id="comins'.$id.'"></span><input type="submit" name="commentsend" onclick="commentsend(\''.$id.'\');"></div></div></div>');
                        }
                    else {
                        print('</div>');
                    }
                        print('</div></div>');
                    }
                else {
                    $dif = $dif + 1;
                }
                if($rows - $dif == 0) {
                    print('<div class="dlike">Похоже, вам ничего не нравится</div>');
                }
            }
?>

<script type="text/javascript" src="main.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
            autosize( $('#sendcomment') );
    });
    $(window).scroll(function(){
        if($(window).scrollTop()+$(window).height()>=$(document).height()){
            download();
        }
    });
    document.title = 'ListSend | Понравившиеся';
    $(document).mouseup(function (e){ // событие клика по веб-документу
		var div = $(".sendhide"); // тут указываем ID элемента
		if (!div.is(e.target) // если клик был не по нашему блоку
		    && div.has(e.target).length === 0) { // и не по его дочерним элементам
			div.css({'display':'none'}); // скрываем его
		}
	});
</script>
<?php
    session_start();
    function notdate($date) {
                                date_default_timezone_set("Europe/Moscow");
                                $string = explode('.', $date); 
                                if($string[0] == date('d')) {
                                    $time1 = time();
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
                                elseif($string[0] == date('d', strtotime('yesterday'))) {
                                    return "Вчера в ".date('H:i',strtotime(substr($date, strrpos($date," ")+1)));
                                }
                                else {
                                    return 'fall';
                                }
}
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
    $_SESSION['booldiar'] = 1;
    $_SESSION['boolnews'] = 0;
    $_SESSION['boollike'] = 0;
    $_SESSION['boolsub'] = 0;
    $_SESSION['morediar'] = 5;
    $_SESSION['diarid'] = $_GET['id'];
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $query = "SELECT * from diarsnote WHERE email='".$emailfor."' AND diarid='".$_SESSION['diarid']."' order by id DESC LIMIT 5"; 
    $result = $conn->query($query);
    $rows = $result->num_rows;
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    if($rows == 0) {
            print('<div class="notselected" style="display:inline-block"><h1>Нет записей</h1></div><style type="text/css"> #allbox {text-align:center;} </style>');
    }
    for($j = 0;$j < $rows;$j++) {
                                $result->data_seek($j); 
                                $email = $result->fetch_array()['email'];
                                $result->data_seek($j); 
                                $name = $result->fetch_array()['name'];
                                $result->data_seek($j); 
                                $sod = $result->fetch_array()['sod'];
                                $result->data_seek($j); 
                                $date = $result->fetch_array()['date'];
                                $result->data_seek($j); 
                                $factdate = $result->fetch_array()['factdate'];
                                $result->data_seek($j); 
                                $datenotfact = $result->fetch_array()['date'];
                                $result->data_seek($j); 
                                $tags = $result->fetch_array()['tags'];
                                $result->data_seek($j); 
                                $login = $result->fetch_array()['login'];
                                $result->data_seek($j); 
                                $diarid1 = $result->fetch_array()['diarid'];
                                $result->data_seek($j); 
                                $id = $result->fetch_array()['id'];
                                $hr2="";
                                $imgname = md5($id.$emailfor.$diarid1).'.jpg';
                                if(is_file('noteimage/'.$imgname)) {
                                    $div = '<div class="notephoto"><img src="noteimage/'.$imgname.'" width="100%"></div>';
                                }
                                else {
                                    $div = '';
                                }
                                $avatar = md5('avatar'.$emailfor).'.jpg';    
                                if(is_file('avatar/'.$avatar)) {
                                    $avatarphoto = 'avatar/'.$avatar;
                                }
                                else {
                                    $avatarphoto = 'avatar/123123.jpg';
                                }
                                if($tags == '') {
                                    $divtags = "";
                                }
                                else {
                                    $divtags = '<div class="tags"><span>#'.$tags.'</span></div>';
                                    $hr="<hr>";
                                    $hr2="<hr>";
                                }
                                if($sod == '') {
                                    $divsod = "";
                                    $hr="";
                                    $hr2="";
                                }
                                else {
                                    $words = explode(' ', $sod);
                                    if(sizeof($words) > 42) {
                                        $more = "<span class='more' onclick='more(\"".$id."\")'>Показать полностью...</span>";
                                        $divsod = '<p id="namenote'.$id.'">'.updatestring($sod).$more.'</p>';
                                    }
                                    else {
                                        $divsod = '<p id="namenote'.$id.'">'.updatestring($sod).'</p>';
                                    }
                                    $hr="<hr>";
                                }
                                if($name == "") {
                                    $h1_name = "";
                                    print('<style>#namenote'.$id.' {padding-top: 10px !important;padding-bottom: 8px !important;}</style>');
                                }
                                else {
                                    $h1_name = '<h1>'.$name.'</h1>';
                                }
                    $factdate = notdate($factdate);
                    if($factdate == 'fall') {
                        $factdate = $datenotfact;
                    }
                    print('<div class="box-line" id="note'.$id.'" style="padding-bottom:10px;animation:show 1s ease;">
                            <div id="boxheader">
                                <a href="'.$login.'.php"><div class="avatarimg" style="background-image:url(\''.$avatarphoto.'\');"></div>
                                <span>'.$login.'</span></a>
                                <span class="date">'.$factdate.'</span>
                            </div><div style="position:relative;"><div class="tolike tolike'.$id.'"><img src="icons8-love-100.png"></div>'.$hr.$h1_name.$divsod.$div.$divtags.$hr2.'</div><div class="notetake"><span class="deleteanote" id="'.$id.'" onclick="deleteanoteconfirm(\''.$id.'\');" onmouseover="deletehover(\''.$id.'\');"  onmouseleave="deletehover2(\''.$id.'\');"><img src="https://png.icons8.com/trash/win10/20/333333"><span>Удалить запись</span></span>
                            <span class="newsnote" onclick="category(\''.$id.'\');" onmouseover="newshover(\''.$id.'\');" onmouseleave="newshover2(\''.$id.'\');"><img src="https://png.icons8.com/undo/dotty/20/333333"><span>Опубликовать</span></span>
                            <span class="editnote" onclick="edit(\''.$id.'\')" onmouseover="" onmouseleave=""><img src="https://png.icons8.com/pencil/ios7/20/000000"><span>Редактировать</span></span></div></div>');
                                } 
?>
<script type="text/javascript" src="main.js"></script>
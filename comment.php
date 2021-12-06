<?php
    session_start();
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
                                if($string[0] == date('d')) {
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
                                        $sp = 0;
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
                                                $sp = 1;
                                            }
                                            if(gmdate('s', $diff) >= 10 && gmdate('s', $diff) <= 20) {
                                                $sek = "секунд";
                                            }
                                            
                                            if($sp == 1) {
                                                return 'Только что';
                                            }
                                            else {
                                                return 1*gmdate('s', $diff)." ".$sek." назад";
                                            }
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
                                    $month = whatdate($string[1]);
                                    $trip = explode(' ',$date);
                                    $str2 = explode(' ',$string[2]);
                                    return $string[0].' '.$month.' '.$str2[0].' в '.substr($trip[1],0,-3);
                                }
            }

    if(isset($_GET['id'])) {
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            if ($conn->connect_error) die($conn->connect_error);
            $emailfor = str_replace('.', '', $_SESSION['email']);
            $emailfor = str_replace('@', '', $emailfor);
            date_default_timezone_set('UTC');
            $date = time();
            $_GET['id'] = (int)$_GET['id'];
            $_GET['id'] = strip_tags($_GET['id']);
            $_GET['id'] = htmlspecialchars($_GET['id']);
            $_GET['id'] = addslashes($_GET['id']);
            $_POST['sendcomment'] = htmlspecialchars($_POST['sendcomment']);
            $_POST['sendcomment'] = addslashes($_POST['sendcomment']);
            $query = "INSERT into comments(email,noteid,login,sod,date) VALUES('".$emailfor."','".$_GET['id']."','".$_SESSION['login']."','".$_POST['sendcomment']."','".$date."')"; 
            $result = $conn->query($query);
            $query = "SELECT * from comments order by id DESC"; 
            $result = $conn->query($query);
            $result->data_seek(0);
            $idcom = $result->fetch_array()['id'];
            if (!$result) die ($conn->error);
            $query3 = "SELECT * FROM likes WHERE noteid='com".$idcom."'"; 
                    $result3 = $conn->query($query3);
                    $rows3 = $result3->num_rows;
                    if($rows3 == 0) {
                        $rows3 = '';
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
                    
            print('<div class="comment" id="comment'.$idcom.'" style="animation:show 1s linear;"><img src="avatar/'.md5('avatar'.$emailfor).'.jpg"><div class="commenttitle"><span>'.$_SESSION['login'].'</span><span class="delcomm"><img src="https://png.icons8.com/windows/20/666666/trash.png" style="cursor: pointer;" onclick="delcomm(\''.$idcom.'\');"></span><span class="titledate">'.notdate($date).'</span></div><p>'.$_POST['sendcomment'].'</p><div class="rewrite"><span onclick="reply(\''.$idcom.'\',\''.$_GET['id'].'\')" style="cursor:pointer;">Ответить</span><span class="comlike"><span class="likecomnum likecomnum'.$idcom.'">'.$rows3.'</span>'.$likespan.'</span></div><hr></div>');
            if($_GET['login'] != '' && $_GET['login'] != 'undefined') {
                $query = "INSERT into notification(login,what,who,reading,date,noteid) VALUES('".$_GET['login']."','comment','".$_SESSION['login']."','1','".$date."','".$_GET['id']."')"; 
                $result = $conn->query($query);
            }
}   
?>
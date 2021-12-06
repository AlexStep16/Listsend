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
                        else {
                            return 'fall';
                        }
                    }
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $_GET['id'] = (int)$_GET['id'];
    $_GET['id'] = strip_tags($_GET['id']);
    $_GET['id'] = htmlspecialchars($_GET['id']);
    $_GET['id'] = addslashes($_GET['id']);
    $query = "SELECT * from comments WHERE noteid='".$_GET['id']."' order by id ASC"; 
    $results = $conn->query($query);
    $rows = $results->num_rows;
    for($i = 0;$i < $rows;$i++) {
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
                                $result4->data_seek($b); 
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

                            print('<div class="comment" id="comment'.$idcom.'"><div style="background-image:url('.$avatarphotocoment.');background-size:cover;background-position:center;" class="comimglog"></div><div class="commenttitle"><span id="comid'.$idcom.'">'.$logincom.'</span>'.$delcomm.'<span class="titledate">'.$datecom.'</span></div><p>'.$sod.'</p><div class="rewrite"><span onclick="reply(\''.$idcom.'\',\''.$_GET['id'].'\')" style="cursor:pointer;">Ответить</span>'.$fals.'<span class="comlike"><span class="likecomnum likecomnum'.$idcom.'">'.$rows3.'</span>'.$likespan.'</span></div><hr></div>');
                        }
?>
<?php
            session_start();
            $emailfor = str_replace('.', '', $_SESSION['email']);
            $emailfor = str_replace('@', '', $emailfor);
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            if ($conn->connect_error) die($conn->connect_error);
            $_POST['find'] = htmlspecialchars($_POST['find']);
            $query = "SELECT * from users WHERE login!='".$_SESSION['login']."' order by id ASC"; 
            $result = $conn->query($query);
            $rows = $result->num_rows;
            $strlen = mb_strlen($_POST['find'], 'UTF-8');
            $no = 0;
            $array = array();
            print('<ul>');
            if($strlen!=0) {
                for($j = 0;$j < $rows;$j++) {
                    $stop = 0;
                    $result->data_seek($j);
                    $name = $result->fetch_array()['login'];
                    $array[$j] = $name;
                    for($i=0;$i<$j;$i++) {
                        if($array[$i] == $array[$j]) {
                            $stop = 1;
                        }
                    }
                    if($stop!=1) {
                        $query2 = "SELECT * from users WHERE login='".$name."' order by id ASC LIMIT 20"; 
                        $result2 = $conn->query($query2);
                        $imgname = str_replace('.', '', $result2->fetch_array()['email']);
                        $imgname = str_replace('@', '', $imgname);
                        if(is_file('avatar/'.md5('avatar'.$imgname).'.jpg')) {
                            $img = 'avatar/'.md5('avatar'.$imgname).'.jpg';
                        }
                        else {
                            $img = 'avatar/123123.jpg';
                        }
                        $result->data_seek($j);
                        $string = $result->fetch_array()['login'];
                        $result->data_seek($j);
                        $id = $result->fetch_array()['id'];
                        $string = mb_substr($string, 0, $strlen,'UTF-8');
                        $rand = rand();
                        $newname = str_ireplace($string,'<b>'.$string.'</b>',$name);
                        if($_POST['find'] == $string || $_POST['find'] == mb_strtolower($string,'UTF-8')) {
                            if($no < 200) {
                                print('<a href="javascript:void(0)" onclick="staff(\''.$rand.'\');send(\''.$id.'\');"><li><div class="avatar"><img src="'.$img.'" width="40" height="40"><div class="info infofind"><span id="span'.$rand.'" class="spanlogin">'.$newname.'</span></div></div></li></a>');
                            }
                            $no = $no + 1;
                        }
                    }
                }
                if($no == 0) {
                    print('<a href="javascript:void(0)" onclick=""><li><span class="findtext">Такого пользователя не существует</span></li></a>');
                }
            print('</ul>');
            }
?>


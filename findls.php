<?php
            session_start();
            $emailfor = str_replace('.', '', $_SESSION['email']);
            $emailfor = str_replace('@', '', $emailfor);
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            if ($conn->connect_error) die($conn->connect_error);
            $query = "SELECT * from design order by id DESC"; 
            $result = $conn->query($query);
            $rows = $result->num_rows;
            $_POST['findls'] = htmlspecialchars($_POST['findls']);
            $strlen = mb_strlen($_POST['findls'], 'UTF-8');
            $no = 0;
            $array = array();
            $array2 = array();   
            if($strlen!=0) {
                if($rows != 0) {
                    print('<ul><h1>Блоги</h1><hr>');
                }
                else {
                    print('<ul><h1>Поиск</h1><hr>');
                }
                for($j = 0;$j < $rows;$j++) {
                    $stop = 0;
                    $result->data_seek($j);
                    $name = $result->fetch_array()['blogname'];
                    $result->data_seek($j);
                    $avaform = $result->fetch_array()['avatarform'];
                    $result->data_seek($j);
                    $login = $result->fetch_array()['login'];
                    $result->data_seek($j);
                    $query2 = "SELECT * from users WHERE login='".$login."'"; 
                    $result2 = $conn->query($query2);
                    $result2->data_seek(0);
                    $email = $result2->fetch_array()['email'];
                    $email = str_replace('.', '', $email);
                    $email = str_replace('@', '', $email);
                    if(is_file('avatar/'.md5('avatar'.$email).'.jpg')) {
                        $img = 'avatar/'.md5('avatar'.$email).'.jpg';
                    }
                    else {
                        $img = 'avatar/123123.jpg';
                    }
                    
                    $string = $result->fetch_array()['blogname'];
                    $string = mb_substr($string, 0, $strlen,'UTF-8');
                    $newname = str_ireplace($string,'<b>'.$string.'</b>',$name);
                    if($_POST['findls'] == $string) {
                            if($no >= 0) $class="style='padding-top: 5px;padding-bottom: 0;'";
                        if($no < 7) {
                            print('<a href="javascript:void(0)" onclick="location.href=\''.$login.'.php\'" id="find'.$j.'"><li '.$class.'><div class="imgfind" style="top:7px !important;border-radius:'.$avaform.';display:inline-block;background:url('.$img.');position: relative;background-size:cover;background-position:center;width:30px;height:30px;"></div><span class="findtext">'.$newname.'<br><span style="color:grey;font-size:13px;position: relative;left: 30px;bottom:5px;">https://listsend.ru/'.$login.'</span></span></li></a>');
                        }
                            $no = $no + 1;
                    }
                    if($j == ($rows-1) && $no == 1) {
                            print('<style>.findlsnote li{padding-top: 5px;}</style>');
                    }
                }
                if($no == 0) {
                    print('<a href="javascript:void(0)" onclick=""><li style="padding-top: 5px;padding-bottom: 15px;"><img src="https://png.icons8.com/search/ios7/20/cccccc" class="imgfind"><span class="findtext" style="top:0;">'.$_POST['findls'].'</span></li></a>');
                }
            
        print('</ul>');
    }
?>


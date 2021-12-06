<?php
            session_start();
            $emailfor = str_replace('.', '', $_SESSION['email']);
            $emailfor = str_replace('@', '', $emailfor);
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            if ($conn->connect_error) die($conn->connect_error);
            $query = "SELECT * from news order by id DESC"; 
            $result = $conn->query($query);
            $rows = $result->num_rows;
            $_POST['find'] = htmlspecialchars($_POST['find']);
            $strlen = mb_strlen($_POST['find'], 'UTF-8');
            $no = 0;
            $array = array();
            $array2 = array();   
            if($strlen!=0) {
            print('<ul><h1>Поиск</h1><hr>');
                for($j = 0;$j < $rows;$j++) {
                    $stop = 0;
                    $stop2 = 0;
                    $result->data_seek($j);
                    $name = $result->fetch_array()['name'];
                    $result->data_seek($j);
                    $tags = $result->fetch_array()['tags'];
                    $tags = explode(' ',$tags);
                    $count = count($tags);
                    for($p=0;$p<$count;$p++) {
                        $array2[$j][$p] = $tags[$p];
                    }
                    
                     for($i = 0;$i<$j;$i++) {
                                    $result->data_seek($i);
                                    $tags2 = $result->fetch_array()['tags'];
                                    $tags2 = explode(' ',$tags2);
                                    $rowstags2 = count($tags2);
                                    for($l = 0;$l<$rowstags2;$l++) {
                                        for($c = 0;$c<$count;$c++) {
                                            if(isset($array2[$j][$c])) {
                                                if($array2[$j][$c] == $array2[$i][$l]) {
                                                    $array2[$j][$c] = 'nopel';
                                                }
                                            }
                                        }
                                    }
                                }
                    
                    $array[$j] = $name;
                    for($i=0;$i<$j;$i++) {
                        if($array[$i] == $array[$j]) {
                            $stop = 1;
                        }
                    }
                    $result->data_seek($j);
                    $tags = $result->fetch_array()['tags'];
                    $tags = explode(' ',$tags);
                    $count = count($tags);
                    $findc = '';
                    for($p=0;$p<$count;$p++) {
                        if('nopel' != $array2[$j][$p]) {
                            $string2 = mb_substr($tags[$p], 0, $strlen,'UTF-8');
                            $string3 = '#'.mb_substr($tags[$p], 0, $strlen-1,'UTF-8');
                            if($_POST['find'] == $string2 || $_POST['find'] == $string3) {
                                $newname2 = '#'.str_ireplace($string2,'<b>'.$string2.'</b>',$tags[$p]);
                                if($_POST['find'] == $string3) {
                                    $newname2 = '#'.str_ireplace(mb_substr($string3,0,'UTF-8'),'<b>'.mb_substr($string3,0,'UTF-8').'</b>',$tags[$p]);
                                }
                                if($newname2 != "#") {
                                    $findc = $p;
                                    if($no >= 0) $class="style='padding-top: 5px;padding-bottom: 15px;'";
                                    if($no < 7) {
                                        print('<a href="javascript:void(0)" onclick="findselect(\'li'.$p.'\')" id="findli'.$p.'"><li '.$class.'><img src="https://png.icons8.com/search/ios7/20/cccccc" class="imgfind"><span class="findtext">'.$newname2.'</span></li></a>');
                                    }
                                    $no = $no + 1;
                                }
                            }
                        }
                    }
                    if($stop!=1) {
                        $result->data_seek($j);
                        $string = $result->fetch_array()['name'];
                        $string = mb_substr($string, 0, $strlen,'UTF-8');
                        $newname = str_ireplace($string,'<b>'.$string.'</b>',$name);
                        if($_POST['find'] == $string || $_POST['find'] == mb_strtolower($string,'UTF-8') || $_POST['find'] == mb_strtoupper($string,'UTF-8')) {
                            if($no >= 0) $class="style='padding-top: 5px;padding-bottom: 15px;'";
                            print('<a href="javascript:void(0)" onclick="findselect(\''.$j.'\')" id="find'.$j.'"><li '.$class.'><img src="https://png.icons8.com/search/ios7/20/cccccc" class="imgfind"><span class="findtext">'.$newname.'</span></li></a>');
                            $no = $no + 1;
                        }
                    }
                }
                if($no == 0) {
                    print('<a href="javascript:void(0)" onclick="findselect(\''.$j.'\')" id="find'.$j.'"><li style="padding-top: 5px;padding-bottom: 15px;"><img src="https://png.icons8.com/search/ios7/20/cccccc" class="imgfind"><span class="findtext">'.$_POST['find'].'</span></li></a>');
                }
            print('</ul>');
            }
?>


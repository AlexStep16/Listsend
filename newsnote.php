<?php
session_start();
if(isset($_GET['id'])) {
            function detect($id) {
                if($id == '1') {
                    return "Жизнь";
                }
                if($id == '2') {
                    return "Любовь";
                }
                if($id == '3') {
                    return "Литература";
                }
                if($id == '4') {
                    return "Карьера";
                }
                if($id == '5') {
                    return "Развлечения";
                }
                if($id == '6') {
                    return "Здоровье";
                }
                if($id == '7') {
                    return "Бизнес";
                }
                if($id == '8') {
                    return "Наука";
                }
                if($id == '9') {
                    return "Дизайн";
                }
                if($id == '10') {
                    return "Еда";
                }
            }
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
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            if ($conn->connect_error) die($conn->connect_error);
            $emailfor = str_replace('.', '', $_SESSION['email']);
            $emailfor = str_replace('@', '', $emailfor);
            $query = "SELECT * from diarsnote WHERE email='".$emailfor."' AND id='".$_GET['id']."'"; 
            $result = $conn->query($query);
            if (!$result) die ($conn->error);
            $result->data_seek(0);
            $name = $result->fetch_array()['name'];
            $result->data_seek(0);
            $sod = $result->fetch_array()['sod'];
            $result->data_seek(0);
            $login = $result->fetch_array()['login'];
            $result->data_seek(0);
            date_default_timezone_set('Europe/Moscow');
            $when = whatdate(date('m'),time());
            $date = date('d '.$when. ' Y года в H:i');
            $factdate = date('d.m.Y H:i:s',time());
            $result->data_seek(0);
            $tags = $result->fetch_array()['tags'];
            $result->data_seek(0);
            $diarid = $result->fetch_array()['diarid'];
            $result->data_seek(0);
            $id = $result->fetch_array()['id'];
            $query = "INSERT into news(login,email,name,sod,date,tags,diar,realid,category,factdate) VALUES('".$login."','".$emailfor."','".$name."','".$sod."','".$date."','".$tags."','".$diarid."','".$id."','".detect($_GET['idcat'])."','".$factdate."')"; 
            $result = $conn->query($query);
            $query = "SELECT * from news WHERE diar='".$diarid."' AND login='".$login."' AND email='".$emailfor."' AND realid='".$id."' order by id DESC"; 
            $result = $conn->query($query);
            $result->data_seek(0);
            $fileop = $result->fetch_array()['id'];
            $f_hdl = fopen($fileop.'.php', 'w');
            $file = '76.php';
            copy($file,$fileop.'.php');
}   
?>
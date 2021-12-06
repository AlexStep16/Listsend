<?php
session_start();
function moveFile( $from, $new_dir )
    {
        if( !file_exists( $from ) )die('Файл не существует: ' . $from);
        if( !is_dir( $new_dir ) )  die('Директория не существует: ' . $new_dir);
        $filename = $new_dir . DIRECTORY_SEPARATOR . basename( $from );
        if( copy( $from, $filename ) )
        {
            unlink( $from );
            return true;
        }
        return false;
    }

function whatdate($date) {
    if($date == '11') {
        return 'ноября';
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

if(isset($_POST['named'])) {
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            if ($conn->connect_error) die($conn->connect_error);
            $emailfor = str_replace('.', '', $_SESSION['email']);
            $emailfor = str_replace('@', '', $emailfor);
            $when = whatdate(date('m'));
            $realdate = date('d '.$when. ' Y года');
            $query = "INSERT into diars(email,name,sod,date) VALUES('".$emailfor."','".$_POST['named']."','".$_POST['sod']."','".$realdate."')"; 
            $result = $conn->query($query);
            if (!$result) die ($conn->error);
            $query = "SELECT * from diars WHERE email='".$emailfor."' AND name='".$_POST['named']."' AND sod='".$_POST['sod']."'"; 
            $result = $conn->query($query);
            if (!$result) die ($conn->error);
            moveFile( 'tmp/'.$_GET['img'], 'userimage/');
            rename('userimage/'.$_GET['img'],'userimage/'.md5($result->fetch_array()['id']).'.jpg');
            $result->data_seek(0);
            $id = $result->fetch_array()['id'];
            $result->data_seek(0);
            $query1 = "SELECT * from diars WHERE id='".$result->fetch_array()['id']."'"; 
            $result1 = $conn->query($query1);
            if (!$result1) die ($conn->error);
            $rows1 = $result1->num_rows;
            $result->data_seek(0);
            print('<div class="diar" id="box'.$id.'" style="animation:show 1s linear;">
                               <div class="redakt change" onclick="changes(\''.$id.'\');" id="off'.$id.'"></div> <div class="redakt delete" onclick="enter(\''.$id.'\');"></div>
                                        <div class="indiar"><img src="userimage/'.md5($id).'.jpg" width="100%" height="120" class="newi"><input class="newimg1" type="file" id=\''.$id.'\'></div>
                                        <div style="width:250px;height:100px;text-align:center;margin-bottom:10px;border-bottom:1px solid rgba(100,100,100,0.3);overflow:hidden;">
                                        <form name="change" class="formchange" id="form'.$id.'">
                                        <input type="text" value="'.$_POST['named'].'" name="changename"  readonly><br>
                                       <textarea name="changesod"  readonly>'.$_POST['sod'].'</textarea>
                                        </form>
                                      </div>
                                      <div style="width:250px;height:75px;text-align:left;margin-bottom:10px;border-bottom:1px solid rgba(100,100,100,0.3);"><p style="font-size:17px;">Записей в дневнике: <span style="font-size:15px;font-weight:bold;">'.$rows1.'</span><br>Создано: <span style="font-size:15px;font-weight:bold;">'.$realdate.'</span></p></div>
                                <div class="take"><a href="javascript:void(0);" onclick="select(\''.$id.'\')">Выбрать</a></div>
                        </div>');
}

if(isset($_GET['id'])) {
        $conn = new mysqli('localhost', 'People', '123456', 'main');
        if ($conn->connect_error) die($conn->connect_error);
        $query = "UPDATE diars SET name='".$_POST['changename']."', sod='".$_POST['changesod']."' WHERE id='".$_GET['id']."'"; 
        $result = $conn->query($query);
        if (!$result) die ($conn->error);
    print('s;');
}

?>
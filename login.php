 <?php
        if(isset($_POST['email'])) {
            $enter = 0;
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            if ($conn->connect_error) die($conn->connect_error);
            $query = "SELECT * FROM users"; 
            $result = $conn->query($query);
            if (!$result) die ($conn->error);
            $rows = $result->num_rows;
            for($j = 0;$j < $rows;$j++) {
                $result->data_seek($j); 
                $email = $result->fetch_array()['email'];
                $result->data_seek($j); 
                $login = $result->fetch_array()['login'];
                $result->data_seek($j);
                $password = $result->fetch_array()['password'];
                if($email == $_POST['email'] && password_verify($_POST['password'], $password)) {
                    session_start();
                    $_SESSION['email'] = $email;
                    $_SESSION['login'] = $login;
                    $enter = 1;
                    $query = "SELECT * from design WHERE login='".$_SESSION['login']."'"; 
                    $result = $conn->query($query);
                    $gmt = $result->fetch_array()['time'];
                    if($gmt == '') {
                        $gmt = 3;
                    }
                    $_SESSION['timezone'] = $gmt;
                }
                
            }
            
                
            
            if($enter == 0) {
                print('<script> $(".form2").css({\'bottom\':\'0\'});$("#b3").css({\'visibility\':\'visible\',\'bottom\':\'5px\'}); </script>');
            }
            else {
                print('<script> location.href=\'index.php\';$("#b3").css({\'visibility\':\'hidden\',\'bottom\':\'5px\'}); </script>');
            }
            
            
        }
    ?>
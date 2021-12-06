 <?php
        if(isset($_POST['email'])) {
            $email = 1;
            $login = 1;
            $conn = new mysqli('localhost', 'People', '123456', 'main');
            if ($conn->connect_error) die($conn->connect_error);
            $query = "SELECT * FROM users"; 
            $result = $conn->query($query);
            if (!$result) die ($conn->error);
            $rows = $result->num_rows;
            for($j = 0;$j < $rows;$j++) {
                $result->data_seek($j); 
                if($result->fetch_array()['email'] == $_POST['email']) {
                    $email = 0;
                }
                $result->data_seek($j); 
                if($result->fetch_array()['login'] == $_POST['login']) {
                    $login = 0;
                }
            }
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) !== false)
                {
                print('<script>$("#r2").css({\'visibility\':\'hidden\',\'bottom\':\'-35px\'}); </script>');
                  if (preg_match('/^[a-z0-9]{3,20}$/i', $_POST['login'])) { 

                        if($login == 1 && $email == 1) {
                        if($_POST['password'] == '') {                  print('<script>$("#s1").css({\'visibility\':\'visible\',\'bottom\':\'5px\'}); </script>');
                        }
                        else {
                            print('<script>$("#s1").css({\'visibility\':\'hidden\',\'bottom\':\'-35px\'}); </script>');
                            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                            $_POST['email'] = htmlspecialchars($_POST['email']);
                            $_POST['email'] = addslashes($_POST['email']);
                            $_POST['login'] = htmlspecialchars($_POST['login']);
                            $_POST['login'] = addslashes($_POST['login']);
                            $query = "INSERT into users(email,password,login) VALUES('".$_POST['email']."','".$_POST['password']."','".$_POST['login']."')"; 
                            $result = $conn->query($query);
                            if (!$result) die ($conn->error);
                            $rand = rand(1,5);
                            $query = "INSERT into design(login,backgr) VALUES('".$_POST['login']."','".$rand."')"; 
                            $result = $conn->query($query);
                            if (!$result) die ($conn->error);
                            print('<script> $(".form3").css({\'height\':\'0\'});
                            $(".form2").css({\'height\':\'135px\'});</script>');
                            $f_hdl = fopen($_POST['login'].'.php', 'w');
                            $file = 'alexnder2000.php';
                            copy($file,$_POST['login'].'.php');
                        } 
                        }  print('<script>$("#r1").css({\'visibility\':\'hidden\',\'bottom\':\'-35px\'}); </script>');
                        if($email == 0) {
                            print('<script>$("#b2").css({\'visibility\':\'visible\',\'bottom\':\'5px\'}); </script>');
                        }
                        else {
                          print('<script>$("#b2").css({\'visibility\':\'hidden\',\'bottom\':\'-35px\'}); </script>');
                        }

                        if($login == 0) {
                            if($email == 0) {
                                print('<script>$("#b1").css({\'visibility\':\'visible\',\'bottom\':\'5px\'});$("#b2").css({\'bottom\':\'35px\'}); </script>');
                            }
                            else {
                                print('<script>$("#b1").css({\'visibility\':\'visible\',\'bottom\':\'5px\'}); </script>');
                            }
                        }
                        else {
                            print('<script>$("#b1").css({\'visibility\':\'hidden\',\'bottom\':\'-35px\'}); </script>');
                        }
                    }
                    else {
                        print('<script>$("#b1").css({\'visibility\':\'hidden\',\'bottom\':\'-35px\'}); </script>');
                        if($email != 0){
                            print('<script>$("#b2").css({\'visibility\':\'hidden\',\'bottom\':\'-35px\'});$("#r1").css({\'visibility\':\'visible\',\'bottom\':\'5px\'}); </script>');
                        }
                        else {
                          print('<script>$("#b2").css({\'visibility\':\'visible\',\'bottom\':\'5px\'});$("#r1").css({\'visibility\':\'visible\',\'bottom\':\'35px\'}); </script>');
                        }
                    }
                }
            else
                {
                      if($login != 0){
                            print('<script>$("#b1").css({\'visibility\':\'hidden\',\'bottom\':\'-35px\'});$("#r2").css({\'visibility\':\'visible\',\'bottom\':\'5px\'}); </script>');
                        }
                        else {
                          print('<script>$("#b1").css({\'visibility\':\'visible\',\'bottom\':\'5px\'});$("#r2").css({\'visibility\':\'visible\',\'bottom\':\'35px\'}); </script>');
                        }
                }
            
            
        }
    ?>
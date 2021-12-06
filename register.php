<!DOCTYPE html>
<html>
    <head>
        <script src='http://code.jquery.com/jquery-3.2.1.min.js'></script> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <link href="register.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <title>ListSend.ru</title>
    </head>
    
    <body>
        <div class="main">
            <div id="header"><a href="index.php">Вход</a></div>
            <div class="form">
                <div style="position:relative;">
                    <div class="none" id="r1">Некорректный login</div>
                    <div class="none" id="r2">Некорректный E-Mail</div>
                    <div class="none" id="b1">Такой login уже занят</div>
                    <div class="none" id="b2">Такой E-Mail уже занят</div>
                    <div class="none" id="s1">Введите пароль</div>
                </div>
                <div class="form3">
                    <form action="reg.php" method="post" onsubmit="return false;" class="register" id="register">
                        <input type="text" id="input1" placeholder="Введите E-Mail" name="email"><br>
                        <input type="password" id="input2" placeholder="Введите пароль" name="password"><br>
                        <input type="text" placeholder="Введите логин" name="login"><br>
                        <input type="submit" value="Регистрация" name="get" onclick="call();">
                    </form>
                </div>
                <div style="position:relative;">
                        <div class="none" id="b3">Неверно введены данные</div>
                    </div>
                <div class="form2">
                    <form action="login.php" method="post" onsubmit="return false;" class="enter" id="enter">
                            <input type="text" id="input3" placeholder="Введите E-Mail" name="email"><br>
                            <input type="password" id="input4" placeholder="Введите пароль" name="password"><br>
                            <input type="submit" value="Вход" name="get" onclick="enter();">
                    </form>
                </div>
            </div>
        <div class="info"><a href="">Правила</a><a href="">Политика конфеденциальности</a><a href="">Поддержка</a></div>
        </div>
    </body>
    
<script type="text/javascript" language="javascript">
 	
    function call() {
 	  var msg   = $('#register').serialize();
        $.ajax({
          type: 'POST',
          url: 'reg.php',
          data: msg,
          success: function(html) {
            $('.main').append(html);
          },
        });
 
    }
    
    function enter() {
 	  var msg   = $('#enter').serialize();
        $.ajax({
          type: 'POST',
          url: 'login.php',
          data: msg,
          success: function(html) {
            $('.main').append(html);
          },
        });
 
    }
</script>
    
</html>
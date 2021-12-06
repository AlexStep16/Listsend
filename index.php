<!DOCTYPE html>
<?php 
    session_start();
    if(isset($_SESSION['email']) && $_SESSION['email']!=123313) {
        $conn = new mysqli('localhost', 'People', '123456', 'main');
        if ($conn->connect_error) die($conn->connect_error);
        $query = "SELECT * FROM category WHERE login='".$_SESSION['login']."'"; 
        $result = $conn->query($query);
        if (!$result) die ($conn->error);
        $rows = $result->num_rows;
        if($rows < 3) {
            header("Location: choose.php");
        }
        else {
            header("Location: board.php");
        }
    }
?>
<html>
    <head>
        <link href="index.css" rel="stylesheet">
        <script src='http://code.jquery.com/jquery-3.2.1.min.js'></script> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Arvo" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Play" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Amatic+SC" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <title>ListSend</title>
    </head>
    <body>
        <div class="nav">
            <div class="blackc border"></div>
            <div class="greyc"></div>
            <div class="bluec"></div>
            <div class="orc"></div>
        </div>
        <div id="header">
            
            <h1><a href="index.php" class="logo">LS</a></h1>
            <div class="findls">
                <form id="findlsform" method="post" onsubmit="return false;">
                    <img src="314478-24.png"><input type="text" placeholder="Поиск в ListSend..." name="findls" onkeydown="findlss()" onclick="findlss()" type="search" maxlength="400" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" aria-autocomplete="list">
                    <div class="findlsnote"></div>
                </form>
            </div>
            <a href="register.php">
                <span class="headerspan">Регистрация</span>
            </a>
            
        </div>
        <div class="main">
            <div class="content">
                <h1>ListSend</h1>
                <div style="max-width:299px;">Начните вести свой блог прямо сейчас. Бесплатно. Удобно. Быстро.</div><br><br>
                <div class="none">Неверно введены данные</div>
                <div class="form2" style="max-width:300px;">
                        <form action="login.php" method="post" onsubmit="return false;" class="enter" id="enter">
                            
                                <input type="text" id="input1" placeholder="Введите E-Mail" name="email"><br>
                                <input type="password" id="input2" placeholder="Введите пароль" name="password"><br>
                                <input type="submit" value="Вход" name="get" onclick="enter();">


                        </form>
                    </div>
                </div>
                <div class="info"><a href="">Правила</a><a href="">Политика конфеденциальности</a><a href="">Поддержка</a></div>
            
        </div>
        <div class="main2 a">
            <div class="content2">
                <h1>Блог - это просто</h1><p>Вести блог стало удобно, благодаря множеству сервисов. Одним из таких сервисов является ListSend. Он поможет вам в поиске нужной вам аудитории, стилизации и оформлении. Чтобы начать вести свой блог вам потребуется всего 2 клика.</p>
                
            </div>
        </div>
        <div class="main2 b">
            <div class="content2" style="margin-top:-95px;">
                <h1 style="font-size:43px;">Простая навигация и управление</h1><p>Не нужно запоминать сложных комбинаций для работы. Удобное расположение необходимых функций позволяет быстро понять механизм работы сайта. Всего 5 кнопок: </p>
                <div class="menu">
                    <ul>
                        <div id="make" onclick="make();" class="idmake"><img src="https://png.icons8.com/windows/30/ffffff/plus-math.png"></div>
                        <div onclick="newssub()" class="friendcolor"><img src="https://png.icons8.com/windows/30/ffffff/news.png" style="position:relative;left:1px;bottom:1px;"></div>
                        <div id="news" onclick="news();" class="newscolor"><img src="https://png.icons8.com/windows/30/ffffff/globe.png"></div>
                        <div onclick="diaryup()" class="notescolor"><img src="https://png.icons8.com/windows/30/ffffff/note.png"></div>
                        <div onclick="newslike()" class="likecolor"><img src="https://png.icons8.com/windows/30/ffffff/hearts.png"></div>
                    </ul>
                </div>
            </div>
        </div>
        <div class="main2 c">
            <div class="content2" style="margin-top:-200px;padding-bottom:10px;">
                <h1 style="font-size:43px;">Дизайн - это ваша забота</h1><p>Множество функций для оформления стилизации вашего блога. Вы можете изменять цвет заголовка, цвет фона, размер обложки, шрифт и многое другое.</p>
                <img src="2018-02-09_21-34-08.png" style="box-shadow: 0 0 20px 1px white;border-radius:3px;">
            </div>
        </div>
    </body>
    
        <script type="text/javascript" language="javascript">
        $('.a').css({'top':'100vh'});
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
            function addHandler(object, event, handler) {
              if (object.addEventListener) {
                object.addEventListener(event, handler, false);
              }
              else if (object.attachEvent) {
                object.attachEvent('on' + event, handler);
              }
              }
              addHandler(window, 'DOMMouseScroll', wheel);
              addHandler(window, 'mousewheel', wheel);
              addHandler(document, 'mousewheel', wheel);
              function wheel(event) {
              var delta; 
              event = event || window.event;
              if (event.wheelDelta) { 
                delta = event.wheelDelta / 120;
                if (window.opera) delta = -delta;
              }
              else if (event.detail) {
                delta = -event.detail / 3;
              }
              if (event.preventDefault) event.preventDefault();
              event.returnValue = false;
              if(delta == 1){ /*up*/
                  if($('.a').offset().top == 0 && $('.b').offset().top == $('.main').height()) {
                    $('.a').css({'top':'100vh'});
                    $('.main').css({'top':'0'});
                    $('.greyc').removeClass('border');
                    $('.blackc').addClass('border');
                  }
                  if($('.b').offset().top == 0) {
                    $('.b').css({'top':'100vh'});
                    $('.a').css({'top':'0'});
                    $('.greyc').addClass('border');
                    $('.bluec').removeClass('border');
                  }
                  if($('.c').offset().top == 0 && $('.b').offset().top == -$('.main').height()) {
                    $('.b').css({'top':'0'});
                    $('.c').css({'top':'100vh'});
                    $('.bluec').addClass('border');
                    $('.orc').removeClass('border');
                }
              }
              else{ /*down*/
                if($('.a').offset().top == $('.main').height()) {
                    $('.a').css({'top':'0'});
                    $('.greyc').addClass('border');
                    $('.blackc').removeClass('border');
                    $('.main').css({'top':'-100vh'});
                }
                if($('.b').offset().top == $('.main').height() && $('.a').offset().top == 0) {
                    $('.b').css({'top':'0'});
                    $('.b ul div').css({'animation':'scale 1s ease 1'});
                    $('.a').css({'top':'-100vh'});
                    $('.greyc').removeClass('border');
                    $('.bluec').addClass('border');
                }
                if($('.b').offset().top == 0 && $('.a').offset().top == -$('.main').height()) {
                    $('.b').css({'top':'-100vh'});
                    $('.c').css({'top':'0'});
                    $('.bluec').removeClass('border');
                    $('.orc').addClass('border');
                }
                if($('.c').offset().top == 0 && $('.b').offset().top == -$('.main').height()) {
                    $('.main').css({'top':'0'});
                    $('.c').css({'top':'100vh'});
                    $('.a').css({'top':'100vh'});
                    $('.b').css({'top':'100vh'});
                    $('.orc').removeClass('border');
                    $('.blackc').addClass('border');
                }
              }
          }
            $('.orc').on('click',function(){
                    $('.c').css({'top':'0'});
                    $('.a').css({'top':'-100vh'});
                    $('.b').css({'top':'-100vh'});
                    $('.main').css({'top':'-100vh'});
                    $('.greyc').removeClass('border');
                    $('.blackc').removeClass('border');
                    $('.bluec').removeClass('border');
                    $('.orc').addClass('border');
            });
            $('.greyc').on('click',function(){
                    $('.c').css({'top':'100vh'});
                    $('.b').css({'top':'100vh'});
                    $('.a').css({'top':'0'});
                    $('.main').css({'top':'-100vh'});
                    $('.greyc').addClass('border');
                    $('.blackc').removeClass('border');
                    $('.bluec').removeClass('border');
                    $('.orc').removeClass('border');
            });
            $('.blackc').on('click',function(){
                    $('.c').css({'top':'100vh'});
                    $('.b').css({'top':'100vh'});
                    $('.a').css({'top':'100vh'});
                    $('.main').css({'top':'0'});
                    $('.greyc').removeClass('border');
                    $('.blackc').addClass('border');
                    $('.bluec').removeClass('border');
                    $('.orc').removeClass('border');
            });
            $('.bluec').on('click',function(){
                    $('.c').css({'top':'100vh'});
                    $('.b').css({'top':'0'});
                    $('.a').css({'top':'-100vh'});
                    $('.main').css({'top':'-100vh'});
                    $('.greyc').removeClass('border');
                    $('.blackc').removeClass('border');
                    $('.bluec').addClass('border');
                    $('.orc').removeClass('border');
            });
        </script>

</html>
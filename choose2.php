<!DOCTYPE html>
<?php 
    session_start(); 
?>
<html>
<head>
    <link href="choose.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <script src='http://code.jquery.com/jquery-3.2.1.min.js'></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <title>Выбор предпочтений</title>
</head>
<body>
    <div class="content">
        <div class="next">
            <a href="javascript:void(0)" style="cursor:default;">Теперь выберите категорию вашего блога</a>
            <a href="javascript:void(0)" class="button">Далее</a>
        </div>
        <div class="menu">
            <div class="box design"><div class="backfon"><div class="check"><img src="https://png.icons8.com/windows/30/2ecc71/checked.png"></div></div><div class="downtitle">Дизайн</div></div>
            <div class="box culture"><div class="backfon"><div class="check"><img src="https://png.icons8.com/windows/30/2ecc71/checked.png"></div></div><div class="downtitle">Культура</div></div>
            <div class="box games"><div class="backfon"><div class="check"><img src="https://png.icons8.com/windows/30/2ecc71/checked.png"></div></div><div class="downtitle">Игры</div></div>
            <div class="box sport"><div class="backfon"><div class="check"><img src="https://png.icons8.com/windows/30/2ecc71/checked.png"></div></div><div class="downtitle">Спорт</div></div>
            <div class="box news"><div class="backfon"><div class="check"><img src="https://png.icons8.com/windows/30/2ecc71/checked.png"></div></div><div class="downtitle">Новости</div></div>
            <div class="box mems"><div class="backfon"><div class="check"><img src="https://png.icons8.com/windows/30/2ecc71/checked.png"></div></div><div class="downtitle">Мемы</div></div>
            <div class="box movie"><div class="backfon"><div class="check"><img src="https://png.icons8.com/windows/30/2ecc71/checked.png"></div></div><div class="downtitle">Фильмы</div></div>
            <div class="box animals"><div class="backfon"><div class="check"><img src="https://png.icons8.com/windows/30/2ecc71/checked.png"></div></div><div class="downtitle">Животные</div></div>
            <div class="box world"><div class="backfon"><div class="check"><img src="https://png.icons8.com/windows/30/2ecc71/checked.png"></div></div><div class="downtitle">Мир</div></div>
            <div class="box beauty"><div class="backfon"><div class="check"><img src="https://png.icons8.com/windows/30/2ecc71/checked.png"></div></div><div class="downtitle">Красота</div></div>
        </div>
        <h1>LS</h1>
    </div>
    <div class="info" style="display:none"></div>
    <script>
        var g = 0;
        $('.box').on('click',function(){
            var str = $(this).find(".downtitle").html();
            $('.box .backfon').removeClass('backgr');
            $('.box .check').removeClass('show');
            $(this).find(".backfon").toggleClass('backgr');
            $(this).find(".check").toggleClass('show');
            $.ajax({
                url: 'blogcat.php?cat='+str,
                success: function(html) {
                    if(html == 'true') {  $('.button').css({'background':'rgba(255,255,255,0.95)','color':'rgba(0,0,0,0.7)', 'border':'none','font-weight':'bold'});
                     $('.button').attr('onclick','location.href="redirect.php"');
                    }
                    else {
                        $('.button').css({'background':'transparent','color':'white','border':'1px solid rgba(255,255,255,0.3)','font-weight':'normal'});
                        $('.button').attr('onclick','');
                    }
                },
            });
        });
    </script>
    <?php
    $conn = new mysqli('localhost', 'People', '123456', 'main');
    if ($conn->connect_error) die($conn->connect_error);
    $emailfor = str_replace('.', '', $_SESSION['email']);
    $emailfor = str_replace('@', '', $emailfor);
    $query = "SELECT * from design WHERE login='".$_SESSION['login']."'";
    $result = $conn->query($query);
    $rows = $result->num_rows;
    $result->data_seek(0);
    if($result->fetch_array()['category']!='') {
        print("<script>$('.button').css({'background':'rgba(255,255,255,0.95)','color':'rgba(0,0,0,0.7)', 'border':'none','font-weight':'bold'});
        $('.button').attr('onclick','location.href=\"redirect.php\"');</script>");
    }
    for($j=0;$j<$rows;$j++) {
        $result->data_seek($j);
        if($result->fetch_array()['category'] == 'Дизайн') {
            print('<script>$(".design .backfon").toggleClass(\'backgr\');
            $(".design .check").toggleClass(\'show\');</script>');
        }
        $result->data_seek($j);
        if($result->fetch_array()['category'] == 'Культура') {
            print('<script>$(".culture .backfon").toggleClass(\'backgr\');
            $(".culture .check").toggleClass(\'show\');</script>');
        }
        $result->data_seek($j);
        if($result->fetch_array()['category'] == 'Игры') {
            print('<script>$(".games .backfon").toggleClass(\'backgr\');
            $(".games .check").toggleClass(\'show\');</script>');
        }
        $result->data_seek($j);
        if($result->fetch_array()['category'] == 'Спорт') {
            print('<script>$(".sport .backfon").toggleClass(\'backgr\');
            $(".sport .check").toggleClass(\'show\');</script>');
        }
        $result->data_seek($j);
        if($result->fetch_array()['category'] == 'Новости') {
            print('<script>$(".news .backfon").toggleClass(\'backgr\');
            $(".news .check").toggleClass(\'show\');</script>');
        }
        $result->data_seek($j);
        if($result->fetch_array()['category'] == 'Мемы') {
            print('<script>$(".mems .backfon").toggleClass(\'backgr\');
            $(".mems .check").toggleClass(\'show\');</script>');
        }
        $result->data_seek($j);
        if($result->fetch_array()['category'] == 'Фильмы') {
            print('<script>$(".movies .backfon").toggleClass(\'backgr\');
            $(".movies .check").toggleClass(\'show\');</script>');
        }
        $result->data_seek($j);
        if($result->fetch_array()['category'] == 'Животные') {
            print('<script>$(".animals .backfon").toggleClass(\'backgr\');
            $(".animals .check").toggleClass(\'show\');</script>');
        }
        $result->data_seek($j);
        if($result->fetch_array()['category'] == 'Мир') {
            print('<script>$(".world .backfon").toggleClass(\'backgr\');
            $(".world .check").toggleClass(\'show\');</script>');
        }
        $result->data_seek($j);
        if($result->fetch_array()['category'] == 'Красота') {
            print('<script>$(".beauty .backfon").toggleClass(\'backgr\');
            $(".beauty .check").toggleClass(\'show\');</script>');
        }
    }
    ?>
</body>
</html>
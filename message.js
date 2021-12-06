function make() {
    $.ajax({
            url: 'write.php',
            cache: false,  
            success: function(html) {
                $('.messagebox').html(html);   
            },
    });
}

function finds() {
    setTimeout(function(){
        var note   = $('#formfind').serialize();
        $.ajax({
                type: 'POST',
                url: 'findlogin.php',
                data: note,
                success: function(html) {
                    $('.boxfind').html(html);
                },
        });
    },10);
}

function back() {
    $.ajax({
            url: 'backfind.php',
            cache: false,  
            success: function(html) {
                $('.messagebox').html(html);   
            },
    });
}

function strip(html) {
		var tmp = document.createElement("div");
		tmp.innerHTML = html;
		return tmp.textContent || tmp.innerText;
	}

function staff(id) {
    var content = $('#span'+id).html();
    content = strip(content);
    $('input[name="find"]').val(content);
    $('.boxfind').html('');
}

function send(id) {
   $('.select button').attr('onclick','send2(\''+id+'\')');
   $('.select button').css({'border':'none','background':'rgba(0,0,0,0.7)','color':'white'});
}

function send2(id) {
   $.ajax({
            url: 'textmessage.php?id='+id,
            cache: false,  
            success: function(html) {
                $('.messagebox').html(html); 
                setTimeout(function(){
                    $('.contentbox').scrollTop(1000000);
                },20);
            },
    });
}

function sms(id) {
    var smsphotoname = $('.smsphotoname').html();
    if($('#messager').val() != '') {
        setTimeout(function(){
            var note   = $('#sms').serialize();
            $.ajax({
                    type: 'POST',
                    url: 'sendmessage.php?id='+id+'&smsphotoname='+smsphotoname,
                    data: note,
                    success: function(html) {
                        $('.contentbox').append(html);
                        $('#sms').trigger('reset');
                        $('.contentbox').scrollTop(1000000);
                        $('#photo').html('<script type="text/javascript" src="message.js"></script>');
                    },
            });
        },10);
    }
}

function smsimgdelete(html,id) {
    $('#del'+id).remove();
    var value = $('.smsphotoname').html();
    value = value.replace(html+'***','');
    $('.smsphotoname').html(value);
}

function smsphoto() {
    $('#smsphoto').trigger('click');
}

function del_spaces(str) {
    str = str.replace(/\s/g, '');
    return str;
}

function update(id) {
    var row = $('#rows'+id).html();
    $.ajax({
            url: 'update.php?id='+id+'&rows='+row,
            cache: false,  
            success: function(html) {
                if(del_spaces(html) == row) {
                    setTimeout(function(){ update(id) },1000);
                }
                else {
                    $('#box'+id+' p').html(html);
                    setTimeout(function(){ update(id) },1000);
                }
            },
    });
}

function message() {
    var row = $('.messagecount').html();
    $.ajax({
            url: 'diarmescount.php',
            success: function(html) {
                if(del_spaces(html) != row) {
                    $('.messagecount').html(html);
                    $('.messagecount').css({'display':'block'});
                    if(del_spaces(html) == 0) {
                        $('.messagecount').css({'display':'none'});
                    }
                    setTimeout(function(){message()},1000);
                }
                else {
                    setTimeout(function(){message()},1000);
                }  
        },
    });
}

function checkall() {
    $.ajax({
        url: 'checkall.php',
        success: function(html) {
            $('.reading').css({'font-weight':'normal'});
            $('.countread').remove();
        },
    });
}

function openmenu() {
    $('.menusms').toggleClass('openmenu');
}

function closeback() {
    $('.deleteconfirm').remove();
}

function deleteall() {
    var login = $('.messageheaderlogin').html();
    $.ajax({
            url: 'delallmes.php?login='+login,
            success: function(html) {
                $('.deleteconfirm').remove();
                back();
            },
    });
}

function showconfirm() {
    var login = $('.messageheaderlogin').html();
    $('body').append('<div class="deleteconfirm"><div class="selectdel"><h1>Вы действительно хотите удалить диалог с '+login+'?</h1><br><span onclick="deleteall();"><img src="https://png.icons8.com/trash/win10/20/ffffff">Удалить</span><span class="back" onclick="closeback()">Отмена</span></div></div>');
}

function disturb() {
    var login = $('.messageheaderlogin').html();
    $.ajax({
            url: 'dontdisturb.php?login='+login,
            success: function(html) {
                if($('.change span').html() == 'Отключить уведомления') {
                    $('.change').html('<img src="https://png.icons8.com/windows/20/ffffff/appointment-reminders.png"> <span>Включить уведомления</span>');
                }
                else {
                    $('.change').html('<img src="icobell.ico" width="20" height="20"> <span>Отключить уведомления</span>');
                }
            },
    });
}

function block() {
    var login = $('.messageheaderlogin').html();
    $.ajax({
            url: 'block.php?login='+login,
            success: function(html) {
                if($('.block span').html() == 'Заблокировать пользователя') {
                    $('.block').html('<img src="https://png.icons8.com/windows/20/ffffff/shield.png"> <span>Разблокировать пользователя</span>');
                }
                else {
                    $('.block').html('<img src="https://png.icons8.com/windows/20/ffffff/no-entry.png"> <span>Заблокировать пользователя</span>');
                }
            },
    });
}

function notification() {
    $('.notifbox').toggleClass('makeanoteopen');
    $.ajax({
            url: 'notification.php',
            success: function(html) {
                $('.notifbox ul').html(html);
        },
    });
}

function notificationupdate() {
    var rows = $('.notifcount').html();
    $.ajax({
            url: 'notifcount.php',
            success: function(html) {
                if(del_spaces(html) != rows) {
                    $('.notifcount').html(html);
                    $('.notifcount').css({'display':'block'});
                    if(del_spaces(html) == 0) {
                        $('.notifcount').css({'display':'none'});
                    }
                    setTimeout(function(){notificationupdate()},1000);
                }
                else {
                    setTimeout(function(){notificationupdate()},1000);
                }  
        },
    });
}

function menuuser() {
    $('.userbox').toggleClass('userboxshow');
}

function shownotes() {
    $('.notifbox').removeClass('makeanoteopen');
    $('.allnote').toggleClass('block');
}

function shownotes3() {
    $('.support').toggleClass('block');
}

function keydown(inField,e) {
    if (e.which == 13) {
        $('.submit').trigger('click');
    }
}

function deletesms(id) {
        $.ajax({
                url: 'deletesms.php?id='+id,
                success: function(html) {
                    $('#sms'+id).css({'animation':'hide .5s ease forwards'});
                    setTimeout(function(){
                        $('#sms'+id).remove();
                    },510);
                },
        });
    }

function download(log) {
    $('.showmore').remove();
    $.ajax({
            url: 'download2.php?log='+log,
            success: function(html) {
                $('.contentbox').prepend(html);
                
            },
    });
}

$('#smsphoto').on('change', function(){
	files = this.files;
});
var c = 0;
$('#smsphoto').on( 'change', function( event ){
    c=c+1;
	event.stopPropagation(); // остановка всех текущих JS событий
	event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега

	// ничего не делаем если files пустой
	if( typeof files == 'undefined' ) return;

	// создадим объект данных формы
	var data = new FormData();

	// заполняем объект данных файлами в подходящем для отправки формате
	$.each( files, function( key, value ){
		data.append( key, value );
	});

	// добавим переменную для идентификации запроса
	data.append( 'my_file_upload', 1 );

	// AJAX запрос
	$.ajax({
		url         : 'smsphoto.php',
		type        : 'POST', // важно!
		data        : data,
		cache       : false,
		// отключаем обработку передаваемых данных, пусть передаются как есть
		processData : false,
		// отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
		contentType : false, 
		success     : function(html){
            if(html == 'falses') {
                $('body').append('<div class="warning" id="warn">Вы можете загрузить не больше 10 фотографий</div>');
                        setTimeout(function(){
                            $('#warn').css({'opacity':'0'});
                            setTimeout(function(){
                                $('#warn').remove();
                            },1000);
                        },1500);
            }
            else {
                $('#photo').append('<div class="mk-spinner-wrap"><div class="mk-spinner-ring" style="width:35px;height:35px;"></div></div>');
                $('.messagebox').css({'height':'auto'});
                setTimeout(function(){
                    $('#photo').append('<div class="smsdivimg" id="del'+c+'"><img src="tmp/'+html+'" width="60" height="60"><div class="delsmsimg"><img src="https://png.icons8.com/windows/30/ffffff/trash.png" onclick="smsimgdelete(\''+html+'\',\''+c+'\');"></div></div>');
                    $('.smsphotoname').append(html+'***');
                    $('.mk-spinner-wrap').remove();
                },500);
            }
		},
	});

});
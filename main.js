function make(){
    $('.makeanote').toggleClass('makeanoteopen');
    $('#make img').toggleClass('rotate');
    $('#make').toggleClass('makeset');
};

function closeline(){
    $('#make').trigger('click');
};

function strip_tags(str){	
	return str.replace(/<\/?[^>]+>/gi, '');
}

function opendiary(){
    $('.enterdiar').toggleClass('display');
    $('#lidiar').addClass('liopen');
    $('#linews').removeClass('liopen');
    $('#lilike').removeClass('liopen');
    $('#lifriends').removeClass('liopen');
};

$(document).keydown(function(eventObject){
                if (eventObject.which == 27)
                { $('.enterdiar').removeClass('display');$('.category').remove();}
});

function maked(){
    $('#diarinput').trigger('click');
};

function makeadiar(){
     var msg   = $('#diarform').serialize();
     var img = $('.infoblock').html();
                $.ajax({
                  type: 'POST',
                  url: 'makeadiar.php?img='+img,
                  data: msg,
                  success: function(html) {
                    $('.select').append(html);
                    $('.maked').html('<h1>Загрузить фото<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAACUSURBVEhL7ZK9CYAwEIUVK+3E1mHcyBmcQRBcww0cwsLaNYT4HkQ4IQrRi1U++Djuh7wmiQcDNEL26sQQL2KIFzHkkQL2cLQuUIawP3e84/0rWigfvpN3r0nhBF0Pn3LPu09UcIOuAM65V6GBO5QB7DlXpYMyhL06GZwhA1jZB6GGq61ByW2NhKP8wcvfD6VzqGhiDnrri4e6YvmTAAAAAElFTkSuQmCC" id="iconmaked"></h1>');
                    $('.maked').css({'border':'1px dashed grey'});
                    $('#diarform').trigger('reset');
                  },
            });
};

function enter(id) {
                $.ajax({
                  url: 'deletediar.php?post='+id,
                  cache: false,  
                  success: function(html) {
                    
                  },
                });
    $('#box'+id).css({'width':'0'});
    setTimeout(function(){
      $('#box'+id).css({'display':'none'});
    }, 2000);
}

function changes(id){
        $('#form'+id+' input').removeAttr('readonly'); 
        $('#form'+id+' textarea').removeAttr('readonly'); 
        $('#off'+id).attr('onclick','changes1("'+id+'");');
        $('#off'+id).toggleClass('bcb');
}

function changes1(id) {
    $('#off'+id).toggleClass('bcb');
    $('#form'+id+' input').attr('readonly',''); 
    $('#form'+id+' textarea').attr('readonly',''); 
    var msg   = $('#form'+id).serialize();
                    $.ajax({
                      type: 'POST',
                      url: 'makeadiar.php?id='+id,
                      data: msg,
                      success: function(html) {

                      },
                });
    $('#off'+id).attr('onclick','changes("'+id+'");');
    }

function newi(){
    $('.newimg').trigger('click'); 
};

function takeaphoto(){
    $('#photo').trigger('click'); 
};

function takeaphoto2(){
    $('#photo213').trigger('click'); 
};

function takeaphotoedit(){
    $('#photoedit').trigger('click'); 
};

function makenote(){
        var notename   = $('input[name="name"]').val();
        var lock   = $('#locked').prop('checked');
        var comments   = $('#comments').prop('checked');
        var notesod   = $('.ql-editor').html();
        var img1 = $('.infoblock2').html();
        var tags = $('.alltags').html();
        $('.tagg').remove();
                $.ajax({
                      type: 'POST',
                      url: 'makeanote.php?img='+img1,
                      data: {'name':notename,'sod':notesod,'q':tags,'locked':lock,'comments':comments},
                      success: function(html) {
                        
                        $('#makeanote').trigger('reset');
                        $('.ql-editor').html('');
                        $('#makeatext p').html('');
                        $('#allbox').prepend(html);
                        $('.allimage').html('');
                        $('.notselected').css({'display':'none'});
                        make();
                      },
                });
    
};

function deleteanote(id){
                    $.ajax({
                      url: 'deleteanote.php?id='+id,
                });
    $('#note'+id).css({'animation':'hide 1s ease'});
     setTimeout(function(){
        $('#note'+id).css({'display':'none'});
    }, 800);
    $('div.deleteconfirm').remove();
}

function deletenotes(id){
        $.ajax({
                url: 'deleteanote.php?id='+id,
                success: function(html) {
                            
            },
        });
        $('#note'+id).css({'animation':'hide 1s ease'});
        setTimeout(function(){
                $('#note'+id).css({'display':'none'});
        }, 800);
}

function newsnote(id,idcategory){
                    $.ajax({
                      url: 'newsnote.php?id='+id+'&idcat='+idcategory,
                      beforeSend: function(){
                            $('#allbox').html('<div class="mk-spinner-wrap"><div class="mk-spinner-ring"></div></div>');
                      },
                      success: function(html) {
                            news();
                            $('.category').remove();
                      },
                });
};

function news(){
     $('.newscolor').addClass('newscolorset');
     $('.likecolor').removeClass('likecolorset');
     $('.friendcolor').removeClass('friendcolorset');
     $('.notescolor').removeClass('notescolorset');
     $('#lidiar').removeClass('liopen');
     $('#linews').addClass('liopen');
     $('#lilike').removeClass('liopen');
     $('#lifriends').removeClass('liopen');
     $.ajax({
            type: 'POST',
            url: 'news.php',
            beforeSend: function(){
                $('#allbox').html('<div class="mk-spinner-wrap"><div class="mk-spinner-ring"></div></div>');
                $('.linewsspin').append('<div class="mk-spinner-wrap"><div class="mk-spinner-ring" style="width:17px;height:17px;left: 25px;top: 30px;"></div></div>');
            },
            success: function(html) {
                $('#allbox').html(html);
                setTimeout(function(){$('.linewsspin .mk-spinner-wrap').remove()},400);
            },
        });
    document.title = "Общая лента";
};

function like(id){
    $.ajax({
            url: 'like.php?id='+id,
            success: function(html) {
                $('.likef'+id).html(html);
            },
    });
};

function changelike(id) {
    $('.imglike'+id).html('<img src="https://png.icons8.com/color/20/000000/filled-like.png">&nbsp;');
    $('.like'+id).attr('onclick','like(\''+id+'\');changelike2(\''+id+'\');');
    $('.tolike'+id).css({'display':'block'});
    $('.tolike'+id).css({'animation':'hide 1s ease forwards'});
    setTimeout(function(){$('.tolike'+id).css({'display':'none'});},1000);
}

function changelike2(id) {
    $('.imglike'+id).html('<img src="https://png.icons8.com/windows/21/000000/hearts.png">&nbsp;');
    $('.like'+id).attr('onclick','like(\''+id+'\');changelike(\''+id+'\');');
}

function changelike3(id) {
    $('#imgcomlike'+id).html('<img src="https://png.icons8.com/material/17/666666/filled-like.png">');
    $('#imgcomlike'+id).attr('onclick','commentlike(\''+id+'\');changelike4(\''+id+'\');');
}

function changelike4(id) {
    $('#imgcomlike'+id).html('<img src="https://png.icons8.com/metro/17/666666/like.png">');
    $('#imgcomlike'+id).attr('onclick','commentlike(\''+id+'\');changelike3(\''+id+'\');');
}

function changelike5(id) {
    $('.like'+id).html('<div class="help helplike" style="left: -67px;">Мне нравится</div><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGtSURBVEhL7dXLKwVhHMbx485CSRQ2drIg5RYLWSErG7GSxMLGwkJZWvgDbMTGtQ5hq8SSlEtZWJEVklxSNiLX7/M2U9NcnOOMsztPfeL3zjvvO/POO3MiqfxHMtGILjQjC34pQQc6Ua6GeJKOMTzg2+EO/bBTgEV8wNlvHw0ITBqiUOdPbGMWO1at9lVU4cqqn7CMOVxYba9oh290pep0iSY1ONIKtev4m/V3A4WwoyUexxfukQ9PjqGTW0zljdb8GuqzAN25X+ahPkOmciQbWpIbUwVHEw0iw1T+0SbQJEumcqQYOnBqqnCphcbaNJUjOXjHs6nCpRuaRMvmyS50sM1UiUc7UOMMmMqVHujgEfSMEkk9tCLaXXlqcEcP8wCaaEYNf4zefnubD6shKNo9j1DHKQRtU3fKcAadt6aGWKmD3mSdsAJtit9SDfsOtpCLuFID+8XbQxH8os+HdqT6rSPWBXlSikNogHO4v7J90EPWZ2QC8S6tJ7p1e0vqziqhjECDv6BXDWGjK5yEJtJPwLT1v7ap+0MaOqPQ4HKLCiQlmugE+k1JJRmJRH4ABQlqxENPtQcAAAAASUVORK5CYII=">&nbsp;');
    $('.like'+id).attr('onclick','like(\''+id+'\');changelike6(\''+id+'\');');
}

function changelike6(id) {
    $('.like'+id).html('<div class="help helplike">Мне не нравится</div><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAGJSURBVEhL7VSxSgNBFFzQSkFBOz9C0GQ3IYghe0lIYZvGb9BWsBULO1HQDxBJL4KQHxBBEDsbbbSxUDG5i1bmnLf3xGiemrgpMzDssTtv5t7u3qkhvBDZ7HxkzX5ozTnGqzDQdTyvPFTMBEscnoqpSayt0rrTJfq9KEjPsaQbcbU6AtFOGJh2FJj4O2Fy2yzoRdLSCPM7Uefq9Tb5OeNOJG/RXdRJBEUwX8bYkta/0Jpdtk7QLGYWRKEHqaNGIZ3jCNfFoST0Jbo+4Ail0P6NJBoArzmCOtGPgsCf8OUIdBLoS1HkSezQBUdQiNmURL4kX45QqlXMzaCbV0n4X8LvhXw5IgFu2Jok9uA6W3+CvlCkHwnivkk+4hdPiJdSYxCcSYW9kurJhy1lPJezU7gVp5LBX6SARqCn2ep3uI6sOZaMfiJu0km7NDvOFr3BnZE1G+CbZPpB+keBW3E+P8ql/SMqmDJ+3fdSQDKvKyz1A50TzGrfAmo9738/CG2mhMOtU3c8NcSgodQ7KGYUx3qTahcAAAAASUVORK5CYII=">&nbsp;');
    $('.like'+id).attr('onclick','like(\''+id+'\');changelike5(\''+id+'\');');
    $('.tolike'+id).css({'display':'block'});
    $('.tolike'+id).css({'animation':'hide 1s ease forwards'});
    setTimeout(function(){$('.tolike'+id).css({'display':'none'});},1000);
}

var files;

function commentsend(id) {
    var note   = $('.commentsend'+id).serialize();
    var login  = $('.comins'+id).html();
                    $.ajax({
                      type: 'POST',
                      url: 'comment.php?id='+id+'&login='+login,
                      data: note,
                      success: function(html) {
                        $('.allcom'+id).append(html);
                        $('#commentsend'+id).trigger('reset');
                        $('.textarea'+id).val('');
                        $('#comins'+id).html('');
                        $('.countcomf'+id).html(parseInt($('.countcomf'+id).html()) + 1);
                      },
                });
}

function docom(id) {
    $('.textarea'+id).trigger('click');
    $('.textarea'+id).trigger('focus');
}

function avatar() {
    $('#avatar').trigger('click');
}

function subscribe(id) {
            $.ajax({
                url: 'subscribe.php?id='+id,
                success: function(html) {
                    $('#follow'+id).html('Вы читаете').addClass('youcheck').attr('onclick','deletesub("'+id+'")');
                    $('.following').addClass('abcd1');
                    $('#follow'+id).attr('onmouseover','$(this).html(\'Не читать?\')');
                    $('#follow'+id).attr('onmouseout','$(this).html(\'Вы читаете\')');
                },
            });
}

function deletesub(id) {
            $.ajax({
                url: 'subscribe.php?iddel='+id,
                success: function(html) {
                    $('#follow'+id).html('<img src="https://png.icons8.com/windows/15/ffffff/plus.png">Читать');
                    $('.following').removeClass('abcd1');
                    $('#follow'+id).removeAttr('onmouseover');
                    $('#follow'+id).attr('onclick','subscribe(\''+id+'\')');
                    $('#follow'+id).removeAttr('onmouseout');
                },
                
            });
}

function newslike() {
            $('.likecolor').addClass('likecolorset');
            $('.newscolor').removeClass('newscolorset');
            $('.friendcolor').removeClass('friendcolorset');
            $('.notescolor').removeClass('notescolorset');
            $('#lidiar').removeClass('liopen');
            $('#linews').removeClass('liopen');
            $('#lilike').addClass('liopen');
            $('#lifriends').removeClass('liopen');
            $.ajax({
                url: 'newslike.php',
                beforeSend: function(){
                    $('#allbox').html('<div class="mk-spinner-wrap"><div class="mk-spinner-ring"></div></div>');
                    $('.lilikespin').append('<div class="mk-spinner-wrap"><div class="mk-spinner-ring" style="width:17px;height:17px;left: 25px;top: 30px;"></div></div>');
                },
                success: function(html) {
                    setTimeout(function(){$('.lilikespin .mk-spinner-wrap').remove()},400);
                    $('#allbox').html(html);
                },
            });
    document.title = "Понравившиеся";
}

function newssub() {
            $('.friendcolor').addClass('friendcolorset');
            $('.newscolor').removeClass('newscolorset');
            $('.likecolor').removeClass('likecolorset');
            $('.notescolor').removeClass('notescolorset');
            $('#lidiar').removeClass('liopen');
            $('#linews').removeClass('liopen');
            $('#lilike').removeClass('liopen');
            $('#lifriends').addClass('liopen');
            $.ajax({
                url: 'newssub.php',
                beforeSend: function(){
                $('.lifriendsspin').append('<div class="mk-spinner-wrap"><div class="mk-spinner-ring" style="width:17px;height:17px;left: 25px;top: 30px;"></div></div>');
                $('#allbox').html('<div class="mk-spinner-wrap"><div class="mk-spinner-ring"></div></div>');
                },
                success: function(html) {
                    setTimeout(function(){$('.lifriendsspin .mk-spinner-wrap').remove()},400);
                    $('#allbox').html(html);
                },
            });
}

function deletehover(id) {
        $('#note'+id+' .deleteanote img').attr('src','https://png.icons8.com/trash/win10/20/e74c3c');
}

function delimage(noteid,id) {
    $.ajax({
            url: 'delimage.php?noteid='+noteid+'&id='+id,
            success: function(html) {
                $('#del'+id).css({'animation':'hide 1s ease'});
                setTimeout(function(){
                    $('#del'+id).remove();
                },1000);
                $('.header').html(html);
            },
        });
}

function deletehover2(id) {
        $('#note'+id+' .deleteanote img').attr('src','https://png.icons8.com/trash/win10/20/333333');
}

function newshover(id) {
        $('#note'+id+' .newsnote img').attr('src','https://png.icons8.com/undo/dotty/20/2980b9');
}

function newshover2(id){           
        $('#note'+id+' .newsnote img').attr('src','https://png.icons8.com/undo/dotty/20/333333');
}

function finds() {
    setTimeout(function(){
        var note   = $('#findform').serialize();
        $.ajax({
                type: 'POST',
                url: 'find.php',
                data: note,
                success: function(html) {
                    $('.findnote').html(html);
                },
        });
    },10);
        
}

function findlss() {
    setTimeout(function(){
        var note   = $('#findlsform').serialize();
        $.ajax({
                type: 'POST',
                url: 'findls.php',
                data: note,
                success: function(html) {
                    $('.findlsnote').html(html);
                },
        });
    },10); 
}

function findblogs(id) {
    setTimeout(function(){
        var note   = $('#findblogform').serialize();
        $.ajax({
                type: 'POST',
                url: 'findblog.php?id='+id,
                data: note,
                success: function(html) {
                    $('.findblognote').html(html);
                },
        });
    },10); 
}

function strip(html) {
		var tmp = document.createElement("div");
		tmp.innerHTML = html;
		return tmp.textContent || tmp.innerText;
	}

function findselect(id) {
    $('.newscolor').removeClass('newscolorset');
    $('.likecolor').removeClass('likecolorset');
    $('.friendcolor').removeClass('friendcolorset');
    $('.notescolor').removeClass('notescolorset');
    var stack   = $('#find'+id+' .findtext').html();
    stack = strip(stack);
    $('input[name="find"]').val(stack);
    setTimeout(function(){
        var note = $('#findform').serialize();
        $.ajax({
                type: 'POST',
                url: 'findselect.php',
                data: note,
                beforeSend: function(){
                $('#allbox').html('<div class="mk-spinner-wrap"><div class="mk-spinner-ring"></div></div>');
                },
                success: function(html) {
                    $('.findnote').html('');
                    $('#allbox').html(html);
                },
        });
    },10);
        
}

function findblogselect(id,idfind) {
    var stack   = $('#find'+idfind+' .findtext').html();
    stack = strip(stack);
    $('input[name="findblog"]').val(stack);
    setTimeout(function(){
        var note = $('#findblogform').serialize();
        $.ajax({
                type: 'POST',
                url: 'findblogselect.php?id='+id,
                data: note,
                beforeSend: function(){
                $('#allbox').html('<div class="mk-spinner-wrap"><div class="mk-spinner-ring"></div></div>');
                },
                success: function(html) {
                    $('.findblognote').html('');
                    $('.allbox').html(html);
                },
        });
    },10);
        
}

function edit(id) {
    $('.allimage').html('');
    var c=0;
    $.ajax({
        url: 'checks.php?id='+id,
        success: function(html) {
            if(html == 'yes') {
                $('#comments').attr('checked','checked');
            }
        },
    });
    if($('#note'+id+' .lock').html() != '') {
        $('#locked').attr('checked','checked');
    }
    var name  = $('#h1note'+id).html();
    $('#makeanote input[name="name"]').val(name);
    var sod   = $('#namenote'+id).html();
    if(sod == undefined) sod = "";
    var tag   = $('#note'+id+' .tags span').html();
    for(j=0;j<10;j++) {
        var img   = $('#note'+id+' #image'+j).attr('src');
        var img1 = "";
        if(img == undefined) {img = ''; var img1 = undefined;}
        if(img1 == undefined) {
            $('.allimage').append('');
        }
        else {
            var c = c+1;
            var height = $('#note'+id+' #image'+j).height();
            $('.allimage').append('<div id="del'+j+'" style="transition:all .5s ease"><div class="deleditfon" style="height:'+height+'px"><img src="https://png.icons8.com/windows/120/ffffff/trash.png" class="deleteedit" onclick="delimage(\''+id+'\',\''+j+'\')"></div><img src="'+img+'" width="100%"></div>');
        }
    }
    $.ajax({
            url: 'count.php?c='+c,
        });
    var tag = strip(tag);
    if(tag!='undefined') {
        var tag = tag.split(' ');
        var rows = tag.length;
        for(i=0;i<rows;i++) {
            if(tag[i] != '')
            $('.alltags').append('<div class="tagg">'+tag[i]+'&nbsp;</div>');
        }
    }
    var clas = $('#make').attr('class');
    if(clas != 'idmake rotate makeset') {
        $('#make').trigger('click');
    }
    $('.ql-editor').html(sod);
    $('input[name="tag"]').val(tag);
    $('#makeh1').html('Редактирование записи <img src="https://png.icons8.com/close-window/color/20/000000" style="position:relative;top:4px;cursor:pointer;" onclick="clearbox()">');
    $('#makenote').html('Сохранить');
    $('#takeaph').attr('onclick','takeaphoto2()');
    $('#makeanote').append('<div class="ideditnote" style="display:none">'+id+'</div>');
    $('#makenote').attr('onclick','editnote(\''+id+'\')');
    $('.takeaphoto').css({'display':'none'});
    elementClick = $('.makeanote');
    destination = $(elementClick).offset().top;
    $('html').animate( { scrollTop: destination-80 }, 1100 );
}

function deledit(id) {
        $.ajax({
                url: 'deledit.php?id='+id,
                success: function(html) {
                    $('.photo img').css({'animation':'hide 0.7s linear forwards'});
                    $('.photo .deleditfon').css({'animation':'hide 0.7s linear forwards'});
                    setTimeout(function(){
                        $('.photo img').css({'display':'none'});
                        $('.photo').html('<div class="takeaphoto2" onclick="takeaphotoedit();"><h1><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAEUSURBVEhL7ZU9agJBHEfXKrEScgpvkCZNwFTWXiCNSC6RLiRtjhBsAjaCCNYBBfEQpkhIyqT24/10/zDsxzgLg1j44LHrwP7fMiu7yZmT5ho7EdW8HH3cRFTzcmjxB1sR1JzSyHJ/GkwNX1FDB1hHoTnRIrprbc1HenxAUSlyhUNs7n7luUUNn6fHLorgiAIL1MXf6IYa+ISX+Iyf+IYXKIIiFljhC/6jhRSYoeJjVCjLwYgbuEdxg3+okLZmjSMsC3kjv5gNGG3UUAV6WoBHLAp5I7qgKKAtmqIbMIpC3kjVgJENHXwmLvaQfQHDDX1hUKRKwLCQLI3Yu+sO7W/6nq6FOkFvxO4ihoWRo3xPzpwCSbIF6r6idVBXU7QAAAAASUVORK5CYII=" style="position: relative;top:6px;"> Загрузить изображение</h1></div><span id="idofnote" style="display:none">'+id+'</span><input type="file" id="photoedit"></script>');
                    },1000);
                },
        });
}

function editnote(id) {
    var notename   = $('input[name="name"]').val();
    var notesod   = $('.ql-editor').html();
    var img1 = $('.infoblock2').html();
    var tags = $('.alltags').html();
    var lock   = $('#locked').prop('checked');
    var comments   = $('#comments').prop('checked');
    $('.tagg').remove();
        $.ajax({
            type: 'POST',
            url: 'editnote.php?id='+id,
            data: {'name':notename,'sod':notesod,'q':tags,'locked':lock,'comments':comments},
            success: function(html) {
            $('#note'+id).html(html);
            },
        });
    clearbox();
    $('#makenote').attr('onclick','makenote()');
    elementClick = $('#note'+id);
    destination = $(elementClick).offset().top;
    $('html').animate( { scrollTop: destination-70 }, 700 );
}

function clearbox(){
    $('.tagg').remove();
    $('#takeaph').attr('onclick','takeaphoto()');
    $('#makenote').html('Создать');
    $('.makeanote form').trigger('reset');
    $('#makeh1').html('Создание записи'); 
    $('#makenote').attr('onclick','makenote()');
    $('.allimage').html('');
    $('.ql-editor').html('');
    $('#locked').removeAttr("checked");
    $('#comments').removeAttr("checked");
    make();
}

function closeback() {
    $('div.deleteconfirm').remove();
}

function deleteanoteconfirm(id){
    $('body').append('<div class="deleteconfirm"><div class="selectdel"><h1>Вы действительно хотите удалить запись?</h1><br><span onclick="deleteanote(\''+id+'\');"><img src="https://png.icons8.com/trash/win10/20/ffffff">Удалить</span><span class="back" onclick="closeback()">Отмена</span></div></div>');
}

function repostconfirm(id){
    $('body').append('<div class="deleteconfirm"><div class="selectdel"><h1>Вы действительно хотите поделиться постом?</h1><br><span onclick="reblog(\''+id+'\');" style="background:rgba(66, 167, 255,0.8) !important;"><img src="https://png.icons8.com/material/21/ffffff/refresh.png" style="top:5px;">Репост</span><span class="back" onclick="closeback()">Отмена</span></div></div>');
}

function background() {
    $('#filing').trigger('click');
}

function category(id) {
    $('body').append('<div class="category"><div class="selectcat"><h1>Выберите категорию</h1><div class="circle" style="animation: scale 2s ease 1;" onclick="newsnote(\''+id+'\',\'1\')"><span>Жизнь</span></div><div class="circle" style="animation: scale 1.8s ease 1;" onclick="newsnote(\''+id+'\',\'2\')"><span>Любовь</span></div><div class="circle" style="animation: scale 1.6s ease 1;" onclick="newsnote(\''+id+'\',\'3\')"><span style="position:relative;right:2px;">Литература</span></div><div class="circle" style="animation: scale 1.4s ease 1;" onclick="newsnote(\''+id+'\',\'4\')"><span>Карьера</span></div><div class="circle" style="animation: scale 1.2s ease 1;" onclick="newsnote(\''+id+'\',\'5\')"><span style="position:relative;right:7px;">Развлечения</span></div><br><br><div class="circle" style="animation: scale 1s ease 1;" onclick="newsnote(\''+id+'\',\'6\')"><span>Здоровье</span></div><div class="circle" style="animation: scale 0.8s ease 1;" onclick="newsnote(\''+id+'\',\'7\')"><span>Бизнес</span></div><div class="circle" style="animation: scale 0.6s ease 1;" onclick="newsnote(\''+id+'\',\'8\')"><span>Наука</span></div><div class="circle" style="animation: scale 0.4s ease 1;" onclick="newsnote(\''+id+'\',\'9\')"><span>Дизайн</span></div><div class="circle" style="animation: scale 0.2s ease 1;" onclick="newsnote(\''+id+'\',\'10\')"><span>Еда</span></div></div></div>');
}

function newscategory(id) {
    $.ajax({
                      url: 'newscategory.php?id='+id,
                      success: function(html) {
                        $('#allbox').html(html);
                      },
                });
}

function reblog(id) {
    $('div.deleteconfirm').remove();
    $.ajax({
            url: 'reblog.php?id='+id,
            success: function(html) {
                $('.countrepf').html(parseInt($('.countrepf').html()) + 1);
                $('.main').prepend(' <div class="repostinfo" style="animation:hide 1s ease;animation-delay:500ms;"><p>Вы поделились постом</p></div>');
                setTimeout(function(){$('.repostinfo').remove();},1500);
            },
    });
}

function del_spaces(str) {
    str = str.replace(/\s/g, '');
    return str;
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
                    $.ajax({
                        url: 'getmes.php',
                        success: function(html) {
                            $('.main1').prepend(html);
                            setTimeout(function(){
                                $('.getmessage').fadeOut( "slow", function() {
                                    $('.getmessage').remove();
                                });
                            },3500);
                        },
                    });
                    setTimeout(function(){message()},1000);
                }
                else {
                    setTimeout(function(){message()},1000);
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

function deletenewsconfirm(id) {
    $('body').append('<div class="deleteconfirm"><div class="selectdel"><h1>Вы действительно хотите удалить запись из ленты?</h1><br><span onclick="deletenew(\''+id+'\');"><img src="https://png.icons8.com/trash/win10/20/ffffff">Удалить</span><span class="back" onclick="closeback()">Отмена</span></div></div>');
}

function deletenew(id) {
       $.ajax({
            url: 'deletenew.php?id='+id,
            success: function(html) {
                $('div.deleteconfirm').remove();
                $('#note'+id).css({'animation':'hide 1s ease'});
                 setTimeout(function(){
                    $('#note'+id).css({'display':'none'});
                }, 800);
            },
    });
}

function delcomm(id) {
       $.ajax({
            url: 'deletecomm.php?id='+id,
            success: function(html) {
                $('#comment'+id).css({'animation':'hide 1s ease'});
                 setTimeout(function(){
                    $('#comment'+id).remove();
                }, 800);
            },
    });
}

function showsend(id) {
    $('.sends'+id).css({'display':'block'});
}

function reply(id,idbox) {
    var comment = $('#comid'+id).html();
    $('#comins'+idbox).html('<span class="comanswer">Вы отвечаете: <span class="comanswerspan comins'+idbox+'">'+comment+'</span><span class="comanswerspandelete"><img src="https://png.icons8.com/windows/20/666666/delete-sign.png" onclick="comanswerspandelete(\''+idbox+'\');" style="cursor:pointer;"></span></span>');
    if($('.textarea'+idbox).val().length == 0) {
        var ta = document.querySelector('.textarea'+idbox);
        ta.value = comment+', ';
        autosize.update(ta);
    }
    $('.textarea'+idbox).trigger('click');
}

function comanswerspandelete(id) {
    $('#comins'+id).html('');
}

function commentlike(id) {
    $.ajax({
            url: 'like.php?comment='+id,
            success: function(html) {
                $('.likecomnum'+id).html(html);
            },
    });
}

function idl(id) {
    $.ajax({
            url: 'idontlikeit.php?id='+id,
            success: function(html) {
                $('#note'+id).css({'animation':'hide 1s ease'});
                 setTimeout(function(){
                    $('#note'+id).remove();
                }, 800);
            },
    });
}

function userprofile(id) {
    setTimeout(function(){
        if($('#user'+id+':hover').length == 0 && $('#userli'+id+':hover').length != 0) {
            $('#user'+id).css({'animation':'show 1s ease 1 forwards','display':'block'});
        }
        else {
            return false;
        }
    },400);
}

function userprofile2(id) {
    if($('#user'+id+':hover').length == 0 && $('#userli'+id+':hover').length == 0) {
        $('#userli'+id+' .imgloguser').attr('onmouseover','');
        $('#user'+id).css({'animation':'hide 0.2s ease 1 forwards'});
        setTimeout(function(){
            $('#user'+id).css({'display':'none'});
            $('#userli'+id+' .imgloguser').attr('onmouseover','userprofile(\''+id+'\')');
        },200);
    }
}

function userprofile3(id) {
    setTimeout(function(){
        if($('#avataruser'+id+':hover').length != 0) {
            $('#user'+id).css({'animation':'show 1s ease 1 forwards','display':'block'});
        }
        else {
            return false;
        }
    },400);
}

function userprofile4(id) {
    if($('#user'+id+':hover').length == 0) {
        $('#user'+id).css({'animation':'hide 0.2s ease 1 forwards'});
        setTimeout(function(){
            $('#user'+id).css({'display':'none'});
        },200);
    }
}

function more(id) {
    $.ajax({
            url: 'showmore.php?id='+id,
            success: function(html) {
                $('#namenote'+id).html(html);
            },
    });
}

function morediar(id) {
    $.ajax({
            url: 'showmorediar.php?id='+id,
            success: function(html) {
                $('#namenote'+id).html(html);
            },
    });
}

function showmorecom(id) {
    $.ajax({
            url: 'showmorecom.php?id='+id,
            success: function(html) {
                $('.allcom'+id).html(html);
            },
    });
}

function download() {
    $.ajax({
            url: 'download.php',
            success: function(html) {
                $('.mk-spinner-wrap').remove();
                $('#allbox').append(html);
            },
    });
}

function downloadblog() {
    $.ajax({
            url: 'download.php',
            success: function(html) {
                $('.mk-spinner-wrap').remove();
                $('.allbox').append(html);
            },
    });
}

function diaryup() {
    $.ajax({
            url: 'diaryup.php',
            beforeSend: function(){
                $('.lidiarspin').append('<div class="mk-spinner-wrap"><div class="mk-spinner-ring" style="width:17px;height:17px;left: 25px;top: 30px;"></div></div>');
            },
            success: function(html) {
                $('#allbox').html(html);
                setTimeout(function(){$('.lidiarspin .mk-spinner-wrap').remove()},400);
                $('#lidiar').addClass('liopen');
                $('#linews').removeClass('liopen');
                $('#lilike').removeClass('liopen');
                $('#lifriends').removeClass('liopen');
                $('.likecolor').removeClass('likecolorset');
                $('.newscolor').removeClass('newscolorset');
                $('.friendcolor').removeClass('friendcolorset');
                $('.notescolor').addClass('notescolorset');
            },
    });
}

function desnoavatar() {
    if($("#noavatar").is(":checked")) {  
        $.ajax({
            url: 'desnoavatar.php?bool=yes',
            success: function(html) {
                $('.avatar').css({'display':'inline-block'});
            },
        });
    }
    else {
        $.ajax({
            url: 'desnoavatar.php?bool=no',
            success: function(html) {
                $('.avatar').css({'display':'none'});
            },
        });
    }
}

function desspace() {
    if($("#space").is(":checked")) {  
        startdrag();
    }
    else {
        stopdrag();
    }
}

function dessquare() {
    $.ajax({
            url: 'dessquare.php',
            success: function(html) {
                $('.avatar').css({'border-radius':'5px'});
                $('.avatarformsquare').css({'border':'2px solid black'});
                $('.avatarformcircle').css({'border':'2px solid grey'});
            },
        });
}

function descircle() {
     $.ajax({
            url: 'desscircle.php',
            success: function(html) {
                $('.avatar').css({'border-radius':'150px'});
                $('.avatarformcircle').css({'border':'2px solid black'});
                $('.avatarformsquare').css({'border':'2px solid grey'});
            },
        });
}

function deslogins() {
    setTimeout(function(){
        var sod = $('#dessetform').serialize();
        $.ajax({
            type: "POST",
            data: sod,
            url: 'deslogin.php',
            success: function(html) {
                $('.titlein h1').html(html);
            },
        });
    },10);
}

function descriptions() {
    setTimeout(function(){
        var sod = $('#dessetform').serialize();
        $.ajax({
            type: "POST",
            data: sod,
            url: 'description.php',
            success: function(html) {
                $('.description p').html(html);
            },
        });
    },10);
}

function description2s() {
    setTimeout(function(){
        var sod = $('#dessetform').serialize();
        $.ajax({
            type: "POST",
            data: sod,
            url: 'description2.php',
            success: function(html) {
                $('.description2').html(html);
            },
        });
    },10);
}

function pick() {
    $('#colorpicker').toggleClass('pick');
}

function pick2() {
    $('#colorpicker2').toggleClass('pick');
}

function desback() {
    setTimeout(function(){
        var sod = $('#pick1').val();
        sod = sod.slice(1);
        $.ajax({
            
            url: 'desback.php?color='+sod,
            success: function(html) {
                $('body').css({'background':html});
            },
        });
    },10);
}

function descolor() {
    setTimeout(function(){
        var sod2 = $('#pick2').val();
        sod2 = sod2.slice(1);
        $.ajax({
            url: 'descolor.php?color='+sod2,
            success: function(html) {
                $('.titlein h1').css({'color':html});
            },
        });
    },10);
}

function desnoback() {
    if($("#noback").is(":checked")) {  
        $.ajax({
            url: 'desnoback.php?bool=yes',
            success: function(html) {
                $('.background').css({'background':'transparent'});
                $('.house .blackfon').css({'background':'transparent'});
            },
        });
    }
    else {
        $.ajax({
            url: 'desnoback.php?bool=no',
            success: function(html) {
                $('.background').css({'background':''});
                $('.house .blackfon').css({'background':''});
            },
        });
    }
}

function showstyle() {
    $('.fontbox').toggleClass('fontboxopen');
}

function font(font) {
    $.ajax({
            url: 'fontblog.php?font='+font,
            success: function(html) {
                $('.titlein h1').css({'font-family':html});
                font = html.slice(0, -1);
                font = font.slice(1);
                $('.font').html(font);
                $('.font').css({'font-family':html});
            },
        });
}

function settings() {
    $('.settings').toggleClass('settingsopen');
    $('.main').toggleClass('mainopen');
}

function scheme(id) {
    $.ajax({
            url: 'scheme.php?id='+id,
            success: function(html) {
                $('.scheme').css({'border':'none'});
                $('#scheme'+id).css({'border':'2px solid white'});
                if(id != 4) {
                    $('.scheme').css({'padding-bottom':'5px'});
                }
                else {
                    $('#scheme'+id).css({'padding-bottom':'0'});
                }
                location.reload();
            },
        });
}

function ranges() {
        $('.output').val($('#range').val());
        var id = $('#range').val();
         $.ajax({
                url: 'fontsize.php?id='+id,
                success: function(html) {
                    $('.titlein h1').css({'font-size':html+'px'});
                },
        });
}

function range2() {
    setTimeout(function(){
        $('#range').val($('.output').val());
        id = $('#range').val();
         $.ajax({
                url: 'fontsize.php?id='+id,
                success: function(html) {
                    $('.titlein h1').css({'font-size':html+'px'});
                },
        });
    },10);
}

function range3s() {
    $('.output2').val($('#range2').val());
        var id = $('#range2').val();
         $.ajax({
                url: 'descriptionsize.php?id='+id,
                success: function(html) {
                    $('.description p').css({'font-size':html+'px'});
                },
        });
}

function range4() {
    setTimeout(function(){
        $('#range2').val($('.output2').val());
        id = $('#range2').val();
         $.ajax({
                url: 'descriptionsize.php?id='+id,
                success: function(html) {
                    $('.description p').css({'font-size':html+'px'});
                },
        });
    },10);
}

function range5() {
    $('.output3').val($('#range3').val());
        var id = $('#range3').val();
         $.ajax({
                url: 'avatarsize.php?id='+id,
                success: function(html) {
                    $('.avatar').css({'width':html+'px','height':html+'px'});
                },
        });
}

function range6() {
    setTimeout(function(){
        $('#range3').val($('.output3').val());
        id = $('#range3').val();
         $.ajax({
                url: 'avatarsize.php?id='+id,
                success: function(html) {
                    $('.avatar').css({'width':html+'px','height':html+'px'});
                },
        });
    },10);
}

function range7() {
    $('.output4').val($('#range4').val());
        var id = $('#range4').val();
         $.ajax({
                url: 'backgroundsize.php?id='+id,
                success: function(html) {
                    $('.background').css({'height':html+'px'});
                    var pad = $('.allbox').css('padding-top');
                    pad = pad.substr(0, pad.length - 2);
                    var str = parseFloat(html) - parseFloat(pad);
                    if($('#scheme3').css('border') == '2px solid rgb(255, 255, 255)') {
                        str = str - 30;
                    }
                    if($('#scheme2').css('border') == '2px solid rgb(255, 255, 255)') {
                        str = str + 110;
                    }
                    if($('#scheme1').css('border') == '2px solid rgb(255, 255, 255)') {
                        str = str - 10;
                    }
                    $('.allbox').css({'padding-top':parseFloat(pad)+parseFloat(str)+'px'});
                    $(".main").on("scroll", function() {
                        if ($(this).scrollTop() == 0) {
                            $(".background").css({"top":"0"});
                            $(".allbox").css({"padding-top":parseFloat(pad)+parseFloat(str)});
                        }
                    });
                },
        });
}

function range8() {
    setTimeout(function(){
        $('#range4').val($('.output4').val());
        id = $('#range4').val();
         $.ajax({
                url: 'backgroundsize.php?id='+id,
                success: function(html) {
                    $('.background').css({'height':html+'px'});
                    var pad = $('.allbox').css('padding-top');
                    pad = pad.substr(0, pad.length - 2);
                    var str = parseFloat(html) - parseFloat(pad);
                    str = str + 110;
                    $('.allbox').css({'padding-top':parseFloat(pad)+parseFloat(str)+'px'});
                    $(".main").on("scroll", function() {
                        if ($(this).scrollTop() == 0) {
                            $(".background").css({"top":"0"});
                            $(".allbox").css({"padding-top":parseFloat(pad)+parseFloat(str)});
                        }
                    });
                },
        });
    },10);
}

function editclick() {
    $('.maketags').trigger('focus');
}

function stack(event){
                if ($('.maketags').html() == '' && event.which == 8)
                    {
                        $('.alltags .tagg:last').remove();
                    }
                if (event.which == 32 || event.which == 13)
                    {
                        event.preventDefault();
                    }
                setTimeout(function(){
                    if($('.maketags').html() == '' && !$('.tagg').length) {
                        $('.placehold').css({'display':'block'});
                    }
                    else {
                        $('.placehold').css({'display':'none'});
                    }
                    if (event.which == 32 || event.which == 13)
                    {
                        $('.makeanote .alltags').append('<div class="tagg">#'+$('.maketags').html()+'&nbsp;</div>');
                        $('.maketags').html('');
                    }
                },5)
}

function startdrag(){
    $('.warning').addClass('warn');
        $('.avatar').draggable({
               stop: function(event, ui) {
                var a=event.type;
                var c=ui.position.left;
                var d=ui.position.top;
                var devicew = $('.background').width();
                var deviceh = $('.background').height();
                var block = $('.avatar').height();
                
                $.ajax({
                url: 'width.php?top='+d+'&left='+c,
                success: function(html) {
                    $('.avatar').css({'position':'relative','top':d+'','left':c+''});
                },
        });
            }
            });
                $('.titlein').draggable({
               stop: function(event, ui) {
                    var a=event.type;
                    var c=ui.position.left;
                    var d=ui.position.top;
                    var devicew = $('.background').width();
                    var deviceh = $('.background').height();
                    var block = $('.titlein').height();
                    $.ajax({
                        url: 'widthh1.php?top='+d+'&left='+c,
                        success: function(html) {
                            $('.titlein').css({'position':'relative','top':d+'','left':c+''});
                        },
                    });
                }
            });
                $('.description').draggable({
                stop: function(event, ui) {
                    var a=event.type;
                    var c=ui.position.left;
                    var d=ui.position.top;
                    var devicew = $('.background').width();
                    var deviceh = $('.background').height();
                    var block = $('.description').height();
                    $.ajax({
                    url: 'widthp.php?top='+d+'&left='+c,
                    success: function(html) {
                        $('.description').css({'position':'relative','top':d+'','left':c+''});
                    },
                    });
                }
            });
            }

function stopdrag(){
                $('.warning').removeClass('warn');
                $('.avatar').draggable('destroy');
                $('.titlein').draggable('destroy');
                $('.description').draggable('destroy');
            }

function findtag(id) {
    $('.newscolor').removeClass('newscolorset');
    $('.likecolor').removeClass('likecolorset');
    $('.friendcolor').removeClass('friendcolorset');
    $('.notescolor').removeClass('notescolorset');
    var tag = $('#tag'+id).html();
    $('input[name=\'find\']').val(tag);
    setTimeout(function(){
        var note = $('#findform').serialize();
        $.ajax({
                type: 'POST',
                url: 'findselect.php',
                data: note,
                beforeSend: function(){
                $('#allbox').html('<div class="mk-spinner-wrap"><div class="mk-spinner-ring"></div></div>');
                },
                success: function(html) {
                    $('#allbox').html(html);
                },
        });
    },10);
}

function delimg(html) {
    $('div[data-img="'+html+'"]').css({'animation':'hide 1s ease'});
    setTimeout(function(){
        $('div[data-img="'+html+'"]').remove();
        var value = $('.infoblock2').html();
        value = value.replace(html+'***','');
        $('.infoblock2').html(value);
    },1000);
    $.ajax({url: 'fcount.php',});
}

function delimg2(html) {
    $('div[data-img="'+html+'"]').css({'animation':'hide 1s ease'});
    var str = html;
    setTimeout(function(){
        $('div[data-img="'+html+'"]').remove();
    },1000);

    $.ajax({type:'POST',data:{'img':str},url: 'fcount2.php',});
}

function changeimg() {
    $('#takeaph').attr('src','https://png.icons8.com/windows/26/333333/camera.png');
}

function changeimg2() {
    $('#takeaph').attr('src','https://png.icons8.com/windows/26/999999/camera.png');
}

function changeimg3() {
    $('#takeaph2').attr('src','gif.png');
}

function changeimg4() {
    $('#takeaph2').attr('src','gif2.png');
}

function shownotes() {
    $('.notifbox').removeClass('makeanoteopen');
    $('.allnote').toggleClass('block');
}

function shownotes2() {
    $('.allsub').toggleClass('block');
}

function shownotes3() {
    $('.support').toggleClass('block');
}

function checkword() {
    setTimeout(function(){
        var stack = strip($('.ql-editor').html());
        stack = stack.replace(/[^\wа-яё,./+-]/gi,'').length;
        var min = 4000 - stack;
        if(min < 0) {
            $('#countword').html('0');
            $('#countword').css({'color':'red'});
            return false;
        }
        else {
            $('#countword').css({'color':'rgba(0,0,0,0.7)'});
        }
        $('#countword').html(min);
    },10);
}

function support() {
    var date = $('#supform').serialize();
    $.ajax({
            type: "POST",
            data: date,
            url: 'supportin.php',
            success: function(html) {
                $('.black2').trigger('click'); 
            },
        });
}

function turn(id) {
    $('#namenote'+id).css({'height':'auto'});
    $('#note'+id+' .shows').remove();
}

function slidem() {
    $('.morem').toggleClass('moremslide');
}

$('#diarinput').on('change', function(){
	files = this.files;
});

$('#diarinput').on( 'change', function( event ){

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
		url         : 'submit.php',
		type        : 'POST', // важно!
		data        : data,
		cache       : false,
		dataType    : 'json',
		// отключаем обработку передаваемых данных, пусть передаются как есть
		processData : false,
		// отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
		contentType : false, 
		// функция успешного ответа сервера
		success     : function( respond, status, jqXHR ){

			// ОК - файлы загружены
			if( typeof respond.error === 'undefined' ){
				// выведем пути загруженных файлов в блок '.ajax-reply'
				var files_path = respond.files;
				var html = '';
				$.each( files_path, function( key, val ){
					 html += val;
				} )
                $('.maked').html('<img src="'+html+'" style="animation: show 1s ease;">');
                $('.infoblock').html(html);
                $('.maked').css({'border':'none'});
				
			}
			// ошибка
			else {
				console.log('ОШИБКА: ' + respond.error );
			}
		},
		// функция ошибки ответа сервера
		error: function( jqXHR, status, errorThrown ){
			console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
		}

	});

});

$('.newimg').on('change', function(){
	files = this.files;
});

$('.newimg').on( 'change', function( event ){

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
    var id=$(this).attr('id');
	// добавим переменную для идентификации запроса
	data.append( 'my_file_upload', 1 );

	// AJAX запрос
	$.ajax({
		url         : 'submitnew.php?id='+id,
		type        : 'POST', // важно!
		data        : data,
		cache       : false,
		dataType    : 'json',
		// отключаем обработку передаваемых данных, пусть передаются как есть
		processData : false,
		// отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
		contentType : false, 
		// функция успешного ответа сервера
		success     : function( respond, status, jqXHR ){

			// ОК - файлы загружены
			if( typeof respond.error === 'undefined' ){
				// выведем пути загруженных файлов в блок '.ajax-reply'
				var files_path = respond.files;
				var html = '';
				$.each( files_path, function( key, val ){
					 html += val;
				} );
                $('#box'+id+' .indiar').html('<img src="'+html+'" style="animation: show 1s ease;" width="100%" height="120"><input class="newimg" type="file" id=\''+id+'\'>');
                
			}
			// ошибка
			else {
				console.log('ОШИБКА: ' + respond.error );
			}
		},
		// функция ошибки ответа сервера
		error: function( jqXHR, status, errorThrown ){
			console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
		}

	});

});

$('#photo').on('change', function(){
	files = this.files;
});

$('#photo').on( 'change', function( event ){
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
            url         : 'submitphoto.php',
            type        : 'POST', // важно!
            data        : data,
            cache       : false,
            // отключаем обработку передаваемых данных, пусть передаются как есть
            processData : false,
            // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
            contentType : false, 
            // функция успешного ответа сервера
            success     : function(html){
                    if(html == 'falses') {
                        $('.main').append('<div class="warning" id="warn">Вы можете загрузить не больше 10 фотографий</div>');
                        setTimeout(function(){
                            $('#warn').css({'opacity':'0'});
                            setTimeout(function(){
                                $('#warn').remove();
                            },1000);
                        },1500);
                    }
                
                    else {
                        if(html!='') {
                            $('.allimage').append('<div style="transition:all .5s ease;position:relative;" data-img="'+html+'"><div class="deleditfon" style="height:calc(100% - 5px)"><img src="https://png.icons8.com/windows/120/ffffff/trash.png" class="deleteedit" onclick="delimg(\''+html+'\')"></div><img src="tmp/'+html+'" width="100%"></div>');
                            $('.infoblock2').append(html+'***');
                        }
                    }
            },
            // функция ошибки ответа сервера
            error: function(html){
                console.log( 'ОШИБКА AJAX запроса: ');
            }

        });
        $('#photo').val('');
});

$('#photoedit').on('change', function(){
	files = this.files;
});

$('#photoedit').on( 'change', function( event ){
	if( typeof files == 'undefined' ) return;

	// создадим объект данных формы
	var data = new FormData();

	// заполняем объект данных файлами в подходящем для отправки формате
	$.each( files, function( key, value ){
		data.append( key, value );
	});
    var id = $('#idofnote').html();
	// добавим переменную для идентификации запроса
	data.append( 'my_file_upload', 1 );

	// AJAX запрос
	$.ajax({
		url         : 'submitphotoedit.php?id='+id,
		type        : 'POST', // важно!
		data        : data,
		cache       : false,
		// отключаем обработку передаваемых данных, пусть передаются как есть
		processData : false,
		// отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
		contentType : false, 
		// функция успешного ответа сервера
		success     : function( html ){
                var id = $('#idofnote').html();
                $('.photo').html('<div class="deleditfon"><span class="deleteedit" onclick="deledit(\''+id+'\')"><img src="https://png.icons8.com/trash/win10/100/ffffff"></span><span class="deleteedit deleteedit2" onclick="takeaphotoedit()"><img src="https://png.icons8.com/restart/win10/90/ffffff"></div><span id="idofnote" style="display:none">'+id+'</span><img src="'+html+'" style="animation: show 1s ease;cursor:pointer;" width="100%" onclick="takeaphotoedit()" onclick="delimg(\''+html+'\')"><input type="file" id="photoedit">');
                $('.infoblock2').html(html);
           
            
		},
		// функция ошибки ответа сервера
		error: function( jqXHR, status, errorThrown ){
			console.log( 'ОШИБКА AJAX запроса: ' + status, errorThrown );
		},

	});

});

$('#photo213').on( 'change', function( event ){
    files = this.files;
    event.stopPropagation(); // остановка всех текущих JS событий
	event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега

	// ничего не делаем если files пустой
	if( typeof files == 'undefined' || files=='') return;

	// создадим объект данных формы
	var data = new FormData();

	// заполняем объект данных файлами в подходящем для отправки формате
	$.each( files, function( key, value ){
		data.append( key, value );
	});
    var id = $('#idofnote').html();
    var ideditnote = $('.ideditnote').html();
	// добавим переменную для идентификации запроса
	data.append( 'my_file_upload', 1 );
	// AJAX запрос
	$.ajax({
		url         : 'submitphoto2.php?id='+id+'&noteid='+ideditnote,
		type        : 'POST', // важно!
		data        : data,
		cache       : false,
		// отключаем обработку передаваемых данных, пусть передаются как есть
		processData : false,
		// отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
		contentType : false, 
		// функция успешного ответа сервера
		success     : function( html ){
            if(html == 'falses') {
                    $('.main').append('<div class="warning" id="warn">Вы можете загрузить не больше 10 фотографий</div>');
                    setTimeout(function(){
                        $('#warn').css({'opacity':'0'});
                        setTimeout(function(){
                            $('#warn').remove();
                        },1000);
                    },1500);
            }
             else {   
                 $('.allimage').append('<div style="transition:all .5s ease;position:relative;" data-img="'+html+'"><div class="deleditfon" style="height:calc(100% - 5px)"><img src="https://png.icons8.com/windows/120/ffffff/trash.png" class="deleteedit" onclick="delimg2(\''+html+'\')"></div><img src="noteimage/'+html+'" width="100%"></div>');
            }
		},

	});
    $('#photo213').val('');
});

$('#avatar').on('change', function(){
	files = this.files;
});

$('#avatar').on( 'change', function( event ){

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
		url         : 'avatar.php',
		type        : 'POST', // важно!
		data        : data,
		cache       : false,
		dataType    : 'json',
		// отключаем обработку передаваемых данных, пусть передаются как есть
		processData : false,
		// отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
		contentType : false, 
		// функция успешного ответа сервера
        
        beforeSend: function(){
                $('.avatar').html('<div class="mk-spinner-wrap"><div class="mk-spinner-ring"></div></div>');
        },
		success     : function( respond, status, jqXHR ){

			// ОК - файлы загружены
			if( typeof respond.error === 'undefined' ){
				// выведем пути загруженных файлов в блок '.ajax-reply'
				var files_path = respond.files;
				var html = '';
				$.each( files_path, function( key, val ){
					 html += val;
				} )
                $('.avatar').html('<style>.avatar {background:url(avatar/'+html+'?123123) !important;background-size:cover !important; background-position:center !important;}</style>');
                $('.infoblock3').html(html);
				
			}
			// ошибка
			else {
				console.log('ОШИБКА: ' + respond.error );
			}
		},
		// функция ошибки ответа сервера
		error: function( jqXHR, status, errorThrown ){
			console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
		}

	});

});

$('#filing').on('change', function(){
	files = this.files;
});

$('#filing').on( 'change', function( event ){

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
		url         : 'background.php',
		type        : 'POST', // важно!
		data        : data,
		cache       : false,
		dataType    : 'json',
		// отключаем обработку передаваемых данных, пусть передаются как есть
		processData : false,
		// отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
		contentType : false, 
		success     : function( respond, status, jqXHR ){

			// ОК - файлы загружены
			if( typeof respond.error === 'undefined' ){
				// выведем пути загруженных файлов в блок '.ajax-reply'
				var files_path = respond.files;
				var html = '';
				$.each( files_path, function( key, val ){
					 html += val;
				} )
                $('.background').css({'background':'url(background/'+html+') no-repeat','background-size':'cover','background-position':'center'});
				
			}
			// ошибка
			else {
				console.log('ОШИБКА: ' + respond.error );
			}
		},
		// функция ошибки ответа сервера
		error: function( jqXHR, status, errorThrown ){
			console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
		}

	});

});
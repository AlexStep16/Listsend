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

function menuuser() {
    $('.userbox').toggleClass('userboxshow');
}

function del_spaces(str) {
    str = str.replace(/\s/g, '');
    return str;
}

function check(id) {
    setTimeout(function(){
        var note = $("#formset").serialize();
        $.ajax({
                url: 'check.php?id='+id,
                type: 'POST',
                data: note,
                success: function(html) {
                    if(html == '1') {
                        $('#'+id).css({'border':'1px solid rgba(255, 84, 84, 0.87)'});
                        $('#s'+id).css({'display':'none'});
                    }
                    else if(html == '0') {
                        $('#'+id).css({'border':'1px solid rgba(142, 217, 132, 1)'});
                        $('#s'+id).css({'display':'inline-block'});
                    }
                    else {
                        $('#'+id).css({'border':'1px solid rgba(0,0,0,0.1)'});
                        $('#s'+id).css({'display':'none'});
                    }
                },
        });
    },10);
}

function set(id) {
    setTimeout(function(){
        var note = $("#formset").serialize();
        $.ajax({
                url: 'set.php?id='+id,
                type: 'POST',
                data: note,
                success: function(html) {
                    if(id=='5') {
                        $('#4').css({'border':'1px solid rgba(0,0,0,0.1)'});
                        $('#4').val('');
                        $('#5').val('');
                    }
                    $('#'+id).css({'border':'1px solid rgba(0,0,0,0.1)'});
                    $('#s'+id).css({'display':'none'});
                },
        });
    },10);
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
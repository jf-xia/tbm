/**
 * Created by peng.wu2 on 2016/11/16.
 */
$(document).ready(function(){

    var base_url = $(location).attr('href').split("/").splice(0, 5).join("/") +'/product/';

    $('#editproduct-form').submit(function(e){
        e.preventDefault();
        $.ajax({
                url :base_url + "update",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#editproduct-content').fadeOut('slow', function(){
                    $('#editproduct-content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('修改失败');
            });
    });

    $('#addweb-form').submit(function(e){
        e.preventDefault();
        $.ajax({
                url :base_url + "web/create",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#addweb-content').fadeOut('slow', function(){
                    $('#addweb-content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('新增web信息失败');
            });
    });

    $('#webedit-form').submit(function(e){
        e.preventDefault();
        $.ajax({
                url :base_url + "web/update",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#webedit-content').fadeOut('slow', function(){
                    $('#webedit-content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('修改web信息失败');
            });
    });
    $('#adddb-form').submit(function(e){
        e.preventDefault();
        $.ajax({
                url :base_url + "db/create",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#adddb-content').fadeOut('slow', function(){
                    $('#adddb-content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('修改web信息失败');
            });
    });
    $('#editdb-form').submit(function(e){
        e.preventDefault();
        $.ajax({
                url :base_url + "db/update",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#editdb-content').fadeOut('slow', function(){
                    $('#editdb-content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('修改web信息失败');
            });
    });

    $('#addapp-form').submit(function(e){
        e.preventDefault();
        $.ajax({
                url :base_url + "app/create",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#addapp-content').fadeOut('slow', function(){
                    $('#addapp-content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('修改web信息失败');
            });
    });
    $('#editapp-form').submit(function(e){
        e.preventDefault();
        $.ajax({
                url :base_url + "app/update",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#editapp-content').fadeOut('slow', function(){
                    $('#editapp-content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('修改web信息失败');
            });
    });
})
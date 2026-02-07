$(window).on('load', function() {
    $('#preloader').fadeOut('slow', function() {
        $(this).remove();
    });
});
$(function () {
    var lastSegment = window.location.pathname.split('/').filter(Boolean).pop();
    var id = $('.'+lastSegment).data('id');
    var father = $('.'+lastSegment).data('father');
    var first_father = $('#li-' + father).data('father');
    $('#li-' + first_father).addClass('active');
    $('#li-' + father).addClass('active');
    $('#submenu-' + first_father).addClass('show');
    $('#submenu-' + father).addClass('show');
    $('#li-' + id).addClass('active');
    $('#li-' + father + ' .second-menu').attr('style', 'color: white !important;');
});
$(document).on('submit', '#login-form', function(event) {
    event.preventDefault();
    event.stopPropagation();
    var form = $(this);
    var data = form.serialize();
    var url = baseUrl + 'auth/run/signin';
    var request = main.form_ajax(url, data, 'POST', function(xhr) {
        $('#btn-login').html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`).prop('disabled',true);
    });
    request.done(function(response) {
        if (response.msg) {
            window.location.href = baseUrl + 'component/view/dashboard';
            location.reload();
        }else{
            $('#btn-login').html('Login').prop('disabled',false);
            main.msg('Invalid Username or Password','error');
        }
    });
});
$(document).on('submit', '#register-form', function(event) {
    event.preventDefault();
    event.stopPropagation();
    var form = $(this);
    var data = form.serialize();
    var url = baseUrl + 'auth/run/signup';
    var request = main.form_ajax(url, data, 'POST', function(xhr) {
        //$('#submit').prop('disabled',true);;
    });
    request.done(function(response) {
        if (response.success) {
            main.msg(response.msg,'success','');
            $('#register-form')[0].reset();
        }else{
            if (response.exist) {
                main.msg(response.msg,'error');
            }else{
                main.msg('Error on Submit! Please try again','error');
            }
        }
        $('#submit').prop('disabled',false);
    });
});
function getRunURL(params) {
    return  baseUrl + "component/run/"+myModule+"/" + params;
}



$(document).on('click', '#showTermsAndCon', function() {
    var modal = $("#showTermsAndConModal");
    modal.modal('show');
    
});

$(document).on('click', '#closeTermsCon', function() {
    $("#showTermsAndConModal").modal('hide');
});






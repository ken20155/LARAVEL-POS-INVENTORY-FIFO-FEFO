$(document).ready(function() {
    dataProfile();
    function dataProfile() {
        var data = $.param({});
        var url = getRunURL('viewProfileDetails');
        var request = main.form_ajax(url, data, 'POST', function(xhr) {
           main.block_ui();
        });
        request.done(function(response) {
            $('#html-form').html(response.html);
                    $.unblockUI();

        });
    }
    
    $(document).on('submit', '#submit-form', function(event) {
        event.preventDefault();
        event.stopPropagation();
        var form = $(this)[0];
        var data = new FormData(form);;
        var url = getRunURL('crud-action');
        var request = main.form_ajax(url, data, 'POST', function(xhr) {
            main.block_ui();
        },true);
        request.done(function(response) {
            if (response.success) {
                dataProfile();
                main.msg(response.msg,'success','');
            }else{
                if (response.exist) {
                    main.msg(response.msg,'error');
                }else{
                    main.msg(response.msg,'error');
                }
            }
           
                    $.unblockUI();

        });
    });
});
$(document).on('change', '#upload-btn', function (event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = function (e) {
      $('#uploaded-image').attr('src', e.target.result).addClass('img-fluid rounded-circle p-3').removeClass('d-none');
      $('#original-image').hide();
    }
    reader.readAsDataURL(file);
});

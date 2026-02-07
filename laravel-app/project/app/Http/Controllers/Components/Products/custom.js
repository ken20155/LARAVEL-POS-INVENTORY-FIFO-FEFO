$(document).ready(function() {
    $(document).ready(function() {
        generateMainTable({});
        function generateMainTable(data) {
            var element = '#laravel_datatable';
            var url = getRunURL('list-users');
            var columns = [
                { data: '#', title: '#' },
                { data: 'product_photo', title: 'Image',width:'250px' },
                { data: 'product_name', title: 'Product Name',width:'250px' },
                { data: 'product_desc', title: 'Product Description' },
                { data: 'added_date', title: 'Added Date' },
                { data: 'action', title: 'Action' },
            ];
           main.generateDatatable(element,url,columns,data);
        }
    
    
       $(document).on('change', '#filter_status', function() {
            var data = {
                status:$('#filter_status').val()
            };
            generateMainTable(data);
       });
       
    });
    $(document).on('click', '#addNewAccount', function() {
        var data = $.param({});
        var url = getRunURL('add-new-user');
        var request = main.form_ajax(url, data, 'POST', function(xhr) {
           main.block_ui();
        });
        request.done(function(response) {
            $('#action-text').html(response.action);
            $('#modal-view .modal-body').html(response.body);
            $('#modal-view #footer-custom').html(response.footer);
            $('#modal-view').modal('show');
            $.unblockUI();
        });
    
       
    });
    $(document).on('change', '#productImage', function() {
        let file = event.target.files[0]; // Get the selected file
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $("#imagePreview").attr("src", e.target.result).show(); // Set image source and show it
            };
            reader.readAsDataURL(file);
        } else {
            $("#imagePreview").hide(); // Hide preview if no file is selected
        }
    });
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
                main.msg(response.msg,'success');
                var element = '#laravel_datatable';
                main.reloadDatatableAjax(element);
                $('#modal-view').modal('hide');
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
    $(document).on('click', '#viewAccount', function() {
        var id = $(this).data('id');
        var data = $.param({
            id:id
        });
        var url = getRunURL('viewDataUser');
        var request = main.form_ajax(url, data, 'POST', function(xhr) {
           main.block_ui();
        });
        request.done(function(response) {
            $('#action-text').html(response.action);
            $('#modal-view .modal-body').html(response.body);
            $('#modal-view #footer-custom').html(response.footer);
            $('#modal-view').modal('show');
            $.unblockUI();
        });
    
       
    });
});

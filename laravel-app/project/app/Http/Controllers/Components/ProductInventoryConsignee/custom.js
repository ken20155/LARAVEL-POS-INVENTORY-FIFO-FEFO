$(document).ready(function() {
    $(document).ready(function() {
        generateMainTable({});
        function generateMainTable(data) {
            var element = '#laravel_datatable';
            var url = getRunURL('list-users');
            var columns = [
                { data: '#', title: '#' },
                { data: 'product_photo', title: 'Image',width:'250px' },
                { data: 'product_owner', title: 'Product Owner',width:'250px' },
                { data: 'product_name', title: 'Product Name / Description',width:'250px' },
                { data: 'sold_product', title: 'Sold Stocks' },
                { data: 'dis_stocks', title: 'Stocks' },
                { data: 'return_stock_qty', title: 'Return Qty' },
                { data: 'price', title: 'Base Price' },
                { data: 'consinee_price', title: 'Mark-up Price' },
                { data: 'added_date', title: 'Added Date' },
                // { data: 'update', title: 'Action' },
                { data: 'return', title: 'Return' },
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
    $(document).on('click', '.moveNow', function() {
        var id = $(this).data('id');
        var getPRice = $('#getPrice-' + id).val(); 
        var data = $.param({
            id:id,
            con_price:getPRice,
        });
        
        var title = 'Are you sure you want to move product?';
        main.confirmation(title,function () {
            var url = getRunURL('moveNow');
            var request = main.form_ajax(url, data, 'POST', function(xhr) {
               main.block_ui();
            });
            request.done(function(response) {
                main.msg(response.msg,'success');
                var element = '#laravel_datatable';
                main.reloadDatatableAjax(element);
                $.unblockUI();
            });
        });
    });




});
$(document).on('click', '.returnProduct', function() {
    var id = $(this).data('id');
    var productid = $(this).data('productid');
    var getPRice = $('#getPrice-' + id).val(); 
    var title = 'Are you sure you want to return?';
    main.confirmation(title,function () {
        var all_data = {
            stockid:id,
            productid:productid,
            return_stocks:getPRice,
        };
        remarksReasons(all_data);
    });
});
function remarksReasons(data) {
    var title = 'Please write a reason for return';
    main.remarksMsg(title,data,'afterProcessCancel');
}
function afterProcessCancel(data) {
    if (data.value == '') {
        remarksReasons(data);
    }else{
        var fndata = $.param(data);
        var url = getRunURL('returnProducts');
        var request = main.form_ajax(url, fndata, 'POST', function(xhr) {
           main.block_ui('#div_laravel_datatable');
        });
        request.done(function(response) {
            if (response.success) {
                main.msg(response.msg,'success');
            }else{
                main.msg('Error','error');
            }
            $('#div_laravel_datatable').unblock();
            var element = '#laravel_datatable';
            main.reloadDatatableAjax(element);
        });
    }
}

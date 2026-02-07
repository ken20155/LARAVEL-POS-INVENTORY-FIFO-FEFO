$(document).ready(function() {
    $('body').addClass('sidebar-shrink');
    generateStockProducts(); 
    generateStockProductsSelected(); 
    function generateStockProducts() {
        var form = $('.allSelectedProducts');
        var data = form.serialize();
        var url = getRunURL('generateStockProducts');
        var request = main.form_ajax(url, data, 'POST', function(xhr) {
           main.block_ui();
        });
        request.done(function(response) {
            $('#generateStockProducts').html(response.display_product);
            $.unblockUI();
        });
    }
    function generateStockProductsSelected(loading=true) {
        var data = $.param({});
        var url = getRunURL('generateStockProductsSelected');
        var request = main.form_ajax(url, data, 'POST', function(xhr) {
            if (loading) {
                main.block_ui();
            }
        });
        request.done(function(response) {
            $('#generateStockProductsSelected').html(response.selected_product);
            $.unblockUI();
        });
    }
    $(document).on('click', '.addToCart', function() {
        var stock_id = $(this).data('stockid');
        var product_id = $(this).data('productid');
        var price = $(this).data('price');
        var data = $.param({
            stock_id:stock_id,
            product_id:product_id,
            price:price,
        });
        var url = getRunURL('addToCart');
        var request = main.form_ajax(url, data, 'POST', function(xhr) {
            main.block_ui();
        });
        request.done(function(response) {
            generateStockProductsSelected(); 
            generateStockProducts();
            $.unblockUI();
        });
    
        
    });
    $(document).on('click', '.increaseDecrease', function() {
        var cart_id = $(this).data('cartid');
        var type = $(this).data('type');
        var qty = $(this).data('qty');
        var stocks = $(this).data('stocks');
        var data = $.param({
            cart_id:cart_id,
            type:type,
            qty:qty,
            stocks:stocks,
        });
        var url = getRunURL('increaseDecrease');
        var request = main.form_ajax(url, data, 'POST', function(xhr) {
            //main.block_ui();
        });
        request.done(function(response) {
            generateStockProductsSelected(false); 
            //$.unblockUI();
        });
    });
    $(document).on('click', '.deleteSingleCart', function() {
        var cart_id = $(this).data('cartid');
        var title = 'Are you sure you want to delete?';
        main.confirmation(title,function () {
            var url = getRunURL('deleteSingleCart');
            var data = $.param({
                cart_id:cart_id,
            });
            var request = main.form_ajax(url, data, 'POST', function(xhr) {
                //main.block_ui();
            });
            request.done(function(response) {
                generateStockProductsSelected(false); 
                generateStockProducts();
            });
    
        });
    });
    $(document).on('click', '.resetNow', function() {


        var title = 'Are you sure you want to reset?';
        main.confirmation(title,function () {
            var url = getRunURL('resetNow');
            var data = $.param({});
            var request = main.form_ajax(url, data, 'POST', function(xhr) {
                //main.block_ui();
            });
            request.done(function(response) {
                generateStockProductsSelected(false); 
                generateStockProducts();
            });
    
        });

    });
    $(document).on('click', '.distributeNow', function() {


        var title = 'Are you sure you want to distribute all items?';
        main.confirmation(title,function () {
            var url = getRunURL('distributeNow');
            var data = $.param({});
            var request = main.form_ajax(url, data, 'POST', function(xhr) {
                //main.block_ui();
            });
            request.done(function(response) {
                generateStockProductsSelected(false); 
                generateStockProducts();
            });
    
        });

    });
    //old
    generateMainTable({});
    function generateMainTable(data) {
        var element = '#laravel_datatable';
        var url = getRunURL('list-users');
        var columns = [
            { data: '#', title: '#' },
            { data: 'product_photo', title: 'Image',width:'250px' },
            { data: 'product_name', title: 'Product Name',width:'250px' },
            { data: 'product_desc', title: 'Product Description' },
            { data: 'total_stocks', title: 'Total Stocks' },
            { data: 'remaining_stocks', title: 'Remaning Stocks' },
            { data: 'notify_stocks', title: 'Notify Stocks' },
            { data: 'price', title: 'Price' },
            { data: 'status', title: 'Status' },
            // { data: 'status', title: 'Status' },
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

    $(document).on('keyup', '#search_product_input', function() {
        generateStockProducts();
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
    $(document).on('change', '.input-pos-qty', function() {
        var cart_id = $(this).data('cartid');
        var qty = $(this).val();
        var stocks = $(this).data('stocks');
        var data = $.param({
            cart_id:cart_id,
            qty:qty,
            stocks:stocks,
        });
        var url = getRunURL('increaseDecreaseInput');
        var request = main.form_ajax(url, data, 'POST', function(xhr) {
            //main.block_ui();
        });
        request.done(function(response) {
            generateStockProductsSelected(false); 
            //$.unblockUI();
        });
    });
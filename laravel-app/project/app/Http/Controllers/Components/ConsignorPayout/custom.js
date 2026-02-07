$(document).ready(function() {
    $(document).ready(function() {
        generateMainTable({
            status:'PENDING' // Default to PENDING
        });
        function generateMainTable(data) {
            var element = '#laravel_datatable';
            var url = getRunURL('list-users');
            if (data.status == 'PAID') {
                var con_status = 'Amount Paid';
            }else{
                var con_status = 'Amount to Pay';
            }
            var columns = [
                { data: '#', title: '#' },
                { data: 'full_name', title: 'Full name',width:'250px' },
                //{ data: 'balance', title: 'Balance',width:'250px' },
                { data: 'amount_to_pay', title: con_status },
                { data: 'last_date_payout', title: 'Last Date Payout',width:'250px' },
                { data: 'status', title: 'Status',width:'250px' },
                { data: 'action', title: 'Action',width:'250px' },
            ];
           main.generateDatatable(element,url,columns,data);
        }


       $(document).on('click', '.status-tab-change', function() {
            var data = {
                status:$(this).data('status')
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
        var status = $(this).data('status');
        var data = $.param({
            status:status,
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

$(document).on('keyup', '#input_amount', function() {
    var amount_to_pay = parseFloat($('#amount_to_pay').val() || 0); // Ensure number
    var balance_amount_con = parseFloat($('#balance_amount_con').val() || 0); // Existing balance
    var input_amount = parseFloat($(this).val() || 0); // Amount being input

    // Calculate the new balance. If input_amount exceeds amount_to_pay,
    // the balance should be 0. Otherwise, it's amount_to_pay - input_amount.
    var output_balance = amount_to_pay - input_amount;

    // Ensure the balance doesn't go below zero.
    if (output_balance < 0) {
        output_balance = 0;
        $(this).val(amount_to_pay); // Cap input at amount to pay if it exceeds
    }

    $('#balance_amount').val(output_balance.toFixed(2)); // Display with 2 decimal places
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
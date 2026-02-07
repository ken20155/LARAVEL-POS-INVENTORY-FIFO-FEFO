$(document).ready(function() {
    // Nested document.ready is redundant, remove the outer one if it exists from previous code.
    // This is the correct outer document.ready
    generateMainTable({});

    function generateMainTable(data) {
        var element = '#laravel_datatable';
        var url = getRunURL('list-users');
        var columns = [
            { data: '#', title: '#' },
            { data: 'product_photo', title: 'Image', width: '250px' },
            { data: 'product_owner', title: 'Product Owner', width: '250px' },
            { data: 'product_name', title: 'Product Name / Description', width: '250px' },
            { data: 'dis_stocks', title: 'Received Stocks' },
            { data: 'price', title: 'Base Price' },
            { data: 'markup_amount', title: 'Markup Amount (₱)' }, // Changed title to reflect whole number amount
            { data: 'consumer_price', title: 'Markup Price' }, // New column for Consumer Price display
            { data: 'move', title: 'Action' },
            //{ data: 'return', title: 'Return' },
        ];
        main.generateDatatable(element, url, columns, data);
    }

    // Event listener for filter status
    $(document).on('change', '#filter_status', function() {
        var data = {
            status: $('#filter_status').val()
        };
        generateMainTable(data);
    });

    // === MODIFIED JAVASCRIPT FOR MARKUP CALCULATION ===
    // Listen for changes on any input with the class 'markup-input'
    $(document).on('input', '.markup-input', function() {
        const stockId = $(this).attr('id').split('-')[1]; // Extract stock_id from the input's ID
        const basePrice = parseFloat($(this).data('base-price')); // Get the base price from data attribute
        let markupAmount = parseFloat($(this).val()); // Get the entered markup amount (whole number)

        // Ensure markupAmount is a valid number, default to 0 if not
        if (isNaN(markupAmount)) {
            markupAmount = 0;
            $(this).val(0); // Optionally reset the input to 0 if invalid
        }
        
        if (!isNaN(basePrice)) {
            // Calculate the consumer price by ADDING the markup amount directly
            const consumerPrice = basePrice + markupAmount;
            
            // Update the consumer price span
            $('#consumer-price-' + stockId).text('₱' + consumerPrice.toFixed(2));
        } else {
            // Handle cases where basePrice might be invalid (though unlikely with your PHP)
            $('#consumer-price-' + stockId).text('Error');
        }
    });
    // === END MODIFIED JAVASCRIPT ===


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
            reader.onload = function(e) {
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
        var data = new FormData(form);
        var url = getRunURL('crud-action');
        var request = main.form_ajax(url, data, 'POST', function(xhr) {
            main.block_ui();
        }, true);
        request.done(function(response) {
            if (response.success) {
                main.msg(response.msg, 'success');
                var element = '#laravel_datatable';
                main.reloadDatatableAjax(element);
                $('#modal-view').modal('hide');
            } else {
                if (response.exist) {
                    main.msg(response.msg, 'error');
                } else {
                    main.msg(response.msg, 'error');
                }
            }
            $.unblockUI();
        });
    });

    $(document).on('click', '#viewAccount', function() {
        var id = $(this).data('id');
        var data = $.param({
            id: id
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
        var baseprice = parseFloat($(this).data('baseprice'));
        // Get the value from the markup amount input field
        let markupAmount = parseFloat($('#markup-' + id).val()); // Renamed variable

        // Ensure markupAmount is a valid number, default to 0 for calculation
        if (isNaN(markupAmount)) {
            markupAmount = 0;
        }

        // Calculate the consumer price by ADDING the markup amount directly
        const calculatedConsumerPrice = baseprice + markupAmount; // Changed calculation

        // Validation: Consumer price must be greater than or equal to base price
        if (calculatedConsumerPrice < baseprice) {
             main.msg('Calculated consumer price cannot be less than the base price after markup. Please enter a non-negative markup amount.', 'error');
             return; // Stop the function execution
        }

        var data = $.param({
            id: id,
            con_price: calculatedConsumerPrice, // Send the calculated consumer price
        });

        var title = 'Are you sure you want to move the product to inventory?';
        main.confirmation(title, function() {
            var url = getRunURL('moveNow');
            var request = main.form_ajax(url, data, 'POST', function(xhr) {
                main.block_ui();
            });
            request.done(function(response) {
                main.msg(response.msg, 'success');
                var element = '#laravel_datatable';
                main.reloadDatatableAjax(element);
                $.unblockUI();
            });
        });
    });
});
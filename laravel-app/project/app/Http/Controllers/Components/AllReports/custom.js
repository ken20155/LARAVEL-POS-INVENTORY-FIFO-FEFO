$(document).ready(function() {
    let chart = null;
    allReports()
    function allReports() {
        // Destroy the existing chart if it exists
        if (chart) {
            chart.destroy();
        }
        var data = $('.data-filter').serialize();
        var url = getRunURL('allReports');
        var request = main.form_ajax(url, data, 'POST', function(xhr) {
           main.block_ui('#blockreportui');
        });
        request.done(function(response) {
      
            $('#displayReport').html(response.html);
            $('#blockreportui').unblock();

        });


    }
    // Initial call to generate the chart
    $(document).on('change', '#select-reports', function() {
        allReports();

    });
    $(document).on('change', '.date-filter', function() {
        allReports();
    });

    $(document).on('click', '#button-print', function() {
        var report_select = $('#select-reports').val();
        if(report_select !== null){
            var content = $('#displayReport').html();
            main.printDirect(content);
        }else{
             main.msg('Please Select Report','error');
        }
    });
    $(document).on('click', '#button-reset', function() {
        $('.date-filter').val('');
        $('#select-reports').val('fn=inventoryReport,title=INVENTORY').trigger('change');
        allReports();
    });
    $(document).on('keyup', '#myInputSearch', function() {
        myFunctionSearch();
    });
    $(document).on('keyup', '#myInputSearchConsignor', function() {
        allReports();
    });
    function myFunctionSearch() {
        var $input = $('#myInputSearch');
        var $table = $('.table-bordered');
    
        if ($input.length === 0 || $table.length === 0) return;

        var filter = $input.val().toUpperCase();
    
        $table.find('tbody tr').each(function() { // Only loop tbody rows
            var $th = $(this).find('th').eq(0);  // Product Name
            var $td = $(this).find('td').eq(1);  // Consignor Name
        


            var txtValueTh = $th.text().toUpperCase();
            var txtValueTd = $td.text().toUpperCase();
    
            if (txtValueTd.indexOf(filter) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
    function myFunctionSearch2() {
        var $input = $('#myInputSearch');
        var $table = $('.table-bordered');
    
        if ($input.length === 0 || $table.length === 0) return;

        var filter = $input.val().toUpperCase();
    
        $table.find('tbody tr').each(function() { // Only loop tbody rows
            //var $th = $(this).find('th').eq(0);  // Product Name
            var $td = $(this).find('td').eq(1);  // Consignor Name
        


            var txtValueTh = $th.text().toUpperCase();
            var txtValueTd = $td.text().toUpperCase();
    
            if (txtValueTh.indexOf(filter) > -1 || txtValueTd.indexOf(filter) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
});

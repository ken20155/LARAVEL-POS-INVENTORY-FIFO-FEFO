var main = {
    form_ajax: function (url , data, type , beforeSend = function () {}, form = false) {
        if (form) {
            return $.ajax(
                {
                    url: url,
                    type: type,
                    data: data,
                    dataType: "json",
                    processData: false,
                    cache: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: beforeSend,
                    error: function(xhr, status, error) {
                        main.msg('System Error','error');
                        $.unblockUI();
                        $('#div_laravel_datatable').unblock();
                    }
                }
            );
        }else{
            return $.ajax(
                    {
                        url: url,
                        type: type,
                        data: data,
                        dataType: "json",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        beforeSend: beforeSend,
                        error: function(xhr, status, error) {
                            main.msg('System Error','error');
                            $.unblockUI();
                            $('#div_laravel_datatable').unblock();
                        }
                    }
                );
        }
    },
    msg: function (msg,icon='',msg2='') {
        swal(msg,msg2, {
            icon: icon,
            buttons: {
              confirm: {
                className: "btn btn-primary",
              },
            },
          });
    },
    confirmation: function (title,afterProcess = function () {}) {
        swal({
            title: title,
            type: "warning",
            buttons: {
              confirm: {
                text: "Yes",
                className: "btn btn-success",
              },
              cancel: {
                visible: true,
                className: "btn btn-danger",
              },
            },
          }).then((Delete) => {
            if (Delete) {
                afterProcess();
            } else {
              swal.close();
            }
          });
    },
    block_ui:function (element=''){
        if (element == '') {
            $.blockUI({
                message: `<div class="spinner-border text-light" role="status"></div><div>Loading...</div>`,
                css: {
                    border: 'none',
                    padding: '10px',
                    backgroundColor: '#1b00ff',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .7,
                    color: '#fff'
                }
            });
            // $.unblockUI();
        }else{
            $(element).block({
                message: `
                            <div class="spinner-border text-light" role="status"></div>
                            <div>Loading...</div>
                            `,
                css: {
                    border: 'none',
                    padding: '10px',
                    backgroundColor: '#1b00ff',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .7,
                    color: '#fff'
                }
            });
            //$('#blockArea').unblock();
        }
    },
    generateDatatable: function (element,url,columns,data={}) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if ($.fn.DataTable.isDataTable(element)) {
            $(element).DataTable().destroy();
        }
        $(element).DataTable({
            serverSide: true,
            ajax: {
                url: url,
                type:'POST',
                beforeSend: function() {
                    main.block_ui(element+'_wrapper');
                },
                complete: function() {
                    $(element+'_wrapper').unblock();
                    if (typeof dataTableComplete == 'function') {
                        dataTableComplete(cls,row,data);
                    }
                },
                data:data
            },
            columns: columns,
            //scrollX: true
        });

        // $('body').block({
        //     message: '<div class="spinner-border text-primary"></div><h1 class="blockui blockui-title">Please Wait...</h1>'
        // });
  
    },
    reloadDatatableAjax: function (element){
        var table = $(element).DataTable();
        table.ajax.reload();
    },
    notify: function (msg='Success',icon='check'){
        //http://localhost/clients/2024/templates/kaiadmin-lite-1.0.0/components/simple-line-icons.html
        switch (icon) {
            case 'check':
                var type = 'success';
                break;
            case 'close':
                var type = 'danger';
                break;
            default:
                var type = 'secondary';
                break;
        }
        $.notify({
            icon: 'icon-' + icon,
            // title: 'Kaiadmin',
            message: '<h6 style="color:black !important;">'+msg+'</h6>',
        },{
            type: type,
            placement: {
                from: "bottom",
                align: "right"
            },
            time: 1000,
        });
    },
    remarksMsg: function (msg,data,fn){
        swal({
            text: msg,
            content: "input",
            buttons: true, 
            closeOnClickOutside: false,
        })
        .then((value) => {
            if (value !== null) {
                if (typeof window[fn] == 'function') {
                    var data_value = {
                        value: value
                    };
                    var merged_data = $.extend({}, data, data_value);
                    window[fn](merged_data);
                }
            }
        });
    },
    printDirect: function (content,css='', print_style = 0) { 
        if (print_style == 1) {
            var printWindow = window.open('', '_blank');
        }else{
            var printWindow = window.open("", "Print", `width=${screen.width},height=${screen.height}`);
        }
        var printContent = content;
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Print Preview</title>');
        printWindow.document.write(`
        <link rel="stylesheet" media="print" href="${baseUrl}public/plugins/vendors/styles/core.css" />
        <link rel="stylesheet" media="print" href="${baseUrl}public/plugins/vendors/styles/icon-font.min.css" />
        `);
        printWindow.document.write(`</head><style>` + css + `</style><body class="">` + printContent + `</body></html>`);
        //printWindow.document.close();
        printWindow.focus();
        setTimeout(function() {
            printWindow.print();
            printWindow.close();
        }, 1000);
    },
    
}

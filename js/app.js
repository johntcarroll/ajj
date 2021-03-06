$(document).ready(function(){
    unlock_screen();
    load_sheet_data();
    $("#db-load").click(load_from_db);
    $("#db-save").click(save_to_db);
    $("#db-verify").click(verify_data);
    $("#remove-rows").click(remove_rows);
});

function load_sheet_data(){
    var ad = {
        class: 'Stat',
        fn: 'load_sheet_data'
    }
    exec_request(ad, init_sheet);
}

function init_sheet(json){
    var sheet_container = $("#spreadsheet");
    var sheet_options = {
        data: [],
        startRows: 10,
        columns: json,
        rowHeaders: true,
        colHeaders: ["Ticker", "Date", "Close", "Web", "DB Status"],
        minSpareRows: 5,
        contextMenu: true,
        outsideClickDeselects: false,
        afterChange: function(changes, source) {
            // TODO add code for changing status column
        },
        stretchH: 'all'
    };

    spreadsheet = new Handsontable(sheet_container[0], sheet_options);
}

function load_from_db(){
    var ad = {
        filters: $('.filter').serializeArray(),
        class: 'Stat',
        fn: 'load_rows'
    }
    exec_request(ad, handle_success);
}

function save_to_db(){
    var ad = {
        rows: spreadsheet.getData(),
        class: 'Stat',
        fn: 'save_rows'
    }
    exec_request(ad, handle_success);
}

function verify_data(){
    var ad = {
        rows: spreadsheet.getData(),
        class: 'Stat',
        fn: 'verify_rows'
    }
    exec_request(ad, handle_success);
}

function remove_rows(){
    spreadsheet.updateSettings({data:[]});
}

function handle_success(json){
    remove_rows();
    spreadsheet.loadData(json);
}

function handle_ajax_error(){
    alert('AJAX ERROR.');
}

function exec_request(data, success_callback, error_callback = handle_ajax_error){
    $.ajax({
        url: "/ajj/controller/rh.php",
        data: data,
        method: "post",
        dataType: "json",
        beforeStart: lock_screen,
        complete: unlock_screen,
        success: success_callback,
        error: error_callback
    });
}

function unlock_screen(){
    $("#loader").addClass('d-none');
}

function lock_screen(){
    $("#loader").removeClass('d-none');
}

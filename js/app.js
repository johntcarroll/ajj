$(document).ready(function(){
    load_sheet_data();
    $("#db-load").click(load_from_db);
    $("#db-save").click(save_to_db);
    $("#db-verify").click(verify_data);
    $("#remove-rows").click(remove_rows);
});

$(document).ajaxStart(function(){
  lock_screen();
});
$(document).ajaxStop(function(){
  unlock_screen();
});

function load_sheet_data(){
    var ad = {
        class: 'Stat',
        fn: 'get_sheet_columns'
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
        }
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
        data: , // TODO get sheet data
        class: 'Stat',
        fn: 'save_rows'
    }
    exec_request(ad, handle_success);
}

function verify_data(){
    var ad = {
        data: , // TODO get sheet data
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

function exec_request(data, success_callback, error_callback = handle_ajax_error){
    $.ajax({
        url: "/ajj/controller/rh.php",
        data: data,
        method: "post",
        dataType: "json",
        success: success_callback,
        error: error_callback
    });
}

function lock_screen(){
    $("#loader").removeClass('hidden');
}

function unlock_screen(){
    $("#loader").addClass('hidden');
}

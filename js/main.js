function dialogin(pesan) {
//      fungsi untuk menampilkan popup Confirmasi
//      argumen untuk menampilkan text pesan
    var closeBtn = $('<a href="#" data-rel="back" class="ui-btn-right ui-btn ui-btn-b ui-corner-all ui-btn-icon-notext ui-icon-delete ui-shadow">Close</a>');

    // text you get from Ajax
    var content = "<p>" + pesan + "</p>";

    // Popup body - set width is optional - append button and Ajax msg
    var popup = $("<div/>", {
        "data-role": "popup",
        "id": "dialogy"
    }).css({
        width: $(window).width() / 1.5 + "px",
        padding: 5 + "px"
    }).append(closeBtn).append(content);

    // Append it to active page
    $.mobile.pageContainer.append(popup);

    // Create it and add listener to delete it once it's closed
    // open it
    $("#dialogy").popup({
        dismissible: false,
        history: false,
        theme: "b",
        /* or a */
        positionTo: "window",
        overlayTheme: "b",
        /* "b" is recommended for overlay */
        transition: "pop",
        beforeposition: function () {
            $.mobile.pageContainer.pagecontainer("getActivePage")
                    .addClass("blur-filter");
        },
        afterclose: function () {
            $(this).remove();
            $(".blur-filter").removeClass("blur-filter");
        },
        afteropen: function () {
            /* do something */
            //window.location = "index.php";
        }
    }).popup("open");
}

function customAjax(u, d, callback) {
    $.ajax({
        type: "post",
        url: u,
        data: d,
        async: true,
        dataType: 'json',
        beforeSend: function () {
            // menampilkan loading spiner sebelum data dikirim
            $.mobile.loading("show", {text: "Mohon tunggu", textVisible: true});
        },
        success: function (result) {
            $.mobile.loading("hide");
            // status = true    => muncul popup
            // status = false   => ga muncul popup
            // status = 3       => refresh capcay
            if (result.status == 1) {
                // kalo status nya true
                if (result.pesan != null) {
                    // jika pesannya tidak kosong isinya maka tampil alert
                    dialogin(result.pesan);
                }

                if (typeof callback == 'function') {
                    callback(result.data);
                }
            } else {
                dialogin(result.pesan);
                if (result.status == 3) {
                    //reset capcay kalo status 3
                    grecaptcha.reset();
                }
            }
        },
        error: function (request, error) {
            // This callback function will trigger on unsuccessful action                
            dialogin('Network bermasalah, silahkan coba lagi!');
            $.mobile.loading("hide");
            //grecaptcha.reset(); //reset capcay
            console.log(error);
            console.log(request);

        }
    });
}

function simpleAjax(u, d){
    $.ajax({
        type: "post",
        url: u,
        data: d,
        async: true,
        dataType: 'json',
        success: function (result) {
            if (result.status == true) {
                console.log(result.status+" berhasil");
            } else {
                alert(result.pesan);
            }
        },
        error: function (request, error) {
            // This callback function will trigger on unsuccessful action                
            dialogin('Network bermasalah, silahkan coba lagi!');
            //grecaptcha.reset(); //reset capcay
            console.log(error);
            console.log(request);

        }
    });
}
$(document).on("swipeleft", "#home", function (e) {
// We check if there is no open panel on the page because otherwise
// a swipe to close the left panel would also open the right panel (and v.v.).
// We do this by checking the data that the framework stores on the page element (panel: open).
    if ($(".ui-page-active").jqmData("panel") !== "open") {
        if (e.type === "swipeleft") {
            $("#menuPanel").panel("open");
        }
    }
});

function func_notif_readed()
{
    // Ambil id notif
    var notif_id = "&notif_id="+$.map($('#home .notifikasiList'), function (el) {
        return $(el).data('value')
    });
    //alert("Proses update notif untuk "+notif_id);
    simpleAjax(URLSITUS+'api/notifreaded/', notif_id);

}

$("#notifikasi").on("collapsibleexpand", function () {
    console.log("notifikasi read");
    func_notif_readed();
});

function func_go_tanya(){
    if ($('#btn_tanya').length){
        $('#Ttanya').focus().select();
    }else{
        dialogin("Kolom pertanyaan di non-aktifkan oleh pembuat trip");
    }
}

function func_addme() 
{
    // Proses menambahkan user ke dalam trip
    $("#ijinJoin" ).popup( "close" );
    //Disable button yg di klik
    $("#btn_gabung").addClass('ui-state-disabled');
    //console.log("Proses Adding");
    simpleAjax(URLSITUS+'api/tripaddme/', null);
}

function func_eraseme()
{
    // Proses cancel ijin join dari Trip
    $("#batalJoin" ).popup( "close" );
    console.log("Proses func_eraseme");
    simpleAjax(URLSITUS+'api/triperaseme/', null);
    location.reload();
}

function func_leaveme()
{
    // Proses keluar dari rencana Trip
    $("#batalJoin" ).popup( "close" );
    simpleAjax(URLSITUS+'api/tripleaveme/', null);
}
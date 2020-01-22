$(document).ready(function () {

    var idioma = {
        "sProcessing": "Procesando...",
        "sZeroRecords": "No hay documentos disponibles.",
        "sEmptyTable": "No hay documentos disponibles.",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sSearch": "Buscar:",
        "paginate": {
            "first": "Primera",
            "last": "Ultima",
            "next": "Siguiente",
            "previous": "Anterior"
        },
    };

    function createDataTable() {
        var oTable = $('.main-table').DataTable({
            "paging": true,
            "pageLength": 10,
            "lengthChange": false,
            "fixedHeader": true,
            'searching': true,
            "language": idioma,
            "processing": true,
            "scrollX": true,
            'info': false,
            'ordering': true,
            "order": [[0, "asc"]],
            'responsive': true,
        })
        var url2 = window.location.href;
        if (url2.indexOf("#") >= 1) {
            var mod2 = url2.substr(url2.indexOf("#") + 1, url2.length);
            $("#searcher").val(mod2);
        }
        oTable.search($('#searcher').val()).draw();
        $('#searcher').keyup(function () {
            oTable.search($(this).val()).draw();
        })

    };

    $(document).on("click", ".nav-link", function () {
        $(document).find("#modulos_id").val($(this).data("id"));
    })

    $(document).on("click", ".new-doc-container-trigger", function () {
        $(document).find(".card-body").addClass("hidden");
        $(document).find(".createDocument-section").removeClass("hidden");
        $("#newDocument")[0].reset();
    })

    $(document).on("click", ".index-doc-container-trigger", function () {
        $(document).find(".card-body").addClass("hidden");
        $(document).find(".indexDocument-section").removeClass("hidden");

    })

    $('#table tbody').empty();

    function addItem(bitacora) {

        var badgecolor = "";
        var _idBitacora = bitacora.id;

        if (bitacora.is_admin == 0) {
            badgecolor = '<span class="label label-primary"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>';
        }
        else {
            badgecolor = '<span class="label label-danger"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>';
        }

        var table = "";
        table += '<tr id="id_' + _idBitacora + '" data-id="' + _idBitacora + '">';
        table += '<td data-label="user_name" class="item_user_name">' + bitacora.updated_at + '</span></td>';
        table += '<td data-label="user_name" class="item_user_name">' + badgecolor + '' + " " + bitacora.name + '</span></td>';
        table += '<td data-label="email" class="item_email">' + bitacora.actions + '' + '</td>';
        table += '<td data-label="documentos_publicados" class="item_documentos_publicados" >' + bitacora.model + '</span></td>';
        table += '<td data-label="documentos_publicados" class="item_documentos_publicados" >' + bitacora.description + '</span></td>';

        table += '</tr>';
        table = $(table);
        $('.main-tbody-table').append(table);
        // tableScrollBottom();
    }

    listdata();

    function listdata() {

        var _listdata = _request.listdata({ url: $('#_urldoc').val() });

        loadingProgresiveRing(true);

        $.when(_listdata)
            .done(function (data) {

                $.each(data, function (key, bitacora) {
                    addItem(bitacora);
                });

                createDataTable();

            })
            .always(function () { loadingProgresiveRing(false); })

    }

})

var _request = {

    listdata: function (_data) {

        return $.ajax({
            url: _data.url,
            type: "GET",
            dataType: "json"
        })

    }

}

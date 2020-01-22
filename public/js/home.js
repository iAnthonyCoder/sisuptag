$(document).ready(function () {

    var idioma = {
        "sProcessing": "Procesando...",
        "sZeroRecords": "",
        "sEmptyTable": "",
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
        $('#searcher').keyup(function () {
            oTable.search($(this).val()).draw();
        })
    };

    var url = window.location.href;

    if (url.substr(url.length - 2, 1) == "#") {
        var mod = url.substr(url.length - 1, 1);
        listdata(mod);
    }
    else {

        var _indexGetFirst = _request.indexGetFirst({ url: $('#_url').val() + "/indexGetFirst" });

        $(".nav").addClass("noclick");
        loadingProgresiveRing(true);

        $.when(_indexGetFirst)
            .done(function (data) {

                if (data.length != 0) {

                    $(document).find("#newDocument #modulos_id").val(data[0].modulos_id);
                    $.each(data, function (key, document) {
                        addItem(document);
                    });
                    createDataTable();
                }

            })
            .always(function () {
                loadingProgresiveRing(false);
                $(".nav").removeClass("noclick");
            })

    }

    function listdata(id) {

        var _listdata = _request.listdata({ url: $('#_urldoc').val() + id });

        $(".nav").addClass("noclick");
        loadingProgresiveRing(true);

        $.when(_listdata)
            .done(function (data) {

                $.each(data, function (key, document) {
                    addItem(document);
                });
                createDataTable();

            }).always(function () {
                $(".nav").removeClass("noclick");
                loadingProgresiveRing(false);
            })

    }

    $('#table tbody').empty();

    function addItem(document) {
        var table = "";
        table += '<tr id="id_' + document.id + '" data-id="' + document.id + '">';

        table += '<td class="item_codigo" data-label="codigo" class="">' + document.codigo + '</td>';
        table += '<td class="item_tipo" data-label="tipo" >' + document.tipo + '</td>';
        table += '<td data-label="fecha"  class="item_fecha">' + document.fecha + '</td>';
        table += '<td data-label="description" class="item_descripcion">' + document.description + '</td>';
        table += '<td data-label="actions"  class=""><div class="btn-group pull-left" role="group" aria-label="..."><button type="button" onclick="window.open(\'pdf/' + document.dirlocal + '\',\'_blank\'); return false;" class="btn btn-default item_doc" title="Mostrar" ><span class="glyphicon glyphicon-file" aria-hidden="true"></span><button type="button" class="btn btn-default edit-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger delete-item" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div></td>';
        table += '</tr>';
        table = $(table);
        $('.main-tbody-table').append(table);
        // tableScrollBottom();
    }

    $(document).on("click", ".nav-link", function (e) {

        $(".nav-link").parent().removeClass("active");
        $(this).parent().addClass("active");
        $(".main-table").DataTable().clear().destroy();
        listdata($(this).data("id"));
        $(document).find(".controller-section").addClass("hidden");
        $(document).find(".indexDocument-section").removeClass("hidden");

    })

})

var _request = {

    indexGetFirst: function (_data) {

        return $.ajax({
            url: _data.url,
            type: "GET",
            dataType: "json"
        })

    },

    listdata: function (_data) {

        return $.ajax({
            url: _data.url,
            type: "GET",
            dataType: "json"
        })

    }

}

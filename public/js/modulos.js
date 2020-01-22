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



        var oTable = $('.main-table').DataTable({
            "paging": true,
            "pageLength": 10,
            "lengthChange": false,
            "fixedHeader": true,
            'searching': true,
            "language": idioma,
            "processing": true,
            "scrollX": false,
            "scrollY": false,
            'info': false,
            'ordering': true,
            "order": [[0, "asc"]],
            'responsive': true,

        })

        oTable.search($('#searcher').val()).draw();
        $('#searcher').keyup(function () {
            oTable.search($(this).val()).draw();
        })



























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

    listdata();

    $(document).on("click", ".edit-item", function (e) {
        var item = $(this).parent().parent().parent();
        var id = item.attr("id");
        id=id.substr(id.indexOf("_")+1, id.length-3);
        $("#editDocument")[0].reset();
        editDocument(id, item);

    })

    $(document).on("click", ".control-button", function (e) {
        $(this).parents().find(".control-button").removeClass("active");
        $(this).addClass("active");
        $(".edit-doc-container-trigger").addClass("disabled");
    })







function listdata() {

    loadingProgresiveRing(true);

    $.when(_request.listdata({ url: $('#_urldoc').val() + "/" }))
        .done(function (data) {
            $('#table-tbody > tr').remove();
            $.each(data, function (key, modulo) {
                addItem(modulo);

            })
            //createDataTable();
        }).always(function () { oTable.columns.adjust().draw();loadingProgresiveRing(false); });

}



// Btn Acciones

// Btn Agregar

function addItem(modulo) {

    if (modulo.documentos_publicados_m == null) {
        modulo.documentos_publicados_m = 0;
    }



    var table = [
    '<td class="t-trigger class="item_id" data-label="id" >' + modulo.id + '</td>',
    '<td data-label="description" class="item_name">' + modulo.nombre + '</td>',
    '<td data-label="description" class="item_description">' + modulo.descripcion + '</td>',
    '<td data-label="documentos_publicados_m" class="item_documentos_publicados_m"><a id="numberdocs" href="documentos#' + modulo.id + '">' + modulo.documentos_publicados_m + '</a></td>',
   '<td data-label="actions"  class=""><div class="btn-group pull-left" role="group" aria-label="..."><button type="button" class="btn btn-default edit-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger delete-item " data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div></td>',
    ];
    //$('.main-tbody-table').append(table);
    // tableScrollBottom();



    oTable.row.add( table ).node().id = 'id_'+modulo.id+'';

    oTable.draw( false );




}

// Btn Editar
function editDocument(id, item) {


    var _limitHeaders = 4; // este es la cantidad de input ckecked que se mostrara en la el campo headers

    loadingProgresiveRing(true);

    $.when(_request.getModuloId({ url: $('#editDocument #_url').val() + "/" + id }))
        .done(function (response) {

            $(document).find(".card-body").addClass("hidden");
            $(document).find(".editDocument-section").removeClass("hidden");

            $(".edit-doc-container-trigger").removeClass("disabled");
            $(".control-button").removeClass("active");
            $(".edit-doc-container-trigger").addClass("active");


            $('#editDocument #row_id').val(item.attr('id')); // guardo el id (table id) del item que estoy editando para luego modificarlo
            $('#editDocument #edit_id').val(response.modulo.id); // id (item o product id) para enviarlo en el formulario

            $('#editDocument #name').val(response.modulo.nombre); //  name (item o product)
            $('#editDocument #description').val(response.modulo.descripcion); //  name (item o product)

            for (var i = 1; i <= _limitHeaders; i++) {
                $('#editDocument #row' + i + ' ').prop("checked", response.modulo['row' + i]); //  name (item o product)
            }

        }).always(function () { loadingProgresiveRing(false); });

    return false;
}

// Btn Eliminar

$(document).on("click", ".delete-item", function (e) {
    var item = $(this).parent().parent().parent();
    var id = item.attr("id");
    id=id.substr(id.indexOf("_")+1, id.length-3);
    removeDocument(item, id);
})


// CRUD
// Agregar

$('#newDocument').submit(function (e) {
    e.preventDefault();

    var submit_button = $(this).find('.submit_button');
    var $btn = submit_button.button('loading')

    var _postModulo = _request.postModulo(
        {
            url: $('#newDocument #_url').val(),
            data: $('#newDocument').serialize()
        });

    loadingProgresiveRing(true);

    $.when(_postModulo)
        .done(function (response) {

            if (response.success) {
                addItem(response.modulo);
                $("#newDocument")[0].reset();
                $(document).find(".card-body").addClass("hidden");
                $(document).find(".indexDocument-section").removeClass("hidden");
                $(".edit-doc-container-trigger").addClass("disabled");
                $(".control-button").removeClass("active");
                $(".index-doc-container-trigger").addClass("active");
                toastr.success("Registro almacenado");
                if ($(".table").find('.dataTables_empty').length == 1) {
                    $(".table").find('.dataTables_empty').remove();
                }
            }
            if (response.fullmodule) {
                toastr.error("Ha llegado al numero maximo de modulos.");
            }
        })
        .fail(function (data) {
            errorRequest(data); // en config.js esta esta funcion declarada
        })
        .always(function () {
            loadingProgresiveRing(false);
            $btn.button('reset');
            oTable.draw();
        })

    return false;
});

// Editar

$('#editDocument').submit(function (e) {
    e.preventDefault();

    var row_id = $('#row_id').val();
    var row = $('#' + row_id);

    $('#row_id').val('');

    if (row_id) {
        var submit_button = $(this).find('.submit_button');
        var $btn = submit_button.button('loading');

        var _editModulo = _request.editModulo(
            {
                url: $('#editDocument #_url').val() + '/' + $('#edit_id').val(),
                data: $('#editDocument').serialize()
            });

        loadingProgresiveRing(true);

        $.when(_editModulo)
            .done(function (response) {

                if (response.success) {

                    var _data = response.modulo;

                    $("#editDocument")[0].reset();
                    $(document).find(".card-body").addClass("hidden");
                    $(document).find(".indexDocument-section").removeClass("hidden");

                    $(".edit-doc-container-trigger").addClass("disabled");
                    $(".control-button").removeClass("active");
                    $(".index-doc-container-trigger").addClass("active");
                    console.log(_data);
                    var n=row.find("#numberdocs").text();
                    var data = [
                        '<td class="t-trigger class="item_id" data-label="id" >' + _data.id + '</td>',
                        '<td data-label="description" class="item_name">' + _data.nombre + '</td>',
                        '<td data-label="description" class="item_description">' + _data.descripcion + '</td>',
                        '<td data-label="documentos_publicados_m" class="item_documentos_publicados_m"><a href="documentos#' + _data.id + '">' +n+ '</a></td>',
                       '<td data-label="actions"  class=""><div class="btn-group pull-left" role="group" aria-label="..."><button type="button" class="btn btn-default edit-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger delete-item " data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div></td>',
                        ];


                    oTable.row( row )
                    .data(data)
                    .draw();

                    /*row.find(".item_name").text(_data.nombre);
                    row.find(".item_description").text(_data.descripcion);*/
                    toastr.success("Registro editado");

                }

            }).fail(function (data) {
                errorRequest(data); // en config.js esta esta funcion declarada
            }).always(function () {

                loadingProgresiveRing(false);
                $btn.button('reset');

            })

    }
});

// Eliminar

function removeDocument(item, id) {
    var item = item;
    var a = item.attr("id");
    $("#modalDataType").text($(".card-title").text());
    $("#modalDataName").text($("#"+a +" td:nth-child(1)").text());

    $(".deleteUp").unbind("click").on("click", function (e) {

        var $btn = $(this).button('loading')

        loadingProgresiveRing(true);

        $.when(_request.deleteModulo({ url: $('#newDocument #_url').val() + "/" + id }))
            .done(function (response) {
                if (response.success) {




                    oTable.row( item )
                    .remove()
                    .draw();
                    oTable.columns.adjust().draw();

                    $('#myModal').modal('hide');
                    toastr.success("Registro suprimido");
                }
                if (response.error) {

                    $('#myModal').modal('hide');
                    toastr.error("No se pueden eliminar modulos que contengan documentos asociados.");
                }
            })
            .fail(function (data) {
                errorRequest(data); // en config.js esta esta funcion declarada
            }).always(function () {
                loadingProgresiveRing(false);
                $btn.button('reset');
            })

        return false;
    });

}


})

var _request = {

    listdata: function (_data) {

        return $.ajax({
            url: _data.url,
            type: "GET",
            dataType: "json"
        })

    },

    getModuloId: function (_data) {

        return $.ajax({
            url: _data.url,
            type: 'GET',
            headers: { 'X-CSRF-TOKEN': $('#newDocument #_token').val() },
            cache: false,
            dataType: "json"
        })

    },

    postModulo: function (_data) {

        return $.ajax({
            url: _data.url,
            headers: { 'X-CSRF-TOKEN': $('#newDocument #_token').val() },
            type: 'POST',
            cache: false,
            data: _data.data,
            dataType: "json",
        })

    },

    editModulo: function (_data) {

        return $.ajax({
            url: _data.url,
            type: 'POST',
          	headers: { 
              'X-CSRF-TOKEN': $('#editDocument #_token').val(),
              "Content-Type": "application/x-www-form-urlencoded",
              "X-http-Method-Override":"PUT",
            },
            cache: false,
            data: _data.data,
            dataType: "json",
        });
    },

    deleteModulo: function (_data) {

        return $.ajax({
            url: _data.url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('#newDocument #_token').val(),
              	"Content-Type": "application/x-www-form-urlencoded",
              	"X-http-Method-Override":"DELETE",
            },
            cache: false,
            dataType: 'json',
        })

    }

}

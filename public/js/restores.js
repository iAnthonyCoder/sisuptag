$(document).ready(function () {




    // var idioma={
    //     "sProcessing":     "Procesando...",
    //     "sZeroRecords":    "No hay documentos disponibles.",
    //     "sEmptyTable":     "No hay documentos disponibles.",
    //     "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    //     "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    //     "sSearch":         "Buscar:",
    //     "paginate": {
    //       "first":      "Primera",
    //       "last":       "Ultima",
    //       "next":       "Siguiente",
    //       "previous":   "Anterior"
    //   },
    //   };

    function createDataTable() {
        // var oTable = $('.main-table').DataTable({
        //   "paging": true,
        //   "pageLength": 10,
        //   "lengthChange": false,
        //   "fixedHeader": true,
        //   'searching'   : true,
        //   "language": idioma,
        //   "processing": true,
        //   "scrollX": true,
        //   'info': false,
        //   'ordering': true,
        //   "order": [[ 0, "asc" ]],
        //   'responsive'  :true,

        // })
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

    function addItem(restore) {
        var size = parseInt(restore.size / 1024, 10);
        console.log("a");
        var table = "";
        table += '<tr id="id_' + restore.id + '" data-id="' + restore.id + '">';
        table += '<td class="t-trigger class="item_id" data-label="id" >' + restore.id + '</td>';
        table += '<td data-label="description" class="item_description">' + restore.description + '</td>';
        table += '<td data-label="date" class="item_updated_at">' + restore.created_at + '</td>';
        //table += '<td data-label="size" class="item_size">' + size + " KB" + '</td>';

        table += '<td data-label="actions"  class=""><div class="btn-group pull-left" role="group" aria-label="..."><button data-toggle="modal" data-target="#myModal2" type="button" class="btn btn-default rollback"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span></button><button type="button" class="btn btn-default edit-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger delete-item " data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div></td>';






        table += '</tr>';
        table = $(table);
        $('.main-tbody-table').append(table);
        // tableScrollBottom();
    }



    $(document).on("click", ".delete-item", function (e) {
        var item = $(this).parent().parent().parent();
        var id = item.data("id");
        removeDocument(item, id);
    })

    $(document).on("click", ".rollback", function (e) {

        var item = $(this).parent().parent().parent();
        var id = item.data("id");
        rollbackDB(item, id);
    })


    $(document).on("click", ".edit-item", function (e) {
        var item = $(this).parent().parent().parent();
        var id = item.data("id");
        $("#editDocument")[0].reset();
        editDocument(id, item);
    })





    function editDocument(id, item) {

        var url = $('#editDocument #_url').val() + "/" + id;
        console.log(item);
        $.ajax(
            {
                url: url,
                type: 'GET',
                headers: { 'X-CSRF-TOKEN': $('#newDocument #_token').val() },
                cache: false,
                success: function (response) {
                    $(document).find(".card-body").addClass("hidden");
                    $(document).find(".editDocument-section").removeClass("hidden");

                    $(".edit-doc-container-trigger").removeClass("disabled");
                    $(".control-button").removeClass("active");
                    $(".edit-doc-container-trigger").addClass("active");

                    var json = $.parseJSON(response);
                    console.log(json);
                    $('#editDocument #row_id').val(item.attr('id')); // guardo el id (table id) del item que estoy editando para luego modificarlo
                    $('#editDocument #edit_id').val(json.restore.id); // id (item o product id) para enviarlo en el formulario


                    $('#editDocument #description').val(json.restore.description); //  name (item o product)
                },
            });
        return false;
    }


    $('#editDocument').submit(function (e) {
        e.preventDefault();

        var data = $('#editDocument').serialize();
        var row_id = $('#row_id').val();
        var row = $('#' + row_id);
        $('#row_id').val('');
        if (row_id) {
            var submit_button = $(this).find('.submit_button');
            var $btn = submit_button.button('loading')
            $.ajax(
                {
                    url: $('#editDocument #_url').val() + '/' + $('#edit_id').val(),
                   type: 'POST',
          	headers: { 
              'X-CSRF-TOKEN': $('#editDocument #_token').val(),
              "Content-Type": "application/x-www-form-urlencoded",
              "X-http-Method-Override":"PUT",
            },
                    cache: false,
                    data: data,
                    success: function (response) {
                        var json = $.parseJSON(response);
                        if (json.success) {
                            $("#editDocument")[0].reset();
                            $(document).find(".card-body").addClass("hidden");
                            $(document).find(".indexDocument-section").removeClass("hidden");

                            $(".edit-doc-container-trigger").addClass("disabled");
                            $(".control-button").removeClass("active");
                            $(".index-doc-container-trigger").addClass("active");


                            row.find(".item_id").text(json.restore.id);
                            row.find(".item_description").text(json.restore.description);
                            row.find(".item_updated_at").text(json.restore.updated_at);
                            row.find(".item_size").text(json.restore.size);
                            toastr.success("Registro editado");
                        }

                    },
                    error: function (data) {
                        errorRequest(data); // en config.js esta esta funcion declarada
                    },
                    complete: function () {
                        $btn.button('reset')

                    }
                })
        }
    });


    function removeDocument(item, id) {
        var a = item.attr("id");
    $("#modalDataType").text($(".card-title").text());
    $("#modalDataName").text($("#"+a +" td:nth-child(1)").text());

        $(".deleteUp").unbind("click").on("click", function (e) {
            var $btn = $(this).button('loading')
            var url = $('#newDocument #_url').val();
            url = url + "/" + id;
            console.log($('#newDocument #_url').val());
            $.ajax(
                {
                    url: url,
                    type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('#newDocument #_token').val(),
              	"Content-Type": "application/x-www-form-urlencoded",
              	"X-http-Method-Override":"DELETE",
            },
                    cache: false,
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $(item).remove();
                            $('#myModal').modal('hide');
                            toastr.success("Registro suprimido");
                        }
                        if (response.error) {

                            $('#myModal').modal('hide');
                            toastr.error("No se pueden eliminar modulos que contengan documentos asociados.");
                        }
                    },

                    error: function (data) {
                        errorRequest(data); // en config.js esta esta funcion declarada
                    },
                    complete: function () {
                        $btn.button('reset');

                    }
                });
            return false;
        });



    }








    listdata();
    function listdata() {

        $.get($('#_urldoc').val() + "/", function (data) {

            $.each(JSON.parse(data).restores, function (key, restore) {

                addItem(restore);

            });
            createDataTable();
        });
    }







    $('#newDocument').submit(function (e) {
        e.preventDefault();

        var data = $('#newDocument').serialize();


        var submit_button = $(this).find('.submit_button');
        var $btn = submit_button.button('loading')

        $.ajax(
            {
                url: $('#newDocument #_url').val(),
                headers: { 'X-CSRF-TOKEN': $('#newDocument #_token').val() },
                type: 'POST',
                cache: false,
                data: data,
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.success) {
                        $("#newDocument")[0].reset();

                        console.log(response);
                        addItem(json.restore);
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

                },
                error: function (data) {
                    errorRequest(data); // en config.js esta esta funcion declarada
                },
                complete: function () {
                    $btn.button('reset');

                }

            });
        return false;
    });


    $(document).on("click", ".control-button", function (e) {

        $(this).parents().find(".control-button").removeClass("active");
        $(this).addClass("active");
        $(".edit-doc-container-trigger").addClass("disabled");
    })












    function rollbackDB(item, id) {
        var item = item;
        var url = $('#newDocument #_url').val();
        url = url + "/" + id + "/edit";
        $("#dcbuContent").text(item.find(".item_description").text());
        $("#datebu").text(item.find(".item_updated_at").text());
        $("#restoreLink").attr("href", url);

        $("#restoreLink").unbind("click").on("click", function (e) {

            var $btn = $(this).button('loading')
            toastr.warning("En proceso... No apague el servidor");
            $("body").addClass("noclick")
            /*
            console.log($('#newDocument #_url').val());
            $.ajax(
            {
              url: url,
              headers: {'X-CSRF-TOKEN': $('#newDocument #_token').val()},
              type: 'GET',
              cache: false,
              dataType: 'json',
              success: function(response){
                if (response.success){

                      $('#myModal').modal('hide');
                      toastr.success("Base de datos restaurada, se cerrará la sesión.");
                }
                if (response.error){

                  $('#myModal').modal('hide');
                  toastr.error("No se pueden eliminar modulos que contengan documentos asociados.");
            }
              },

            error: function(data)
            {
              var errors = data.responseJSON;
              $.each(errors.errors, function( key, value )
              {
                toastr.error(value);
                return false;
              });
            },
            complete: function (){
              $btn.button('reset');

            }
            });
            return false;*/
        });



    }










})

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


        var url2 = window.location.href;
        if (url2.indexOf("#") >= 1) {
            var mod2 = url2.substr(url2.indexOf("#") + 1, url2.length);
            $("#searcher").val(mod2);
        }
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

    $(document).on("click", ".delete-item", function (e) {
        var item = $(this).parent().parent().parent();
        var id = item.attr("id");
        id=id.substr(id.indexOf("_")+1, id.length-3);
        removeDocument(item, id);
    })

    $(document).on("click", ".edit-item", function (e) {
        var item = $(this).parent().parent().parent();
        var id = item.attr("id");
        id=id.substr(id.indexOf("_")+1, id.length-3);

        $("#editDocument")[0].reset();
        editDocument(id, item);
    })

    listdata();

    function listdata() {
        loadingProgresiveRing(true);
        $.when(_request.listdata({ url: $('#_urldoc').val() + "/" }))
            .done(function (data) {

                $.each(data, function (key, user) {
                    addItem(user);
                });

                //createDataTable();
            }).always(function(){
                loadingProgresiveRing(false);
            })

    }

    $(document).on("click", ".control-button", function (e) {

        $(this).parents().find(".control-button").removeClass("active");
        $(this).addClass("active");
        $(".edit-doc-container-trigger").addClass("disabled");
    })








     function modulos_id_u_filler() {
        $.get($("#_urlmodlist").val() ,function (data)
        {
            var datos=JSON.parse(data);

            var selectopt="<option value=''>SELECCIONE</option>";
            $.each(JSON.parse(data),function(key, modulo) {
              selectopt+= '<option value="'+modulo.id+'">'+modulo.nombre+'</option>';
            });
            $(document).find("#newDocument #modulos_id_u").html(selectopt);
            $(document).find("#editDocument #modulos_id_u").html(selectopt);


        });
     }modulos_id_u_filler();


     $("#newDocument #id_admin").on("change", function(e){
         if($(this).val()!=0)
         {
            $("#newDocument > div:nth-child(7)").addClass("hide");
         }
         else if($(this).val()==0)
         {
            $("#newDocument > div:nth-child(7)").removeClass("hide");
         }
     })
     $("#editDocument #id_admin").on("change", function(e){
        if($(this).val()!=0)
        {
           $("#editDocument > div:nth-child(9)").addClass("hide");
        }
        else if($(this).val()==0)
        {
           $("#editDocument > div:nth-child(9)").removeClass("hide");
        }
    })








// HACE UNA FUNCION

function addItem(user) {

    var _isAdmin = user.is_admin == 1;
    var _isEnable = user.enabled == 1;
    var tipo = _isAdmin ? "ADMIN" : "MIEMBRO";
    var estado = _isEnable ? "HABILITADO" : "SUSPENDIDO";

    var _classColor1 = !_isAdmin ? "primary" : "danger";
    var _classIcon1 = !_isAdmin ? "user" : "wrench";

    var _classColor2 = _isEnable ? "primary" : "danger";
    var _classIcon2 = _isEnable ? "ok" : "remove";

    var badgecolor = '<span class="label label-' + _classColor1 + '"><span class="glyphicon glyphicon-' + _classIcon1 + '" aria-hidden="true"></span>';
    var badgecolor2 = '<span class="label label-' + _classColor2 + '"><span class="glyphicon glyphicon-' + _classIcon2 + '" aria-hidden="true"></span>';
    var deleteButton="";
    if (user.documentos_publicados == null) {
        user.documentos_publicados = 0;

    }

    if(user.documentos_publicados==0)
    {
        deleteButton='<button type="button" class="btn btn-danger delete-item" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div>';

    }
    var moduloNombre=""
    if(user.nombre==null)
    {
        moduloNombre="No aplica";
    }
    else
    {
        moduloNombre=user.nombre;
    }

    var table = [

    '<td class="t-trigger " data-label="id" >' + user.id + '</td>',
    '<td data-label="name" class="item_name">' + user.name + '</td>',
    '<td data-label="email" class="item_email">' + user.email + '</td>',
    '<td data-label="is_admin" class="item_is_admin">' + badgecolor + " " + tipo + '</span></td>',
    '<td data-label="modulo_nombre" class="item_modulo_nombre">' + moduloNombre +  '</span></td>',
    '<td data-label="enabled" class="item_enabled">' + badgecolor2 + " " + estado + '</span></td>',
    '<td data-label="documentos_publicados" class="item_documentos_publicados" ><a id="publisheddocs" href="documentos#USER=' + user.name + '">' + user.documentos_publicados + '</a></span></td>',
    '<td data-label="actions"  class=""><div class="btn-group pull-left" role="group" aria-label="..."><button type="button" class="btn btn-default edit-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>'+deleteButton+'</td>'

];
    oTable.row.add( table ).node().id = 'id_'+user.id+'';

    oTable.draw( false );

    // tableScrollBottom();
}

// Obtener Datos Usuario por ID

function editDocument(id, item) {

    loadingProgresiveRing(true);

    var _getUserId = _request.getUserId({ url: $('#editDocument #_url').val() + "/" + id });

    $.when(_getUserId)
        .done(function (response) {

            $(document).find(".card-body").addClass("hidden");
            $(document).find(".editDocument-section").removeClass("hidden");

            $(".edit-doc-container-trigger").removeClass("disabled");
            $(".control-button").removeClass("active");
            $(".edit-doc-container-trigger").addClass("active");

            var _dataUser = response.user;

            $('#editDocument #row_id').val(item.attr('id')); // guardo el id (table id) del item que estoy editando para luego modificarlo
            $('#editDocument #edit_id').val(_dataUser.id); // id (item o product id) para enviarlo en el formulario

            $('#editDocument #name').val(_dataUser.name); //  name (item o product)
            $('#editDocument #email').val(_dataUser.email); //  name (item o product)
            $('#editDocument #enabled').val(_dataUser.enabled); //  name (item o product)
            $('#editDocument #id_admin').val(_dataUser.is_admin); //  name (item o product)
            $('#editDocument #modulos_id_u').val(_dataUser.modulos_id_u); //  name (item o product)
            if((_dataUser.is_admin)!=0)
        {
                   $("#editDocument > div:nth-child(9)").addClass("hide");
                }
                else if((_dataUser.is_admin)==0)
                {
                   $("#editDocument > div:nth-child(9)").removeClass("hide");
                }
            })



        .always(function () { loadingProgresiveRing(false); });

    return false;
}

// CRUD

// AGREGAR
$('#newDocument').submit(function (e) {
    e.preventDefault();

    var submit_button = $(this).find('.submit_button');
    var $btn = submit_button.button('loading');
    var _postUser = _request.postUser({ url: $('#newDocument #_url').val(), data: $('#newDocument').serialize() });

    loadingProgresiveRing(true);

    $.when(_postUser)
        .done(function (response) {


            var resp=response.user;
            // resp=resp+response.modulo;

            if (response.success) {
                $("#newDocument")[0].reset();

                addItem(resp);
                $(document).find(".card-body").addClass("hidden");
                $(document).find(".indexDocument-section").removeClass("hidden");

                $(".edit-doc-container-trigger").addClass("disabled");
                $(".control-button").removeClass("active");
                $(".index-doc-container-trigger").addClass("active");
                toastr.success("Se ha enviado el link para la creacion de la clave al email suministrado");
                if ($(".table").find('.dataTables_empty').length == 1) {
                    $(".table").find('.dataTables_empty').remove();
                }
            }
        }).fail(function (data) {
            errorRequest(data); // en config.js esta esta funcion declarada
        }).always(function () {
            loadingProgresiveRing(false);
            $btn.button('reset');
            oTable.draw();
        })

    return false;
});

// EDITAR
$('#editDocument').submit(function (e) {
    e.preventDefault();

    var row_id = $('#row_id').val();
    var row = $('#' + row_id);
    $('#row_id').val('');

    if (row_id) {

        var submit_button = $(this).find('.submit_button');
        var $btn = submit_button.button('loading')

        var _editUser = _request.editUser({
            url: $('#editDocument #_url').val() + '/' + $('#edit_id').val(),
            data: $('#editDocument').serialize()
        })

        loadingProgresiveRing(true);

        $.when(_editUser)
            .done(function (response) {

                $("#editDocument")[0].reset();
                $(document).find(".card-body").addClass("hidden");
                $(document).find(".indexDocument-section").removeClass("hidden");

                $(".edit-doc-container-trigger").addClass("disabled");
                $(".control-button").removeClass("active");
                $(".index-doc-container-trigger").addClass("active");

                if (response.errorAdmin) {

                    $('#myModal').modal('hide');
                    toastr.error("Este usuario no puede ser editado");
                    return false;
                }
                console.log(response);
                var _dataUser = response.user;

                var _isAdmin = _dataUser.is_admin == 1;
                var _isEnable = _dataUser.enabled == 1;

                var _tipo = _isAdmin ? "ADMIN" : "MIEMBRO";
                var _estado = _isEnable ? "HABILITADO" : "SUSPENDIDO";

                var _background1 = {
                    classcolor: !_isAdmin ? "primary" : "danger",
                    classicon: !_isAdmin ? "user" : "wrench"
                }

                var _background2 = {
                    classcolor: _isEnable ? "primary" : "danger",
                    classicon: _isEnable ? "ok" : "remove"
                }

                var badgecolor = '<span class="label label-' + _background1.classcolor + '"><span class="glyphicon glyphicon-' + _background1.classicon + '" aria-hidden="true"></span> ' + _tipo + '</span>';
                var badgecolor2 = '<span class="label label-' + _background2.classcolor + '"><span class="glyphicon glyphicon-' + _background2.classicon + '" aria-hidden="true"></span> ' + _estado + '</span>';
                var moduloNombre;
                if(response.modulo==null)
    {
        moduloNombre="No aplica";
    }
    else
    {
        moduloNombre=response.modulo.nombre;
    }


                var n=row.find("#publisheddocs").text();
                var data = [

                    '<td class="t-trigger " data-label="id" >' + _dataUser.id + '</td>',
                    '<td data-label="name" class="item_name">' + _dataUser.name + '</td>',
                    '<td data-label="email" class="item_email">' + _dataUser.email + '</td>',
                    '<td data-label="is_admin" class="item_is_admin">' + badgecolor +  '</span></td>',
                    '<td data-label="modulo_nombre" class="item_modulo_nombre">' + moduloNombre +  '</span></td>',
                    '<td data-label="enabled" class="item_enabled">' + badgecolor2 + '</span></td>',
                    '<td data-label="documentos_publicados" class="item_documentos_publicados" ><a href="documentos#USER=' + _dataUser.name + '">' + n + '</a></span></td>',
                    '<td data-label="actions"  class=""><div class="btn-group pull-left" role="group" aria-label="..."><button type="button" class="btn btn-default edit-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger delete-item" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div></td>'

                ];
                oTable.row( row )
                .data(data)
                .draw();




                row.find(".item_name").text(_dataUser.name);
                row.find(".item_email").text(_dataUser.email);

                row.find(".item_is_admin").html(badgecolor);
                row.find(".item_enabled").html(badgecolor2);

                toastr.success("Registro editado");


            })
            .fail(function (data) {
                errorRequest(data); // en config.js esta esta funcion declarada
            })
            .always(function () {
                loadingProgresiveRing(false);
                $btn.button('reset');
            })

        // $.ajax(
        //     {
        //         url: $('#editDocument #_url').val() + '/' + $('#edit_id').val(),
        //         headers: { 'X-CSRF-TOKEN': $('#editDocument #_token').val() },
        //         type: 'PUT',
        //         cache: false,
        //         data: data,
        //         success: function (response) {
        //             var json = $.parseJSON(response);
        //             console.log(json);
        //             if (json.errorAdmin) {

        //                 $('#myModal').modal('hide');
        //                 toastr.error("Este usuario no puede ser editado");
        //             }
        //             else {

        //                 if (json.user.is_admin == "1")
        //                     tipo = "ADMIN";
        //                 else
        //                     tipo = "MIEMBRO"
        //                 row.find(".item_name").text(json.user.name);
        //                 row.find(".item_email").text(json.user.email);

        //                 var badgecolor = "";
        //                 var badgecolor2 = "";


        //                 if (json.user.enabled == 1) {
        //                     badgecolor2 = '<span class="label label-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> HABILITADO</span>';
        //                     estado = "HABILITADO";
        //                 }
        //                 else {
        //                     badgecolor2 = '<span class="label label-danger"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> SUSPENDIDO</span>';
        //                     estado = "SUSPENDIDO";
        //                 }

        //                 if (json.user.is_admin == 0) {
        //                     badgecolor = '<span class="label label-primary"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> MIEMBRO</span>';
        //                 }
        //                 else {
        //                     badgecolor = '<span class="label label-danger"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> ADMIN</span>';
        //                 }

        //                 row.find(".item_is_admin").html(badgecolor);
        //                 row.find(".item_enabled").html(badgecolor2);

        //                 toastr.success("Registro editado");

        //             }
        //             $("#editDocument")[0].reset();
        //             $(document).find(".card-body").addClass("hidden");
        //             $(document).find(".indexDocument-section").removeClass("hidden");

        //             $(".edit-doc-container-trigger").addClass("disabled");
        //             $(".control-button").removeClass("active");
        //             $(".index-doc-container-trigger").addClass("active");


        //         },
        //         error: function (data) {
        //             errorRequest(data); // en config.js esta esta funcion declarada
        //         },
        //         complete: function () {

        //             $btn.button('reset');
        //         }
        //     })
    }
});


// ELIMINAR
function removeDocument(item, id) {
    var item = item;
    var a = item.attr("id");
    $("#modalDataType").text($(".card-title").text());
    $("#modalDataName").text($("#"+a +" td:nth-child(1)").text());

    $(".deleteUp").unbind("click").on("click", function (e) {

        var $btn = $(this).button('loading');

        var _deleteUser = _request.deleteUser({ url: $('#newDocument #_url').val() + "/" + id });
        loadingProgresiveRing(true);

        $.when(_deleteUser)
            .done(function (response) {

                $('#myModal').modal('hide');

                if (response.success) {
                    oTable.row( item )
                    .remove()
                    .draw();
                    oTable.columns.adjust().draw();
                    toastr.success("Registro suprimido");
                    return false;
                }

                var _msj = "";

                if (response.error) { _msj = "No se pueden eliminar usuarios que contengan documentos asociados."; }
                if (response.errorAdmin) { _msj = "Este usuario no puede ser eliminado"; }
                if (response.sameUser) { _msj = "No se puede eliminar al usuario que abrió sesión."; }

                toastr.error(_msj);

            })
            .fail(function (data) {
                errorRequest(data); // en config.js esta esta funcion declarada
            })
            .always(function () {
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
            dataType: "json",
        })

    },

    getUserId: function (_data) {

        return $.ajax({
            url: _data.url,
            type: 'GET',
            headers: { 'X-CSRF-TOKEN': $('#newDocument #_token').val() },
            cache: false,
            dataType: "json",
        })

    },

    postUser: function (_data) {

        return $.ajax({
            url: _data.url,
            headers: { 'X-CSRF-TOKEN': $('#newDocument #_token').val() },
            type: 'POST',
            cache: false,
            data: _data.data,
            dataType: "json",
        })

    },

    editUser: function (_data) {

        return $.ajax({
            url: _data.url,
            type: 'PUT',
          	headers: {
              'X-CSRF-TOKEN': $('#editDocument #_token').val(),
            //   "Content-Type": "application/x-www-form-urlencoded",
            //   "X-http-Method-Override":"PUT",
            },
            cache: false,
            data: _data.data,
            dataType: "json",
        })

    },

    deleteUser: function (_data) {

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

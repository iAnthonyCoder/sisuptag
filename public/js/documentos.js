document.querySelector(".onlyNumber").addEventListener("keypress", function (evt) {
    if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
        evt.preventDefault();
    }
});

$(document).ready(function () {


    $(document).on("change","#modulos_id", function (e) {

        var idselect = ($(this).val());

        if ($('.nav-link').length > 0) {
            $(".nav-link").each(function () {

                if ($(this).data("id") == idselect) {

                    controlDisabled($(this));
                }

            });
        }

    })



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
            "scrollX": true,
            "scrollY": false,
            'info': false,
            'ordering': true,
            "order": [[0, "asc"]],
            'responsive': true,

        })

        if (window.location.href.indexOf('#USER=') > 0) {
            var mod3 = window.location.href.substr(window.location.href.indexOf('#USER=') + 6, window.location.href.strlen);
            $("#searcher").val(mod3);
            oTable.search(mod3).draw();

        }


        $('#searcher').keyup(function () {
            oTable.search($(this).val()).draw();
        })






    $(document).on("click", ".nav-link", function () {
        $(document).find("#newDocument #modulos_id").val($(this).data("id"));
    })

    $(document).on("click", ".new-doc-container-trigger", function () {

        if ($('.nav-link').length > 0) {
            $(".nav-link").each(function () {

                if ($(this).parent().hasClass("active")) {

                        controlDisabled($(this));

                }
            });
        }

        if ($('.nav-link').length > 0) {

            $(".nav-link").each(function () {

                if ($(this).parent().hasClass("active")) {

                    $(document).find(".card-body").addClass("hidden");
                    $(document).find(".createDocument-section").removeClass("hidden");
                    $(document).find("#newDocument #modulos_id").val($(this).data("id"));

                }
                else {

                    $(document).find(".card-body").addClass("hidden");
                    $(document).find(".createDocument-section").removeClass("hidden");

                }
            });
        }
        else
        {
            $(document).find(".card-body").addClass("hidden");
                    $(document).find(".createDocument-section").removeClass("hidden");//agregar el id del modulo a una data en title-ch y colocarlo en el inout
                    $("#newDocument #modulos_id").val($(".card-title-ch").data("id"));
                    // $("#newDocument #modulos_id").attr("disabled","disabled")
                    $("#newDocument > div:nth-child(3)").hide();

                }

    });

    $(document).on("click", ".index-doc-container-trigger", function () {
        $(document).find(".card-body").addClass("hidden");
        $(document).find(".indexDocument-section").removeClass("hidden");

    })

    $('#table tbody').empty();

    var url = window.location.href;

    if ((url.substr(url.indexOf("#"), 1) == "#")&&(window.location.href.indexOf('#USER=') < 1)) {

        var mod = url.substr(url.length - 1, 3);

        listdata(mod)

    }
    else {

        $(".nav").addClass("noclick");
        loadingProgresiveRing(true);

        $.when(_request.getDocAll({ url: $('#_url').val() }))
            .done(function (response) {

                if (response.success) {

                    if (!response.user_is_admin)
                    {


                        $(".card-title-ch").html("<span class='glyphicon glyphicon-file'></span>"+response.documentos[0].nombre);
                        $(".card-title-ch").attr("data-id", response.moduloId);
                        if(response.row1){$("#newDocument #codigo, #editDocument #codigo").attr("disabled",false)}else{$("#newDocument #codigo, #editDocument #codigo").attr("disabled",true)}
                        if(response.row2){$("#newDocument #tipo, #editDocument #tipo").attr("disabled",false)}else{$("#newDocument #tipo, #editDocument #tipo").attr("disabled",true)}
                        if(response.row3){$("#newDocument #fecha, #editDocument #fecha").attr("disabled",false)}else{$("#newDocument #fecha, #editDocument #fecha").attr("disabled",true)}
                        if(response.row4){$("#newDocument #description, #editDocument #description").attr("disabled",false)}else{$("#newDocument #description, #editDocument #description").attr("disabled",true)}
                    }
                    else if((window.location.href.indexOf('#USER=') > 1))
                    {
                        $(".card-title-ch").html("<span class='glyphicon glyphicon-file'></span>Documentos subidos por "+window.location.href.substr(window.location.href.indexOf('#USER=') + 6, window.location.href.strlen));
                    }
                    else
                    {
                        $(document).find(".card-title-ch").html("<span class='glyphicon glyphicon-file'></span>"+"DOCUMENTOS");
                    }

                    addItem(response.documentos);
                   // createDataTable();
                }

            }).always(function () {
                loadingProgresiveRing(false);
                $(".nav").removeClass("noclick");
                oTable.columns.adjust().draw();
            })

    }

    function listdata(id) {

        $(".nav").addClass("noclick");
        loadingProgresiveRing(true);

        $.when(_request.listdata({ url: $('#_urldoc').val() + "/" + id }))
            .done(function (data) {
                if(data.length>0)
                {
                $(document).find(".card-title-ch").html("<span class='glyphicon glyphicon-file'></span>"+data[0].nombre);
                addItem(data);
                }

            })
            .always(function () {
                $(".nav").removeClass("noclick");
                oTable.columns.adjust().draw();
                loadingProgresiveRing(false);

            })

    }
    $(document).on("click", ".nav-link", function (e) {
        var _$this = $(this);
        controlDisabled(_$this);

        $(".nav-link").parent().removeClass("active");
        _$this.parent().addClass("active");

        oTable.clear();
        listdata(_$this.data("id"));
        oTable.draw( false );
        $(document).find(".card-body").addClass("hidden");
        $(document).find(".indexDocument-section").removeClass("hidden");



        $(document).find(".control-button").removeClass("active");
        $(".edit-doc-container-trigger").addClass("disabled");
        $(".index-doc-container-trigger").addClass("active");

    })





    $(document).on("click", ".control-button", function (e) {

        $(this).parents().find(".control-button").removeClass("active");
        $(this).addClass("active");
        $(".edit-doc-container-trigger").addClass("disabled");

    })



// control de inputs

function controlDisabled($this) {
    console.log("object");
    var tableheaders = JSON.parse(decodeURIComponent($this.data("tableheads")));

    var _IsCodigo = tableheaders.codigo == 0;
    var _IsTipo = tableheaders.tipo == 0;
    var _IsFecha = tableheaders.fecha == 0;
    var _IsDesc = tableheaders.descripcion == 0;


    $(document).find($("#newDocument #codigo").prop("disabled", _IsCodigo));
    $(document).find($("#editDocument #codigo").prop("disabled", _IsCodigo));

    $(document).find($("#newDocument #tipo").prop("disabled", _IsTipo));
    $(document).find($("#editDocument #tipo").prop("disabled", _IsTipo));

    $(document).find($("#newDocument #fecha").prop("disabled", _IsFecha));
    $(document).find($("#editDocument #fecha").prop("disabled", _IsFecha));

    $(document).find($("#newDocument #description").prop("disabled", _IsDesc));
    $(document).find($("#editDocument #description").prop("disabled", _IsDesc));

}


// RENDER DATA

function addItem(document) {

    var _length = document.length;
    var table = "";

    for (var i = 0; i < _length; i++) {

        var _dataIndex = document[i];
        _templateTrDoc(_dataIndex);


    }



}

function _templateTrDoc(_data) {


    var _templateHtml = '';

    var tipo="";


    if(_data.tipo==1) { tipo="ORDINARIA" }
    else if( _data.tipo==2){tipo="EXTRAORDINARIA"}
    else{tipo=_data.tipo};

    var classColor = _data.user_is_admin == 0 ? "primary" : "danger";
    var classIcon = _data.user_is_admin == 0 ? "user" : "wrench";
    var badgecolor = '<button onclick="window.location.href = \'users#' + _data.name + '\';" class="btn btn-' + classColor + '"><span class="glyphicon glyphicon-' + classIcon + '" aria-hidden="true"></span>';;

    if(tipo==null||tipo.length==0||tipo==undefined)
      {
        tipo="N/A";
      }

      if(_data.codigo==null || _data.codigo==0)
      {
        _data.codigo="N/A";
      }
      if(_data.fecha==null||_data.fecha=="0000-00-00"||_data.fecha=="")
      {
        _data.fecha="N/A";
      }
      if(_data.description==null||_data.description=="")
      {
        _data.description="N/A";
      }

    urlgenerate = $('#_url').val() + "/generatePdf/" + _data.id;


    var actualuser = $("#userdata").data("id");

    var actButtons = "";
    if(_data.user_id==actualuser||$("#userdata").data("is_admin"))
    {
      actButtons = '<td data-label="actions"  class=""><div class="btn-group pull-left" role="group" aria-label="..."><button type="button" onclick="window.open(\'' + urlgenerate + '\',\'_blank\'); return false;" class="btn btn-default item_doc" title="Mostrar" ><span class="glyphicon glyphicon-file" aria-hidden="true"></span><button type="button" class="btn btn-default edit-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger delete-item" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div></td>';
    }
    else
    {
      actButtons = '<td data-label="actions"  class=""><div class="btn-group pull-left" role="group" aria-label="..."><button type="button" onclick="window.open(\'' + urlgenerate + '\',\'_blank\'); return false;" class="btn btn-default item_doc" title="Mostrar" ><span class="glyphicon glyphicon-file" aria-hidden="true"></span></div></td>';

    }


    _templateHtml=[
        '<td class="t-trigger " class="item_id" data-label="id" >' + _data.id + '</td>',
        '<td class="item_codigo" data-label="codigo" class="">' + _data.codigo + '</td>',
        '<td class="item_tipo" data-label="tipo" >' + tipo + '</td>',
        '<td data-label="fecha"  class="item_fecha">' + _data.fecha + '</td>',
        '<td data-label="description" class="item_descripcion">' + _data.description + '</td>',
        '<td data-label="user_name" class="item_user_name getname" id="'+_data.name+'" >' + badgecolor + '' + " " + _data.name + '</button></td>',
        actButtons,
        //table += '<td data-label="actions"  class=""><div class="btn-group pull-left" role="group" aria-label="..."><button type="button" class="btn btn-default pdf_gen" title="Mostrar" ><span class="glyphicon glyphicon-file" aria-hidden="true"></span><button type="button" class="btn btn-default edit-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger delete-item" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div></td>';
    ]
     oTable.row.add( _templateHtml ).node().id = 'id_'+_data.id+'';
     oTable.draw( false );
}

// BTN ACCIONES

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

$(document).on("click", ".pdf_gen", function (e) {
    var item = $(this).parent().parent().parent();
    var id = item.attr("id");
    id=id.substr(id.indexOf("_")+1, id.length-3);

    urlgenerate = $('#_url').val() + "/generatePdf/" + id;

    var _obtPdf = _request.getPdf(urlgenerate);

    loadingProgresiveRing(true);

    $.when(_obtPdf)
        .done(function (response) {

            $("#pdfsrc").attr("src", 'data:application/pdf;base64,' + response.data);

        })
        .always(function () { loadingProgresiveRing(false) });

})

function editDocument(id, item) {

    var url = $('#editDocument #_url').val() + "/" + id;
    loadingProgresiveRing(true);
    $.when(_request.getDocId({ url: url }))
        .done(function (response)
        {
            if(response.invalid_user)
            {
                toastr.error("No estas autorizado para esta acción");
            }
            else
            {
                var _dataDoc = response.documento;
                var idselect = (_dataDoc.modulos_id);
                var tipodoc = _dataDoc.tipo == "ORDINARIA" ? 1 : 2;
                $(document).find(".card-body").addClass("hidden");
                $(document).find(".editDocument-section").removeClass("hidden");
                $('#box_to_edit_product').show();
                $('#box_to_add_product').hide();

                $(".nav-link").each(function () {
                    if ($(this).data("id") == idselect) {
                        controlDisabled($(this));
                    }
                });
                $('#editDocument #row_id').val(item.attr('id')); // guardo el id (table id) del item que estoy editando para luego modificarlo
                $('#editDocument #edit_id').val(_dataDoc.id); // id (item o product id) para enviarlo en el formulario
                $('#editDocument #modulos_id').val(_dataDoc.modulos_id);
                $('#editDocument #description').val(_dataDoc.description); //  name (item o product)
                $('#editDocument #fecha').val(_dataDoc.fecha);
                $('#editDocument #tipo').val(tipodoc);
                $('#editDocument #codigo').val(_dataDoc.codigo);
                $('#editDocument #dirlocalact').val(_dataDoc.dirlocal);
                $("#editDocument #actfile").attr("href", "pdf/" + _dataDoc.dirlocal).text(_dataDoc.dirlocal);
                $(".edit-doc-container-trigger").removeClass("disabled");
                $(".control-button").removeClass("active");
                $(".edit-doc-container-trigger").addClass("active");
                (!response.is_admin)    ?   $("#moduloInputGroup").addClass("hidden")
                                        :   $("#moduloInputGroup").removeClass("hidden");
            }
        })
        .always(function () { loadingProgresiveRing(false) });
        return false;
}

// CRUD
// AGREGAR

$('#newDocument').submit(function (e) {

    e.preventDefault();
    var submit_button = $(this).find('.submit_button');
    var $btn = submit_button.button('loading')
    var data = new FormData($(this)[0]);

    var _postDoc = _request.postDoc({ url: $('#newDocument #_url').val(), values: data });

    loadingProgresiveRing(true);

    $.when(_postDoc)
        .done(function (response) {

            $("#newDocument")[0].reset();
            $(".edit-doc-container-trigger").addClass("disabled");
            $(".control-button").removeClass("active");
            $(".index-doc-container-trigger").addClass("active");
            $(document).find(".card-body").addClass("hidden");
            $(document).find(".indexDocument-section").removeClass("hidden");

            if (response.success) {

                _templateTrDoc(response.documento);
                toastr.success("Registro almacenado");
                $btn.button('reset');
                if ($(".table").find('.dataTables_empty').length == 1) {
                    $(".table").find('.dataTables_empty').remove();
                }

            }

            if (response.error) {
                toastr.success("No hay archivos en la base de datos");
            }

        })
        .fail(function (data) {
            errorRequest(data); // en config.js esta esta funcion declarada
        })
        .always(function () {
            loadingProgresiveRing(false);
            submit_button.attr('disabled', false);
            $btn.button('reset');oTable.draw();
        })

});

// EDITAR
$('#editDocument').submit(function (e) {
    e.preventDefault();

    var data = new FormData($(this)[0]);

    var row_id = $('#row_id').val();
    var row = $('#' + row_id);
    $('#row_id').val('');
    if (row_id) {
        var submit_button = $(this).find('.submit_button');
        var $btn = submit_button.button('loading');

        var _url = $('#editDocument #_url').val() + '/' + $('#edit_id').val();

        var _editDoc = _request.editDoc({ url: _url, values: data });
        loadingProgresiveRing(true);
        $.when(_editDoc)
            .done(function (response) {

                var _dataDoc = response.documento;

                if (response.success) {

                    $(document).find(".card-body").addClass("hidden");
                    $(document).find(".indexDocument-section").removeClass("hidden");

                    $(".edit-doc-container-trigger").addClass("disabled");
                    $(".control-button").removeClass("active");
                    $(".index-doc-container-trigger").addClass("active");


                    var n=row.find(".getname").attr("id");



                    var classColor = _dataDoc.user.is_admin == 0 ? "primary" : "danger";
                    var classIcon = _dataDoc.user.is_admin == 0 ? "user" : "wrench";
                    var badgecolor = '<button class="btn btn-' + classColor + '"><span class="glyphicon glyphicon-' + classIcon + '" aria-hidden="true"></span>';;

                    if(_dataDoc.tipo==null||_dataDoc.tipo.length==0||_dataDoc.tipo==undefined)
      {
        _dataDoc.tipo="N/A";
      }

      if(_dataDoc.codigo==null || _dataDoc.codigo==0)
      {
        _dataDoc.codigo="N/A";
      }
      if(_dataDoc.fecha==null||_dataDoc.fecha=="0000-00-00"||_dataDoc.fecha=="")
      {
        _dataDoc.fecha="N/A";
      }
      if(_dataDoc.description==null||_dataDoc.description=="")
      {
        _dataDoc.description="N/A";
      }



                    urlgenerate = $('#_url').val() + "/generatePdf/" + _dataDoc.id;
                    var tipo;
                    if(_dataDoc.tipo==1){tipo="ORDINARIA"};
                    if(_dataDoc.tipo==2){tipo="EXTRAORDINARIA"};




                    _templateHtml=[
                        '<td class="t-trigger " class="item_id" data-label="id" >' + _dataDoc.id + '</td>',
                        '<td class="item_codigo" data-label="codigo" class="">' + _dataDoc.codigo + '</td>',
                        '<td class="item_tipo" data-label="tipo" >' +  _dataDoc.tipo + '</td>',
                        '<td data-label="fecha"  class="item_fecha">' + _dataDoc.fecha + '</td>',
                        '<td data-label="description" class="item_descripcion">' + _dataDoc.description + '</td>',
                        '<td data-label="user_name" class="item_user_name" onclick="window.location.href = \'users#' + _dataDoc.user.name + '\';">' + badgecolor + '' + " " +_dataDoc.user.name+ '</btn></td>',
                        '<td data-label="actions"  class=""><div class="btn-group pull-left" role="group" aria-label="..."><button type="button" onclick="window.open(\'' + urlgenerate + '\',\'_blank\'); return false;" class="btn btn-default item_doc" title="Mostrar" ><span class="glyphicon glyphicon-file" aria-hidden="true"></span><button type="button" class="btn btn-default edit-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger delete-item" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div></td>',
                    //table += '<td data-label="actions"  class=""><div class="btn-group pull-left" role="group" aria-label="..."><button type="button" class="btn btn-default pdf_gen" title="Mostrar" ><span class="glyphicon glyphicon-file" aria-hidden="true"></span><button type="button" class="btn btn-default edit-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button><button type="button" class="btn btn-danger delete-item" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></div></td>';

                    ]









                    oTable.row( row )
                    .data(_templateHtml)
                    .draw();


















                    row.find(".item_codigo").text(_dataDoc.codigo);
                    row.find(".item_tipo").text(_dataDoc.tipo);
                    row.find(".item_fecha").text(_dataDoc.fecha);
                    row.find(".item_descripcion").text(_dataDoc.description);
                    row.find(".item_user_name").text(_dataDoc.name);

                    urlgenerate = $('#_url').val() + "/generatePdf/" + _dataDoc.id;
                    row.find(".item_doc").attr('onclick', 'window.open(\'' + urlgenerate + '\',\'_blank\'); return false;');
                    toastr.success("Registro editado");

                }

                if (response.invalid_user) {
                    toastr.error("No estas autorizado para esta acción");
                }

                $("#editDocument")[0].reset();


            })
            .fail(function (data) {
                errorRequest(data); // en config.js esta esta funcion declarada
            })
            .always(function () {
                loadingProgresiveRing(false);
                $btn.button('reset');
            })

    }
});

// ELIMINAR
function removeDocument(item, id) {
    var item = item;
    var a = item.attr("id");


    $("#modalDataType").text($(".card-title-ch").data("title"));
    $("#modalDataName").text($("#"+a +" td:nth-child(1)").text());

    $(".deleteUp").unbind("click").on("click", function (e) {
        var $btn = $(this).button('loading');

        loadingProgresiveRing(true);

        $.when(_request.deleteDoc({ url: $('#newDocument #_url').val() + "/" + id }))
            .done(function (response) {

                $('#myModal').modal('hide');
                $btn.button('reset')

                if (response.invalid_user) {
                    toastr.error("No estas autorizado para esta acción");
                }

                if (response.success) {
                    oTable.row( item )
                    .remove()
                    .draw();
                    oTable.columns.adjust().draw();
                    toastr.success("Registro suprimido");
                }

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
            type: "get",
            dataType: "json",
        })

    },

    getDocAll: function (_data) {

        return $.ajax({
            url: _data.url + "/indexGetFirst",
            type: "GET",
            dataType: "json"
        });

    },

    getDocId: function (_data) {

        return $.ajax({
            url: _data.url,
            type: 'GET',
            headers: { 'X-CSRF-TOKEN': $('#newDocument #_token').val() },
            cache: false,
            dataType: 'json'
        })
    },

    getPdf: function (url) {

        return $.ajax({
            url: url,
            type: 'GET',
            headers: { 'X-CSRF-TOKEN': $('#newDocument #_token').val() },
            cache: false,
            dataType: "json",
            success: function (response) {
                var json = $.parseJSON(response);
                $("#pdfsrc").attr("src", 'data:application/pdf;base64,' + json.data);
            }
        })

    },

    postDoc: function (_data) {

        return $.ajax({
            url: _data.url,
            headers: { 'X-CSRF-TOKEN': $('#newDocument #_token').val() },
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            data: _data.values,
        })

    },

    editDoc: function (_data) {

        return $.ajax({
            url: _data.url,
            type: 'POST',
          	headers: {
              'X-CSRF-TOKEN': $('#editDocument #_token').val(),
               "Content-Type": "multipart/form-data",
               "X-http-Method-Override":"PUT",
            },
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            data: _data.values
        })

    },

    deleteDoc: function (_data) {
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

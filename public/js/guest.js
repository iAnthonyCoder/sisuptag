// $(document).ready(function () {

//     $(document).find(".modulos-dropdown").removeClass("hide");

//     var idioma = {
//         "sProcessing": "Procesando...",
//         "sZeroRecords": "No hay documentos disponibles.",
//         "sEmptyTable": "No hay documentos disponibles.",
//         "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
//         "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
//         "sSearch": "Buscar:",
//         "paginate": {
//             "first": "Primera",
//             "last": "Ultima",
//             "next": "Siguiente",
//             "previous": "Anterior"
//         },
//     };

//     function createDataTable() {
//         var oTable = $('.main-table').DataTable({
//             "paging": true,
//             "pageLength": 10,
//             "lengthChange": false,
//             "fixedHeader": true,
//             'searching': true,
//             "language": idioma,
//             "processing": true,
//             "scrollX": true,
//             'info': false,
//             'ordering': true,
//             "order": [[0, "asc"]],
//             'responsive': true,

//         })
//         $('#searcher').keyup(function () {
//             oTable.search($(this).val()).draw();
//         })
//     };

//     var url = window.location.href;

//     if (url.substr(url.indexOf("?"), 1) == "?") {
//         var mod = url.substr(url.indexOf("?") + 1, 3);
//         listdata(mod);
//     }
//     else {

//         var _indexGetFirstPublic = _request.indexGetFirstPublic({ url: $('#_url').val() });

//         $(".nav").addClass("noclick");
//         loadingProgresiveRing(true);

//         $.when(_indexGetFirstPublic)
//             .done(function (data) {

//                 if (data.length != 0) {

//                     var _dataDocumentos = data.documentos;

//                     if (_dataDocumentos.length > 0) {
//                         $(".card-title").text(_dataDocumentos[0].nombre);
//                     }

//                     render(_dataDocumentos);
//                     createDataTable();
//                 }

//             })
//             .always(function () {
//                 loadingProgresiveRing(false);
//                 $(".nav").removeClass("noclick");
//             });
//     }

//     function listdata(id) {

//         var _listdata = _request.listdata({ url: $('#_urldoc').val() + "/" + id });

//         $(".nav").addClass("noclick");
//         loadingProgresiveRing(true);

//         $.when(_listdata)
//             .done(function (data) {

//                 render(data);
//                 createDataTable();

//             })
//             .always(function () {
//                 loadingProgresiveRing(false);
//                 $(".nav").removeClass("noclick");
//             })

//     }

//     $('#table tbody').empty();

//     $(document).on("click", ".nav-link", function (e) {
//         e.preventDefault();
//         $(document).find(".card-title").text($(this).text());
//         $(".nav-link").parent().removeClass("active");
//         $(this).parent().addClass("active");
//         $(".main-table").DataTable().clear().destroy();
//         listdata($(this).data("id"));
//         $(document).find(".controller-section").addClass("hidden");
//         $(document).find(".indexDocument-section").removeClass("hidden");
//     })

// })


// // RENDER DATA VIEW
// function render(_data) {

//     if (_data.length > 0) {
//         $("#headerTab").html("");
//         var header1 = '<th id="row1">CÓDIGO/NRO</th>';
//         var header2 = '<th id="row2">TIPO</th>';
//         var header3 = '<th id="row3">FECHA DE PUBLICACIÓN</th>';
//         var header4 = '<th id="row4">DESCRIPCIÓN</th>';
//         var header5 = '<th id="">ACCIONES</th>';
//         _data[0].row1 == 0 ? $("#row1").remove() : $("#headerTab").append(header1);
//         _data[0].row2 == 0 ? $("#row2").remove() : $("#headerTab").append(header2);
//         _data[0].row3 == 0 ? $("#row2").remove() : $("#headerTab").append(header3);
//         _data[0].row4 == 0 ? $("#row2").remove() : $("#headerTab").append(header4);

//         $("#headerTab").append(header5);
//     }

//     $.each(_data, function (key, document) {
//         addItem(document);
//     });

// }

// // ADD ITEM
// function addItem(document) {

//     urlgenerate = $('#_url').val() + "/generatePdf/" + document.id;

//     var table = "";
//     var tableStart = '<tr id="id_' + document.id + '" data-id="' + document.id + '">';
//     var tableRow1 = document.row1 == 0 ? "" : '<td class="item_codigo" data-label="codigo" class="">' + document.codigo + '</td>';
//     var tableRow2 = document.row2 == 0 ? "" : '<td class="item_tipo" data-label="tipo" >' + document.tipo + '</td>';
//     var tableRow3 = document.row3 == 0 ? "" : '<td data-label="fecha"  class="item_fecha">' + document.fecha + '</td>';
//     var tableRow4 = document.row4 == 0 ? "" : '<td data-label="description" class="item_descripcion">' + document.description + '</td>';
//     var tableActions = '<td data-label="actions"  class=""><button type="button" onclick="window.open(\'' + urlgenerate + '\',\'_blank\'); return false;" class="btn btn-info" title="Mostrar" ><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> Descargar</td>';
//     var tableEnd = '</tr>';

//     table = tableStart + tableRow1 + tableRow2 + tableRow3 + tableRow4 + tableActions + tableEnd;

//     table = $(table);
//     $('.main-tbody-table').append(table);
//     // tableScrollBottom();
// }

// var _request = {

//     indexGetFirstPublic: function (_data) {

//         return $.ajax({
//             url: _data.url,
//             type: "GET",
//             dataType: "json"
//         })

//     },

//     listdata: function (_data) {

//         return $.ajax({
//             url: _data.url,
//             type: "GET",
//             dataType: "json"
//         })

//     }

// }


$(document).ready(function(){


    var columns = [
        { title: "CÓDIGO" },
        { title: "TIPO" },
        { title: "FECHA" },
        { title: "DESCRIPCIÓN" },
        { title: "ACCIONES" },
    ]


    $(document).find(".modulos-dropdown").removeClass("hide");


      var idioma={
          "sProcessing":     "Procesando...",
          "sZeroRecords":    "No hay documentos disponibles.",
          "sEmptyTable":     "No hay documentos disponibles.",
          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
          "sSearch":         "Buscar:",
          "paginate": {
            "first":      "Primera",
            "last":       "Ultima",
            "next":       "Siguiente",
            "previous":   "Anterior"
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
            columns: columns
            // "columns":[["as"],[0,"asd"],["ID"],["asd"],["ID"]]

        })

          $('#searcher').keyup(function(){
              oTable.search($(this).val()).draw() ;
              })






        var url=window.location.href;

        if(url.substr(url.indexOf("?"),1)=="?")
        {
          var mod=url.substr(url.indexOf("?")+1,3);


          listdata(mod)
        }
        else{
          $(".nav").addClass("noclick");
          var url = $('#_url').val();

          $.get(url + "/indexGetFirstPublic", function (data)
          {

            var data2 = JSON.parse(data);



            if(data2.length == 0 )
            {
              $(".nav").removeClass("noclick");
            }
            else
            {

            if(data2.documentos.length>0)
            {
              $(".card-title").text(data2.documentos[0].nombre);
              
              $rows=JSON.parse(data).documentos;

              for( var i=0;i<4;i++){ var column = oTable.column(i);column.visible(true);}

if($rows[0].row1==0){var column = oTable.column(0);column.visible( false );}
if($rows[0].row2==0){var column = oTable.column(1);column.visible( false );}
if($rows[0].row3==0){var column = oTable.column(2);column.visible( false );}
if($rows[0].row4==0){var column = oTable.column(3);column.visible( false );}

              
            }


              



              var a=JSON.parse(data);

            $.each(a.documentos,function(key, document)
            {

              addItem(document);
            });

            $(".nav").removeClass("noclick");
            oTable.columns.adjust().draw();
          }
        }).fail(function(err, status) {
          $(".nav").removeClass("noclick");
       });
      }















        function listdata(id)
        {

          $(".nav").addClass("noclick");
          var url = $('#_urldoc').val();
          $id=id;
          $.get(url + "/" + id, function (data)
          {
            $rows=JSON.parse(data);

            
 
if ($rows.length>0){
                var column = oTable.column(0);column.visible(true);
            var column = oTable.column(1);column.visible(true);
            var column = oTable.column(2);column.visible(true);
            var column = oTable.column(3);column.visible(true);


if($rows[0].row1==0){var column = oTable.column(0);column.visible( false );}
if($rows[0].row2==0){var column = oTable.column(1);column.visible( false );}
if($rows[0].row3==0){var column = oTable.column(2);column.visible( false );}
if($rows[0].row4==0){var column = oTable.column(3);column.visible( false );}
            };
            if($rows.length==0){
                $(".nav").removeClass("noclick");
            };

//             if($rows.length>0){
//               $("#headerTab").html("");
//               var header1='<th id="row1">CÓDIGO/NRO</th>';
//               var header2='<th id="row2">TIPO</th>';
//               var header3='<th id="row3">FECHA DE PUBLICACIÓN</th>';
//               var header4='<th id="row4">DESCRIPCIÓN</th>';
//               var header5='<th id="">ACCIONES</th>';
//             //    if($rows[0].row1==0){$("#row1").remove();}else{$("#headerTab").append(header1);}
//             //    if($rows[0].row2==0){$("#row2").remove();}else{$("#headerTab").append(header2);}
//             //    if($rows[0].row3==0){$("#row3").remove();}else{$("#headerTab").append(header3);}
//             //    if($rows[0].row4==0){$("#row4").remove();}else{$("#headerTab").append(header4);}
//             $("#headerTab").append(header1);
// $("#headerTab").append(header2);
// $("#headerTab").append(header3);
// $("#headerTab").append(header4);
//               $("#headerTab").append(header5);
//             }
            

            $.each(JSON.parse(data),function(key, document)
            {
              addItem(document);
            });

            $(".nav").removeClass("noclick");
            oTable.columns.adjust().draw();
        });

      }







      $('#table tbody').empty();

      function addItem(document){
        var table="";
        var tableStart = "";
        var tableEnd = "";
        var tableRow1 = "";
        var tableRow2 = "";
        var tableRow3 = "";
        var tableRow4 = "";
        var tableActions = "";
        urlgenerate=$('#_url').val()+"/generatePdf/"+document.id;
        var button='<button type="button" onclick="window.open(\''+urlgenerate+'\',\'_blank\'); return false;" class="btn btn-info" title="Mostrar" ><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> Descargar';
        if(document.fecha==null||document.fecha=="0000-00-00"||document.fecha=="")
      {
        document.fecha="";
      }
      if(document.codigo==null||document.codigo==0)
      {
        document.codigo="";

      }





        _templateHtml=[
            document.codigo,
            document.tipo,
            document.fecha,
            document.description,
            button,
        ];

        // tableStart = '<tr id="id_'+document.id+'" data-id="'+document.id+'">';
        // tableRow1 =  '<td class="item_codigo" data-label="codigo" class="">' +document.codigo+'</td>';
        // tableRow2 =  '<td class="item_tipo" data-label="tipo" >'+document.tipo+'</td>';
        // tableRow3 =  '<td data-label="fecha"  class="item_fecha">' +document.fecha+'</td>';
        // tableRow4 =  '<td data-label="description" class="item_descripcion">' +document.description+'</td>';
        // tableActions = '<td data-label="actions"  class=""><button type="button" onclick="window.open(\''+urlgenerate+'\',\'_blank\'); return false;" class="btn btn-info" title="Mostrar" ><span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> Descargar</td>';
        // tableEnd = '</tr>';

        // if(document.row1==0)
        // {
        //     _templateHtml[1]="";
        // }
        // if(document.row2==0)
        // {
        //     _templateHtml[2]="";
        // }
        // if(document.row3==0)
        // {
        //     _templateHtml[3]="";
        // }
        // if(document.row4==0)
        // {
        //     _templateHtml[4]="";
        // }




        oTable.row.add( _templateHtml ).node().id = 'id_'+document.id+'';
        oTable.draw( false );
        // tableScrollBottom();
      }










        $(document).on("click",".nav-link",function(e){
          e.preventDefault();
          $(document).find(".card-title").text($(this).text());
          $(".nav-link").parent().removeClass("active");
          $(this).parent().addClass("active");
          oTable.clear();
          listdata($(this).data("id"));
          oTable.draw( false );
          $(document).find(".controller-section").addClass("hidden");
          $(document).find(".indexDocument-section").removeClass("hidden");
        })





  })

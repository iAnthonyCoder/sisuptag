




$(document).ready(function(){





  var url=window.location.href;
  $(document).find(".modulos-dropdown").removeClass("hide");
  if(url.substr(url.indexOf("?"),1)=="?"){

    var url=window.location.href;
    var mod=url.substr(url.indexOf("?")+1,3);
    var modint = parseInt(mod, 10);



  }

  else if(url.substr(url.indexOf("documentos#"),11)=="documentos#")
        {

            modint = parseInt(url.substr(url.indexOf("documentos#")+11,url.length), 10);
        }
    $.get($("#_urlf").val() + "/lista" , function (data)
    {


      var datos=JSON.parse(data);
      var options="";
      $.each(JSON.parse(data),function(key, modulo) {

        var tableheads = {
          codigo: modulo.row1,
          tipo: modulo.row2,
          fecha: modulo.row3,
          descripcion: modulo.row4
        };
        tableheads= encodeURIComponent(JSON.stringify(tableheads));



        var moduloidint = parseInt((modulo.id), 10);
        if(moduloidint==modint)
        {

          //$(document).find(".card-title").text(modulo.nombre);
          options+= '<li class="nav-item active"><a class="nav-link "  data-tableheads="'+tableheads+'" data-id="'+modulo.id+'" href="#'+modulo.id+'">'+modulo.nombre+'</span></a></li>';

        }
        else{
          options+= '<li class="nav-item "><a class="nav-link"  data-tableheads="'+tableheads+'" data-id="'+modulo.id+'" href="#'+modulo.id+'">'+modulo.nombre+'</span></a></li>'

        }

      });






      $(document).find(".navbar-modulos").html(options);
      if(url.substr(url.indexOf("documentos"),10)=="documentos")
      {



        var selectopt="<option value=''>Seleccione</option>";
        $.each(JSON.parse(data),function(key, modulo) {
          selectopt+= '<option value="'+modulo.id+'">'+modulo.nombre+'</option>';
        });

        $(document).find("#newDocument #modulos_id").html(selectopt);
        $(document).find("#editDocument #modulos_id").html(selectopt);

      }

      else
      {
        if (window.location.href.indexOf('?') <1)
        {
          $("#bs-example-navbar-collapse-1 > ul.nav.navbar-nav.navbar-modulos > li:nth-child(1)").addClass("active");}
      }




      //$(document).find(".card-title-ch").text($("#bs-example-navbar-collapse-1 > ul.nav.navbar-nav.navbar-modulos > li:nth-child(1) > a").text());

    });
});


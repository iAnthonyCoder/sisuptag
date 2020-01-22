
@extends('layout.app')
@section('title', 'Documentos')
@section('content')

@push('scripts')


    <script src="{{asset('js/documentos.js')}}"></script>
    <script src="{{asset('js/navbar.js')}}"></script>
@endpush
@include("layout.navbar");
<div class="container">
<input type="hidden" id="_token" value="{{ csrf_token() }}">
<input type="hidden" id="_urldoc" value="{{ url('documentos/lista') }}">



<div class=" controller-section">

    <div class="card">
        <div class="card-header">


        <div class="row"><div class="col-md-10">
            <h4 class="card-title card-title-ch" data-title="Documentos"><span class="glyphicon glyphicon-file"></span>
                <input type="hidden" id="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="_urlusers" value="{{ url('users') }}">
            Documentos </h4>
          </div>





          <div class="col-md-2 ">

            <div class="btn-group pull-right" role="group" aria-label="...">
              <button type="button" class="btn control-button btn-default new-doc-container-trigger"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
              <button type="button" class="btn control-button btn-default index-doc-container-trigger active" ><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></button>
              <button type="button" class="btn control-button btn-default edit-doc-container-trigger disabled" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
            </div>


        </div>
      </div>
      </div>
      <div class="card-body indexDocument-section">

        <table class="table table-bordered table-hover table-responsive wrap table-striped display dt-responsive main-table" style="width:100%"  id="tableDocuments" cellspacing="0">
                <thead>
                   <tr>
                    <th>ID</th>
                    <th>CÓDIGO/NRO</th>
                    <th>TIPO</th>
                    <th>PUBLICADO</th>
                    <th>DESCRIPCIÓN</th>
                    <th>PUBLICADO POR</th>
                    <th>ACCIONES</th>
                  </tr>
                </thead>
                <tbody class="main-tbody-table" id="table-tbody"></tbody>
              </table>

</div><div class="card-body editDocument-section hidden">

<br>
    <form id="editDocument" class="form-horizontal" enctype="multipart/form-data">

      <input type="hidden" id="_token" value="{{ csrf_token() }}">
      <input type="hidden" id="_url" value="{{ url('documentos') }}">
      <input type="hidden" id="edit_id" name="id" required>
      <input type="hidden" id="row_id" name="row_id" required>
      <input type="hidden" id="dirlocalact" name="dirlocalact" required>
      <input type="hidden" od="typeSend" name="_method" value="PUT">

      <div class="form-group" id="moduloInputGroup">
        <label for="enabled" class="col-sm-2 control-label">Modulo</label>
        <div class="col-sm-6">
            <select class="form-control" id="modulos_id" name="modulos_id" required>

              </select>


    </div>
  </div>



      <div class="form-group">
          <label for="codigo" class="col-sm-2 control-label">Código</label>
          <div class="col-sm-6">
              <input type="text" class="form-control" id="codigo" name="codigo">
          </div>
        </div>

        <div class="form-group">
            <label for="codigo" class="col-sm-2 control-label">Tipo</label>
            <div class="col-sm-6">
              <select class="form-control" id="tipo" name="tipo">
                <option selected value="">SELECCIONE</option>
                <option value="1">ORDINARIA</option>
                <option value="2">EXTRAORDINARIA</option>
              </select>
            </div>
          </div>


          <div class="form-group">
              <label for="fecha" class="col-sm-2 control-label">Fecha</label>
              <div class="col-sm-6">
                  <input type="date" id="fecha" class="form-control" name="fecha" >
              </div>
            </div>

            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Descripción</label>
                <div class="col-sm-6">
                    <textarea class="form-control" rows="3" maxlength="200" id="description" name="description"></textarea>
                </div>
              </div>

              {{-- <div class="form-group">
                  <label for="description" class="col-sm-2 control-label">Documento actual:</label>
                  <div class="col-sm-6">
                      <p class="form-control"> <a id="actfile" href="" target="_blank"></a></p>
                  </div>
                </div> --}}

                <div class="form-group">
                    <label for="description" class="col-sm-2 control-label">Nuevo documento:</label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" id="dirlocal" type="file" accept="application/pdf" name="dirlocal">
                        <p>(dejar vacio si no necesita actualizarse)<br>
                    </div>
                  </div>


    <br>
<hr>

      <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit"  class="btn btn-primary submit_button" data-loading-text="Loading..."><span class="glyphicon glyphicon-pencil"></span> Guardar Cambios</button>
        <button type="button" class="btn btn-default reset_button"><span class="glyphicon glyphicon glyphicon-erase"></span> Resetear</button>
        <button type="button" class="btn btn-danger cancel_button"><span class="glyphicon glyphicon glyphicon-remove"></span> Cancelar</button>
      </div>
  </div>
  </form>
    </div>


    <div class="card-body createDocument-section hidden">

     <br>

<form id="newDocument" class="form-horizontal" enctype="multipart/form-data">

    <input type="hidden" id="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="_url" value="{{ url('documentos') }}">


    <div class="form-group">
      <label for="enabled" class="col-sm-2 control-label">Modulo</label>
      <div class="col-sm-6">
          <select class="form-control" id="modulos_id" name="modulos_id" required>

            </select>


  </div>
</div>

    <div class="form-group">
        <label for="codigo" class="col-sm-2 control-label">Código</label>
        <div class="col-sm-6">
            <input type="number" class="onlyNumber form-control" id="codigo" name="codigo"  >
        </div>
      </div>

      <div class="form-group">
          <label for="codigo" class="col-sm-2 onlyNumber control-label" >Tipo</label>
          <div class="col-sm-6">
            <select class="form-control" id="tipo" name="tipo">
              <option selected value="">SELECCIONE</option>
              <option value="1">ORDINARIA</option>
              <option value="2">EXTRAORDINARIA</option>
            </select>
          </div>
        </div>


        <div class="form-group">
            <label for="fecha" class="col-sm-2 control-label">Fecha</label>
            <div class="col-sm-6">
                <input type="date" id="fecha" class="form-control" name="fecha" >
            </div>
          </div>

          <div class="form-group">
              <label for="description" class="col-sm-2 control-label">Descripción</label>
              <div class="col-sm-6">
                  <textarea class="form-control" rows="3" maxlength="200" id="description" name="description" ></textarea>
              </div>
            </div>



              <div class="form-group">
                  <label for="description" class="col-sm-2 control-label">Nuevo documento:</label>
                  <div class="col-sm-6">
                      <input type="file" class="form-control" id="dirlocal" type="file" accept="application/pdf" name="dirlocal" required>
                      <p>(Dejar vacio si no necesita actualizarse)</p><br>
                  </div>
                </div>


    <br><hr>


    <div class="form-group">
  <div class="col-sm-offset-2 col-sm-10">
    <button type="submit" class="btn btn-primary submit_button" data-loading-text="Loading..."><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
    <button type="button" class="btn btn-default reset_button"><span class="glyphicon glyphicon glyphicon-erase"></span> Resetear</button>
    <button type="button" class="btn btn-danger cancel_button"><span class="glyphicon glyphicon glyphicon-remove"></span> Cancelar</button>
  </div>
</div>
</form>
</div>


</div></div>




</div>

@endsection

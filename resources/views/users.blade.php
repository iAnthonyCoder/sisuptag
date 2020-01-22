@extends('layout.app')
@section('title', 'Usuarios')
@section('content')
@push('scripts')
    <script src="{{asset('js/users.js')}}"></script>
@endpush
@include("layout.navbar")
<div class="container">

<input type="hidden" id="_urldoc" value="{{ url('users/lista') }}">
<input type="hidden" id="_urlmodlist" value="{{ url('modulos/lista') }}">




<div class=" controller-section ">

    <div class="card">
      <div class="card-header">
        <div class="row"><div class="col-md-10">
            <h4 class="card-title"><span class="glyphicon glyphicon-user"></span> Usuarios</h4>
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
                    <th>NOMBRE</th>
                    <th>EMAIL</th>
                    <th>TIPO</th>
                    <th>MODULO</th>
                    <th>ESTADO</th>
                    <th>DOCS</th>
                    <th>ACCIONES</th>
                  </tr>
                </thead>
                <tbody class="main-tbody-table" id="table-tbody"></tbody>
              </table>

</div>


<div class="card-body createDocument-section hidden">
    <br>

<form id="newDocument" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" id="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="_url" value="{{ url('users') }}">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Nombre</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="name" name="name" onkeyup="this.value=this.value.replace(/[^a-zA-Z]/g,'');" maxlength="50" required>
        </div>
      </div>

      <div class="form-group">
          <label for="email" class="col-sm-2 control-label">Email</label>
          <div class="col-sm-6">
              <input type="email" class="form-control" id="email" name="email" maxlength="50" required>
          </div>
        </div>
        <div class="form-group">
            <label for="id_admin" class="col-sm-2 control-label">Tipo</label>
            <div class="col-sm-6">
                <select class="form-control moduloSelectTrigger" id="id_admin" name="is_admin" required>
                    <option value="">SELECCIONE</option>
                    <option value="0">MIEMBRO</option>
                    <option value="1">ADMINISTRADOR</option>
                  </select>

            </div>
          </div>
          <div class="form-group">
            <label for="enabled" class="col-sm-2 control-label">Estado</label>
            <div class="col-sm-6">
                <select class="form-control" id="enabled" name="enabled" required>
                    <option value="">SELECCIONE</option>
                    <option value="0">SUSPENDIDO</option>
                    <option value="1">HABILITADO</option>
                  </select>


        </div>
      </div>
      <div class="form-group">
        <label for="modulos_id" class="col-sm-2 control-label">Modulo</label>
        <div class="col-sm-6">
            <select class="form-control" id="modulos_id_u" name="modulos_id_u">
                <option value="">SELECCIONE</option>
              </select>
        </div>
      </div>

          <br><hr>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit"  class="btn btn-primary submit_button" data-loading-text="Loading..."><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
          <button type="button" class="btn btn-default reset_button"><span class="glyphicon glyphicon glyphicon-erase"></span> Resetear</button>
          <button type="button" class="btn btn-danger cancel_button"><span class="glyphicon glyphicon glyphicon-remove"></span> Cancelar</button>

        </div>
      </div>
</form>


</div>


<div class="card-body editDocument-section hidden">

<br><br>
    <form id="editDocument" class="form-horizontal" enctype="multipart/form-data">
      <input type="hidden" id="_token" value="{{ csrf_token() }}">
      <input type="hidden" id="_url" value="{{ url('users') }}">
      <input type="hidden" id="edit_id" name="id" required>
      <input type="hidden" id="row_id" name="row_id" required>


      <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Nombre</label>
        <div class="col-sm-6">
            <input type="text" class="form-control" id="name" name="name" onkeyup="this.value=this.value.replace(/[^a-zA-Z]/g,'');" maxlength="50" required>
        </div>
      </div>

      <div class="form-group">
          <label for="email" class="col-sm-2 control-label">Email</label>
          <div class="col-sm-6">
              <input type="email" class="form-control" id="email" name="email" maxlength="50" required>
          </div>
        </div>
        <div class="form-group">
            <label for="id_admin" class="col-sm-2 control-label">Tipo</label>
            <div class="col-sm-6">
                <select class="form-control moduloSelectTrigger" id="id_admin" name="is_admin" required>
                    <option value="">SELECCIONE</option>
                    <option value="0">MIEMBRO</option>
                    <option value="1">ADMINISTRADOR</option>
                  </select>

            </div>
          </div>


          <div class="form-group">
            <label for="enabled" class="col-sm-2 control-label">Estado</label>
            <div class="col-sm-6">
                <select class="form-control" id="enabled" name="enabled" required>
                    <option value="">SELECCIONE</option>
                    <option value="0">SUSPENDIDO</option>
                    <option value="1">HABILITADO</option>
                  </select>


        </div>
      </div>
      <div class="form-group">
        <label for="modulos_id" class="col-sm-2 control-label">Modulo</label>
        <div class="col-sm-6">
            <select class="form-control" id="modulos_id_u" name="modulos_id_u">
                <option value="">SELECCIONE</option>
              </select>
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
</div></div>



</div>
@endsection

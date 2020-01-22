@extends('layout.app')
@section('title', 'Puntos de restauración')
@section('content')
@push('scripts')
    <script src="{{asset('js/restores.js')}}"></script>
@endpush


<input type="hidden" id="_token" value="{{ csrf_token() }}">
<input type="hidden" id="_urldoc" value="{{ url('restores/lista') }}">




@include("layout.navbar")
<div class="container">

<div class=" controller-section ">
  
  <div class="card">
    <div class="card-header">
      <div class="row"><div class="col-md-10">
          <h4 class="card-title"><span class="glyphicon glyphicon-folder-open"></span> Puntos de restauración</h4>
      </div>
      <div class="col-md-2 ">

        <div class="btn-group pull-right" role="group" aria-label="...">
          <button type="button" class="btn control-button btn-default new-doc-container-trigger"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
          <button type="" class="btn control-button btn-default index-doc-container-trigger active" ><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></button>
          <button type="" class="btn control-button btn-default edit-doc-container-trigger disabled" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
        </div>


    </div>
  </div>
  </div>
  <div class="card-body indexDocument-section">

        <table class="table table-bordered table-hover table-responsive wrap table-striped display dt-responsive main-table" style="width:100%"  id="tableDocuments" cellspacing="0">
                <thead>
                   <tr>
                    <th>ID</th>
                    <th>DESCRIPCIÓN</th>
                    <th>FECHA</th>
                    {{-- <th>TAMAÑO</th> --}}
                    <th>ACCIONES</th>
                  </tr>
                </thead>
                <tbody class="main-tbody-table" id="table-tbody"></tbody>
              </table>
      
</div> <div class="card-body editDocument-section hidden">
    

    <form class="form-horizontal" id="editDocument">
<br>
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_url" value="{{ url('restores') }}">
        <input type="hidden" id="row_id" name="row_id" required>
        <input type="hidden" id="edit_id" name="id" required>
      
          <div class="form-group">
              <label for="description" class="col-sm-2 control-label">Descripción</label>
              <div class="col-sm-6">
                  <textarea class="form-control" rows="3" maxlength="120" id="description" name="description"></textarea>
              </div>
            </div><br>
            <hr>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                    <button type="submit"  class="btn btn-default submit_button" data-loading-text="Loading..."><span class="glyphicon glyphicon-pencil"></span> Guardar Cambios</button>
                </div>
              </div>
      
    </form>
    </div>
<div class="card-body createDocument-section hidden">

    
    <br>
    <form id="newDocument" class="form-horizontal" enctype="multipart/form-data">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_url" value="{{ url('restores') }}">
  
          <div class="form-group">
              <label for="description" class="col-sm-2 control-label">Descripción</label>
              <div class="col-sm-6">
                  <textarea class="form-control" rows="3" maxlength="120" id="description" name="description"></textarea>
              </div>
            </div>
            <br><hr>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-6">
                  <button type="submit" class="submit_button btn btn-primary"  data-loading-text="Loading..."><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                  <button type="button" class="btn btn-default reset_button"><span class="glyphicon glyphicon glyphicon-erase"></span> Resetear</button>
                  <button type="button" class="btn btn-danger cancel_button"><span class="glyphicon glyphicon glyphicon-remove"></span> Cancelar</button>
                </div>
              </div>
        
    </form>
    </div>
</div></div>



</div>




@endsection
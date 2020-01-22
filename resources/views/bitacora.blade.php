@extends('layout.app')
@section('title', 'Bitacora')
@section('content')

@push('scripts')
    
   
    <script src="{{asset('js/bitacora.js')}}"></script>
   
@endpush
@include("layout.navbar");
<div class="container">
<input type="hidden" id="_token" value="{{ csrf_token() }}">
<input type="hidden" id="_urldoc" value="{{ url('bitacora/lista') }}">


<div class=" controller-section ">
  
  <div class="card">
    <div class="card-header">
      <div class="row"><div class="col-md-10">
          <h4 class="card-title"><span class="glyphicon glyphicon-console"></span> Actividad</h4>
      </div>
      <div class="col-md-2 ">

        <div class="btn-group pull-right" role="group" aria-label="...">
      <button type="button" class="btn control-button btn-default index-doc-container-trigger active" ><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></button>
</div>


    </div>
  </div>
  </div>
  <div class="card-body indexDocument-section">


    <table class="table table-bordered table-hover table-responsive wrap table-striped display dt-responsive main-table" style="width:100%"  id="tableDocuments" cellspacing="0">
      <thead>
                 <tr>
                
                  <th>FECHA</th>
                  <th>RESPONSABLE</th>
                  <th>ACCIÓN</th>
                  <th>TABLA</th>
                  <th>DESCRIPCIÓN</th>
                </tr>
              </thead>
              <tbody class="main-tbody-table" id="table-tbody"></tbody>
            </table>
    
</div>



</div></div>



</div>
@endsection

 



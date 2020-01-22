@extends('layout.app')
@section('title', 'Usuarios')
@section('content')
@push('scripts')
    <script src="{{asset('js/logs.js')}}"></script>
@endpush
@include("layout.navbar")
<div class="container">

<input type="hidden" id="_urldoc" value="{{ url('logs/lista') }}">





<div class=" controller-section ">
  
    <div class="card">
      <div class="card-header">
        <div class="row"><div class="col-md-10">
            <h4 class="card-title"><span class="glyphicon glyphicon-console"></span> Logs</h4>
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
                    <th>USUARIO</th>
                    <th>SISTEMA</th>
                    <th>IP</th>
                    <th>FECHA</th>
                  <!--  <th>LOG OUT</th>-->
                  </tr>
                </thead>
                <tbody class="main-tbody-table" id="table-tbody"></tbody>
              </table>
      
</div>



</div></div>



</div>
@endsection
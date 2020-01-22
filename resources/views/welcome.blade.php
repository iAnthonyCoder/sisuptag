@extends('layout.app')
@section('title', 'Home')
@section('content')
@push('scripts')


    <script src="{{asset('js/guest.js')}}"></script>

    <script src="{{asset('js/navbar.js')}}"></script>
@endpush
<input type="hidden" id="_token" value="{{ csrf_token() }}">
<input type="hidden" id="_urldoc" value="{{ url('documentos/listaPublica') }}">
<input type="hidden" id="_url" value="{{ url('documentos') }}">
@include("layout/navbar")

<div class="container">



<div class=" controller-section indexDocument-section">
    <div class="card">
        <div class="card-header">
          <div class="row"><div class="col-md-10">
              <h4 class="card-title">Documentos</h4>
          </div>
          <div class="col-md-2 ">




        </div>
      </div>
      </div>
      <div class="card-body indexDocument-section">

        <table class="table table-bordered table-hover table-responsive wrap table-striped display dt-responsive main-table" style="width:100%"  id="tableDocuments" cellspacing="0">
                {{-- <thead>
                   <tr id="headerTab">

                      <th id="row1">CÓDIGO/NRO</th>
                      <th id="row2">TIPO</th>
                      <th id="row3">FECHA</th>
                      <th id="row4">DESCRIPCIÓN</th>
                      <th id="">ACCIONES</th>
                  </tr>
                </thead>
                <tbody class="main-tbody-table" id="table-tbody"></tbody> --}}
              </table>

</div></div></div></div>
@endsection

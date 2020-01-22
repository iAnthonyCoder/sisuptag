@extends('layout.app')
@include('layout/navbar')
@section('content')
@section('title', 'Recuperar cuenta')
<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="card">
              
                    <div class="card-header"><h4>Reestablecer contraseña</h4></div>



              
                        

               
              


                    <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
<br>
                    <form method="POST" class="form-horizontal" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">{{ __('E-Mail Address') }}</label>

                            <div class="col-sm-7">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <br>
                        <hr>
                        <div class="form-group ">
                                <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Enviar instrucciones') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

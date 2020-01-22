@extends('layout.app')
@push('scripts')
@section('title', 'Recuperar cuenta')

    <script src="{{asset('js/captcha.js')}}"></script>
@endpush
@section('content')
@include("layout/navbar");
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-header"><h4>Reestablecer Contraseña</h4></div>


                <div class="card-body"><br>
                    <form method="POST" class="form-horizontal" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">{{ __('E-Mail Address') }}</label>

                            <div class="col-sm-7">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>






                        <div class="form-group row">
                            <label for="password" class="col-sm-3 control-label text-md-right">{{ __('Contraseña') }}</label>

                            <div class="col-sm-7">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-sm-3 control-label text-md-right">{{ __('Confirmar contraseña') }}</label>

                            <div class="col-sm-7">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Formato</label>
                            <div class="col-sm-7">
                            <p class="">
                              <li>Al menos una letra mayuscula</li>
                              <li>Al menos una letra minuscula</li>
                              <li>Al menos un numero</li>
                              <li>Ocho caracteres</li>
                            </p></div></div>
                        <br>
<hr>
                        <div class="form-group row mb-0">
                                <div class="col-sm-offset-3 col-sm-9">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reestablecer contraseña') }}
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

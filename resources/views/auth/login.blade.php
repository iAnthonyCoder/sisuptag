@extends('layout.app')
@push('scripts')
@section('title', 'Iniciar Sesion')

    <script src="{{asset('js/captcha.js')}}"></script>
@endpush
@section('content')
@include("layout/navbar");

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="card">
                <div class="card-header row no-margin"><div class="col-sm-6"><h4 class="">Iniciar Sesión</h4></div> <div class="col-sm-6 pull-right"><button class="btn btn-default pull-right" id="refreshCaptcha" name="refresh"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
                </div></div>



              
                        

               
              


                <div class="card-body"><br>
                    @include("flash-message")
                        <form method="POST" id="login-form" class="form-horizontal" action="{{ route('login') }}">
                                @csrf
        
                                <div class="form-group">
                                        <label for="email" class="col-sm-3 control-label">{{ __('Email') }}</label>
            
                                        <div class="col-sm-7">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>
            
                                            @error('email')
                                                <input class="invalid-feedback errors-login" style="color:red" type="hidden" value="{{ $message }}" role="alert">
                                                  
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
            
        
                                    <div class="form-group">
                                            <label for="password" class="col-sm-3 control-label">{{ __('Contraseña') }}</label>
                
                                            <div class="col-sm-7">
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Cotraseña" required autocomplete="current-password">
                
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            
                                        </div>
        
                                      
                                <div class="form-group ">
                                    <input type="hidden" id="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" id="_urlcaptcha" value="{{ url('captcha') }}">
                      
                                        <label for="password" class="col-sm-3 control-label">{{ __('Antibots') }}</label>
                                        
                                        <div class="col-sm-7"><div class="row">
                                                
                                                <div class="col-sm-10">
                                                <p id="captchacontainer">{!! Captcha::img(); !!} &nbsp;</p></div>
                                                </div>
                                                <input id="captcha" class="form-control" type="text" name="captcha" placeholder="captcha" data-validation="required" >
                                    <p id="captcha-error-msg" style="color:red"></p>
                                        </div>
                                    </div>
                                    
        
                                    <div class="form-group">
                                            <label for="password" class="col-sm-3 control-label">{{ __('') }}</label>
                
                                            <div class="col-sm-7">
                                               
                
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            
                                        </div>
        
                                    
        <hr>
                                        <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Iniciar Sesión') }}
                                                    </button>
                    
                                                    @if (Route::has('password.request'))
                                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                                            {{ __('¿Olvidaste tu contraseña?') }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                            </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

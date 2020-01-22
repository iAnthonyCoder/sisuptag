@extends('layout.app')
@section('title', 'Perfil')
@section('content')
@push('scripts')
    <script src="{{asset('js/profile.js')}}"></script>
@endpush



@include("layout.navbar")
<div class="container">

<div class=" controller-section ">

  <div class="card">
    <div class="card-header">
      <div class="row"><div class="col-md-10">
          <h4 class="card-title"><span class="glyphicon glyphicon-user"></span> Perfil</h4>
      </div>
      <div class="col-md-2 ">

        <div class="btn-group pull-right" role="group" aria-label="...">
        <button type="button" class="btn control-button btn-default edit-doc-container-trigger active" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
        </div>
    </div>
  </div>
  </div>
 <div class="card-body newDocument-section">
    <form class="form-horizontal" id="newDocument">
<br>
<input type="hidden" id="_token" value="{{ csrf_token() }}">
<input type="hidden" id="_url" value="{{ url('changePassword') }}">
        <div class="form-group">
            <label for="current_password" class="col-sm-2 control-label">Contraseña actual</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="current_password" name="current_password" minlength="8" required>
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Nueva contraseña</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="password" name="password" minlength="8" required>
            </div>
          </div>
          <div class="form-group">
            <label for="new_password2" class="col-sm-2 control-label">Confirme contraseña</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="8" required>
            </div>
          </div>
          <div class="form-group">
          <label for="" class="col-sm-2 control-label">Formato</label>
          <div class="col-sm-6">
          <p class="">
            <li>Al menos una letra mayuscula</li>
            <li>Al menos una letra minuscula</li>
            <li>Al menos un numero</li>
            <li>Ocho caracteres</li>
          </p></div></div>
          <!--<div class="form-group ">

            <label for="password" class="col-sm-2 control-label">{{ __('Antibots') }}</label>
            <input type="hidden" id="_token" value="{{ csrf_token() }}">
            <input type="hidden" id="_urlcaptcha" value="{{ url('captcha') }}">

            <div class="col-sm-6"><div class="row">
                <div class="col-sm-1"><button type="button" class="btn btn-default" id="refreshCaptcha" name="refresh"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
                </div>
                    <div class="col-sm-8">
                    <p id="captchacontainer">{!! Captcha::img(); !!} &nbsp;</p></div>
                    </div>
                    <input id="captcha" class="form-control" type="text" name="captcha" placeholder="captcha" data-validation="required" >
        <p id="captcha-error-msg" style="color:red"></p>
            </div>
        </div>-->

          <br><hr>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
              <button type="submit" class="submit_button btn btn-primary"  data-loading-text="Loading..."><span class="glyphicon glyphicon-pencil"></span> Guardar Cambios</button>
              <button type="button" class="btn btn-default reset_button"><span class="glyphicon glyphicon glyphicon-erase"></span> Resetear</button>

            </div>
          </div>
    </form>
    </div>
</div></div>
</div>
@endsection

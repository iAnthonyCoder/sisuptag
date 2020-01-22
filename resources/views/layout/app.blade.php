<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>sisUptag - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('css/toastr.css')}}">

    @prepend("scripts")
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
    @endprepend

    @push('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="//js.pusher.com/3.1/pusher.min.js"></script> --}}
    <script src="{{asset('js/toastr.min.js')}}"></script>
    <script src="{{asset('js/toastr.min.js')}}"></script>
    <script src="{{asset('js/config.js')}}"></script>
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
    @endpush
    <title>MODULOS</title>
</head>
<body>












        @yield('content')

        <footer class="footer">
                <div class="container">
                    <div class="row">
                    <div class="col-md-6"><p class="text-muted">
                       {{-- @guest
                        <a class="" href="{{url('/home')}}">Administrador</a>
                        @endguest --}}
                        @if (\Request::is('/'))
                        <a class="" href="{{url('/home')}}">Administrador</a>
                        @else

                        <a class="" href="{{url('/')}}">Visitante</a>

                        @endif


                                </p></div>
                        <div class="col-md-6">
                          <div class="text-muted pull-right">
                 <p class="">Made with <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>&nbsp;in the UPTAG under licence <a href="HTTPS://WWW.SAFECREATIVE.ORG/WORK/1906161180782" title='Licencia CC'><strong> CC by-nc 4.0</strong></a></p>


                </div>
                </div>
                </div></div>
              </footer>
    @stack('scripts')





    <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Confirmar eliminación</h4>
                </div>
                <div class="modal-body">
                  <h5><strong>Esta a punto de eliminar el siguiente registro:</strong></h5>

                  <strong>Clase:</strong><p id="modalDataType"></p>
                  <strong>ID:</strong><p id="modalDataName"></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="button" class="btn btn-danger deleteUp" data-loading-text="Loading..." autocomplete="off" data-dismiss="modal">Eliminar</button>
                </div>
              </div>
            </div>
          </div>







            <!-- Modal -->
            <div class="modal" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">RESTAURACIÓN DE BASE DE DATOS</h4>
                  </div>
                  <div class="modal-body">
                    Esta a punto de restaurar su base de datos a un estado anterior, esta acción no podra ser deshecha.<br><br>

                    <strong id="dcbu">Descripción del estado anterior:</strong><p id="dcbuContent"></p> <br>
                    <strong id="dcbu">Fecha:</strong><p id="datebu"></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

                    <a type="button" id="restoreLink" class="btn btn-danger">Restaurar</a>
                  </div>
                </div>
              </div>
            </div>

</body>
<script>
    loadingProgresiveRing(true);
    window.onload = function()
    {
        loadingProgresiveRing(false);
    }





    // const pusher = new Pusher('a763ad9f8293374630a2', {
    //   cluster: 'us2',
    //   encrypted: true,

    // });

// // Echo.channel('modulos')
    // // .listen('.newModulo', function (event) {
    // //     alert(event.message);
    // // })


    // //   Echo.private(`App.User.+${Laravel.iduser}`)
    // //   .notification((notification) => {
    // //      console.log(notification);
    // //  });










    // const channel = pusher.subscribe('modulos');
    // channel.bind('newModulo', data => {
    //     alert(data.message);
    // });



    // const subscribe = document.getElementById('subscribe');
    // subscribe.addEventListener('click', event => {
    //   grantPermission();
    //   subscribe.parentNode.removeChild(subscribe);
    // });



    </script>
</html>

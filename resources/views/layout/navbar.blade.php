{{-- @if(\Request::is('/'))

    {{route('home')}}
@endif --}}
@if(!auth()->guest())
        <script>
            window.Laravel = {!! json_encode(["iduser"=>Auth::user()->id, "csrfToken"=> csrf_token()])  !!}
        </script>
@endif
@guest
<nav class="navbar navbar-inverse" style="border: none; border-radius: 0;">
@endguest
@if(Auth::user())
<nav class="navbar navbar-inverse" style="border: none; border-radius: 0;">
@endif

        <div class="container">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="_urlf" value="{{ url('modulos') }}">
        <div class="">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            @guest
            <a class="navbar-brand" href='/'>sisUptag</a>
            @else
            <a class="navbar-brand" href={{route('home')}}>sisUptag</a>
            @endguest
          </div>













          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">



            {{-- <ul class="nav navbar-nav navbar-modulos">
            </ul> --}}

            @guest
            <ul class="nav navbar-nav modulos-dropdown hide">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-file"></span> Modulos <span class="caret"></span></a>
                        <ul class="dropdown-menu navbar-modulos" role="menu">

                        </ul>
                      </li>
                    </ul>
            @elseif(Auth::user()->is_admin==true)

            <ul class="nav navbar-nav modulos-dropdown hide">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-file"></span> Modulos <span class="caret"></span></a>
                        <ul class="dropdown-menu navbar-modulos" role="menu">

                        </ul>
                      </li>
                    </ul>

            @elseif(Auth::user()->is_admin==false)
            {{-- <ul class="nav navbar-nav">
            <li><a href="{{ url('modulos') }}"><span class="glyphicon glyphicon-book"></span> Modulos</a></li>
            </ul> --}}
            @if (!\Request::is('documentos')&&!\Request::is('home'))
            <ul class="nav navbar-nav modulos-dropdown hide">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-file"></span> Modulos <span class="caret"></span></a>
                    <ul class="dropdown-menu navbar-modulos" role="menu">

                    </ul>
                  </li>

                </ul>

            @endif

            @endguest




            <ul class="nav navbar-nav navbar-right">




                @guest
                  @if (\Request::is('login'))
                  <li><a href="/">{{ __('Home') }}</a></li>

                  @else
                  {{-- <li><a href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a></li> --}}
                  @endif





              @else

              @if(Auth::user()->is_admin)
              <li class="dropdown">
                  @if (\Request::is('home'))
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"> </span> Configuración</a>

                @else
                <a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"> </span> Configuración</a>
               @endif
                <ul class="dropdown-menu">


                <li><a href="{{ url('documentos') }}"><span class="glyphicon glyphicon-file"></span> Documentos</a></li>

                  <li><a href="{{ url('modulos') }}"><span class="glyphicon glyphicon-book"></span> Modulos</a></li>
                  <li><a href="{{ url('users') }}"><span class="glyphicon glyphicon-user"></span> Usuarios</a></li>
                  <li role="separator" class="divider"></li>


                  <li><a href="{{ url('bitacora') }}"><span class="glyphicon glyphicon-calendar"></span> Actividad</a></li>
                  <li><a href="{{ url('logs') }}"><span class="glyphicon glyphicon-console"></span> Logs</a></li>
                  <li><a href="{{ url('restores') }}"><span class="glyphicon glyphicon-repeat"></span> Restaurar</a></li>


                </ul>
              </li>@endif

              <li class="dropdown">
                <a href="#" id="userdata" data-id={{Auth::user()->id}} data-is_admin={{Auth::user()->is_admin}} class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> {{ Auth::user()->name }} <span class="caret"></span></a>
                <ul class="dropdown-menu">
                <li><a href="{{ url('profile') }}"><span class="glyphicon glyphicon-pencil"></span> Cambiar contraseña</a></li>
                    <li><a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();
                                                        ">
                            <span class="glyphicon glyphicon-log-out"></span>{{ __(' Cerrar sesión') }}
                        </a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form></li>



                </ul>
              </li>
              @endguest
            </ul>

            <form class="navbar-form navbar-right">
              @if (\Request::is('login'))
              @else
              <div class="form-group">
                  <input type="text" id="searcher" name="search" class="form-control" placeholder="Buscar">
                </div>
              @endif


          </form>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
        </div>
      </nav>

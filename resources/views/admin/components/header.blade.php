<!-- Header -->
<header id="header">
    <div class="headerbar">
        <div class="headerbar-left">
            <ul class="header-nav header-nav-options">
                <li class="header-nav-brand" >
                    <div class="brand-holder">
                        <a href="/">
                            {{-- <img src="{{ asset('img/iconos/CroppedLogo.png') }}"  alt=""> --}}
                            <img src="{{asset('img/iconos/CroppedLogo.png')}}" width="60px" height="25px" id="welcomeLogo">
                        </a>
                    </div>
                </li>
                <li>
                    <a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);"> <i class="fa fa-bars"></i>
                </a>
            </li>
            </ul>
        </div>
        <div class="headerbar-right">
            <ul class="header-nav header-nav-profile">
                <li class="dropdown">
                    <a href="javascript:void(0);" class="dropdown-toggle ink-reaction" data-toggle="dropdown">
                        <img src="" alt="" />
                        <span class="profile-info">
                            <small>{{ Auth::user()->name }} {{ Auth::user()->last }}</small>
                        </span>
                    </a>
                    <ul class="dropdown-menu animation-dock">
                        @if(Auth::user()->rol == 'admin')
                            <li><a href="/logs"><i class="fa fa-fw fa-warning"></i>Logs</a></li>
                        @endif
                        <li class="divider"></li>
                        <li>
                            <a  onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-fw fa-power-off text-danger"></i>Cerrar sesi&oacute;n</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>
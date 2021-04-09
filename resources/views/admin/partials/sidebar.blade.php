<div class="col-6 mx-0 px-0 leftSpan" style="z-index: 1000">
    <div class="nav-side-menu">
        <div class="brand" id="admin_brand">
            <img src="{{ asset('img/iconos/CroppedLogo.png') }}" width="60px" height="25px" id="welcomeLogo">
        </div>

        <div class="menu-list" id="menu-list">
            <ul id="menu-content" class="menu-content text-center">
                <a id="instructors"><li>Instructores</li></a>
                <a id="schedules"><li>Horario</li></a>
                <a id="branches"><li>Sucursal</li></a>
                <a id="products"><li>Productos</li></a>
                <a id="users"><li>Administradores</li></a>
                <a id="operations"><li>Operaciones</li></a>
                <a id="sales"><li>Ventas</li></a>
                <a id="reports"><li>Reportes</li></a>
                <a id="all-users"><li>Clientes</li></a>
                <br style="cursor: none;">
                <br style="cursor: none;">
                <a id="logout-button">
                    <form id="logout-admin" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <li>Cerrar Sesión</li>
                </a>
            </ul>
        </div>
    </div>
</div>
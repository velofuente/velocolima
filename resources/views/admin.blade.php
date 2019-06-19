<!DOCTYPE html>
<html lang="es_mx">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{-- <link rel="shortcut icon" href="favicon.png" type="img/favicon.png"> --}}
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Vélo | Administración</title>


    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('css/admin-styles.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('css/admin-bike-grid.css')}}"> --}}
    <link rel="stylesheet" href="{{asset('css/style-bike.css')}}">
</head>
<body>

    <div class="mx-0 px-0">
        {{-- SideBar Partial Display Version --}}
        <div class="col-6 mx-0 px-0 leftSpan">
            <div class="nav-side-menu" style="z-index: 1000">
                <div class="brand">Vélo</div>
                <i class="fa fa-bars fa-2x toggle-btn active" data-toggle="collapse" data-target="#menu-content"></i>
                <div class="menu-list" id="menu-list">
                    <ul id="menu-content" class="menu-content collapse out text-center">
                        <a href="#" id="instructors">
                            <li>
                                {{-- <i class="fa fa-dashboard fa-lg"></i> --}}
                                Instructores
                            </li>
                        </a>
                        <a href="#" id="schedules">
                            <li  data-toggle="collapse" data-target="#products" class="collapsed">
                                {{-- <a href="#"><i class="fa fa-gift fa-lg"></i> UI Elements <span class="arrow"></span></a> --}}
                                {{-- <i class="fa fa-gift fa-lg"></i> --}}
                                Horario
                            </li>
                        </a>
                            {{-- <ul class="sub-menu collapse" id="products">
                                <li class="active"><a href="#">CSS3 Animation</a></li>
                                <li><a href="#">General</a></li>
                                <li><a href="#">Buttons</a></li>
                                <li><a href="#">Tabs & Accordions</a></li>
                                <li><a href="#">Typography</a></li>
                                <li><a href="#">FontAwesome</a></li>
                                <li><a href="#">Slider</a></li>
                                <li><a href="#">Panels</a></li>
                                <li><a href="#">Widgets</a></li>
                                <li><a href="#">Bootstrap Model</a></li>
                            </ul> --}}
                        <a href="#" id="branches">
                            {{-- <a href="#"><i class="fa fa-globe fa-lg"></i> Services <span class="arrow"></span></a> --}}
                            <li data-toggle="collapse" data-target="#service" class="collapsed">
                                {{-- <i class="fa fa-globe fa-lg"></i> --}}
                                Sucursal
                            </li>
                        </a>
                            {{-- <ul class="sub-menu collapse" id="service">
                                <li>New Service 1</li>
                                <li>New Service 2</li>
                                <li>New Service 3</li>
                            </ul> --}}
                        {{-- <a href="#" id="products">
                            <li data-toggle="collapse" data-target="#new" class="collapsed">
                            <a href="#"><i class="fa fa-car fa-lg"></i> New <span class="arrow"></span></a>
                                <i class="fa fa-car fa-lg"></i>
                                Producto
                            </li>
                        </a> --}}
                        <a href="#" id="products">
                            <li>
                                {{-- <i class="fa fa-user fa-lg"></i> --}}
                                Productos
                            </li>
                        </a>
                            {{-- <ul class="sub-menu collapse" id="new">
                                <li>New New 1</li>
                                <li>New New 2</li>
                                <li>New New 3</li>
                            </ul> --}}
                        <a href="#" id="users">
                            <li>
                                {{-- <i class="fa fa-user fa-lg"></i> --}}
                                Usuarios
                            </li>
                        </a>
                        <a href="#" id="clients">
                            <li>
                                {{-- <i class="fa fa-user fa-lg"></i> --}}
                                Clientes
                            </li>
                        </a>
                        <a href="#" id="operations">
                            <li>
                                {{-- <i class="fa fa-user fa-lg"></i> --}}
                                Operaciones
                            </li>
                        </a>
                        <a href="#" id="sales">
                            <li>
                                {{-- <i class="fa fa-user fa-lg"></i> --}}
                                Ventas
                            </li>
                        </a>
                        <a href="#" id="reports">
                            <li>
                                {{-- <i class="fa fa-user fa-lg"></i> --}}
                                Reportes
                            </li>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
        {{-- Where info will be displayed --}}
        <div class="col-6 mx-0 px-0 rightSpan" id="frameView">
        </div>
    </div>

    <script>
        $(document).ready(function (){
            //Variable to get the clicked link
            var pageCalled = null;
            //Obtain the id of the clicked link
            $('#menu-list a').click(function(){
                //Get the id of the link and save it to pageCalled variable
                pageCalled = this.id;
                $('#menu-list a').removeClass("active-menu");
                $(this).addClass("active-menu");
                //Call the function to display the desired page
                callPage(pageCalled);
            });

            //Function to display view depending on the clicked link
            function callPage(page){
                $.ajax({
                    url: 'admin-'+page,
                    type: 'GET',
                    cache: false,
                    beforeSend: function(){
                        $.LoadingOverlay("show");
                    },
                    success: function(result) {
                        $.LoadingOverlay("hide");
                        $('#frameView').html(result);
                    },
                    error: function(result){
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: 'Error',
                            text: 'Ocurrió un Error en la petición',
                            type: 'warning',
                            confirmButtonText: 'Aceptar'
                        })
                        // console.log(result);
                    }
                });
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
</body>
</html>
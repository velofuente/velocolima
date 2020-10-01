<!DOCTYPE html>
<html lang="es_mx">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Vélo | Administración</title>

    <link rel="shortcut icon" href="/favicon.png" type="img/favicon.png">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

    {{-- <link rel="stylesheet" href="{{ asset('css/layout-styles.css?v=1.1') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style-bike.css') }}">

    @yield('extra_styles')
</head>
<body>
    <div class="mx-0 px-0">
        <div class="font-img" style="width: 100%; margin: 0px auto; margin-left: 400px; position: fixed; height: 100%; opacity: 0.2;">
            <img src="/img/iconos/LOGO.png" style="width: 70%;margin: 0px auto;">
        </div>

        {{-- SideBar Partial Display Version --}}
        @include('admin.partials.sidebar')

        {{-- Where info will be displayed --}}
        <div class="col-6 mx-0 px-0 rightSpan" style="width: 90em;">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>

    <script>
        var activeDropdownSchedule = null;
        var previousSchedule = null;
        var scheduleOperations = null;
        var operationsSchedule = null;

        // Clickable Rows on Tables
        $('#admin_brand').on('click', function(event) {
            window.location.replace('/admin');
        });

        $('#tableNextClasses').on('click', 'tr', function(event) {
            var id = $(this).attr('id');
            var fullId = id.split('-');
            if (fullId.length > 1) {
                var splittedId = fullId[1];
                scheduleOperations = splittedId;
                operationsSchedule = scheduleOperations;
            }
            if (!$(event.target).hasClass('text-center')) {
                window.location.replace('/admin/operations/' + operationsSchedule);
            }
        });

        $(document).ready(function () {
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

            $("#logout-button").on('click',function(){
                $("#logout-admin").submit()
            });

            //Function to display view depending on the clicked link
            function callPage(page){
                window.location.replace('/admin/' + page)
            }

            // Jquery UI DatePicker (Safari)
            if ($('[type="date"]').prop('type') != 'date') {
                $('[type="date"]').datepicker({
                    dateFormat: 'yy/mm/dd',
                    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
                    dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
                    dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
                    monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                    currentText: "Hoy",
                    changeMonth: true,
                    changeYear: true,
                    minDate: 0,
                    yearRange: '-110:+0',
                    onSelect: function(dateText, inst) {
                        $(inst).val(dateText); // Write the value in the input
                    }
                });
            }
        });
    </script>
    <script src="{{ asset('js/diacritics.js') }}"></script>

    @yield('extra_scripts')
</body>
</html>
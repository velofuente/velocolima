<head>
    <meta charset="utf-8">

    <title>@yield('title')</title>

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.png" type="img/favicon.png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,600" type="text/css">
    {{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dist/hamburgers.css') }}">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/layout-styles.css?v=1.1.2') }}">
    <link rel="stylesheet" href="{{ asset('css/packages.css?v=1.1.2') }}">

    <style>
        .mainContainer,
        .overlay-content {
            padding-top: 6em;
        }

        @media only screen and (min-width: 100px) and (max-width: 350px) {
            .forte {
                display: block;
            }

            .home {
                display: flex;
                margin: 0 -16px;
            }

            .links {
                right: 2em;
            }

            .hambBtn {
                margin-right: -45px;
                transform: scale(0.7);
            }

            .logoNavBar {
                width: 54px;
                height: 31px;
            }

            .userNavBar {
                transform: scale(0.9);
                margin: 0 -7px;
            }

            .logoutNavBar {
                transform: scale(0.9);
                margin: 0px -2px 0px -8px;
            }
        }

        /* Extra small devices (phones, 600px and down) */
        @media only screen and (min-width: 351px) and (max-width: 600px) {
            .forte {
                display: block;
            }

            .home {
                display: flex;
                margin: 0 -22px;
            }

            .links {
                right: 4em;
            }

            .hambBtn {
                margin: 0 -32px;
            }

            .logoNavBar {
                width: 80px;
                height: 40px;
                transform: scale(0.8);
                margin: -6px;
            }

            .userNavBar {
                transform: scale(0.9);
                margin: 0 -7px;
            }

            .logoNavBar {
                width: 80px;
                height: 40px;
                transform: scale(0.8);
                margin: -6px;
            }

            .logoutNavBar {
                transform: scale(0.9);
                margin: 0px -2px 0px -8px;
            }
        }
    </style>
    @yield('extraStyles')
</head>

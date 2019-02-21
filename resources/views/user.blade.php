<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuario</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
    <div class="container-fluid">
         <div class="flex-center position-ref full-height">
                <div class="jumbotron bg-dark text-white row">
                    <div class="col-md-5">
                        <h1 class="text-center text-info">Pablo Miguel Jimenez Garcia</h1>
                        <hr>
                        <h4 class="text-center">Mis Clases</h4>
                        <div id="clases" class="text-center">
                                <div class="classesButton">
                                        <h1 class="text-info">0</h1>
                                        <span>Classes</span><br>
                                        <small class="text-secondary">* Clases disponibles en tu cuenta</small>
                                </div>
                                <button class="btn btn-info" role="button">COMPRAR CLASES</button>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div id="userGeneralData">
                            <button class="btn text-info d-block mx-auto" style="background-color:transparent">CERRAR SESSION</button>
                            <hr>
                            <button type="button" class="btn btn-secondary mb-2 d-block mx-auto" data-toggle="collapse" data-target="#userData">Datos del usuario</button>
                            <div id="userData" class="collapse">
                                <div class="d-block">
                                    <input type="text" class="form-control pl-3" style="background-color:white" placeholder="Nombre">
                                    <input type="text" class="form-control pl-3" style="background-color:white" placeholder="Apellido">
                                    <input type="email" class="form-control pl-3" style="background-color:white" placeholder="Email">
                                    <input type="date" class="form-control pl-3" style="background-color:white" placeholder="Fecha de nacimiento">
                                    <input type="text" class="form-control pl-3" style="background-color:white" placeholder="Numero de telefono">
                                </div>
                                <button class="btn btn-info" role="button">Actualizar</button>
                            </div>
                            <button type="button" class="btn btn-secondary mb-2 d-block mx-auto" data-toggle="collapse" data-target="#userPassword">Cambiar contraseña</button>
                            <div id="userPassword" class="collapse">
                                <div class="d-block">
                                    <input type="password" class="form-control pl-3 mx-auto" style="background-color:white" placeholder="Contraseña">
                                    <input type="password" class="form-control pl-3 mx-auto" style="background-color:white" placeholder="Confirmar contraseña">
                                </div>
                                <button class="btn btn-info mx-auto" role="button">Guardar contraseña</button>
                            </div>
                        </div>
                        <hr>
                        <div id="Payments">
                            <h5 class="text-center mx-auto">Formas de Pago</h5>
                            <h5 class="text-center mx-auto">Mis tarjetas</h5>
                            <hr>
                            <button class="btn btn-light mb-4 d-block mx-auto" role="button"><small>+ Añadir tarjeta</small></button>
                        </div>
                        <hr>
                    </div>
                    <div id="shareCode" class="col-md-5 rounded-circle border border-info mx-auto">
                    </div>
                    <div class="col-md-7">
                        <div id="extraInfo">
                            <button type="button" class="btn btn-secondary mb-2 d-block mx-auto">Historial de pagos</button>
                            <button type="button" class="btn btn-secondary mb-2 d-block mx-auto">Lista de espera</button>
                            <button type="button" class="btn btn-secondary mb-2 d-block mx-auto">Clases anteriores</button>
                            <button type="button" class="btn btn-secondary mb-2 d-block mx-auto">Clases expiradas</button>
                        </div>
                    </div>
                </div>
         </div>
    </div>
    <script src="js/app.js" charset="utf-8"></script>
</body>
</html>
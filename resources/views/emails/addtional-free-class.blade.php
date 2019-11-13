<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body >
    <center>
        <table width="70%" border="0" cellpadding="0" cellspacing="0" bgcolor="black">
            <tr>
                <td align="center" valign="top">
                    <br><br>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top">
                    <h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:white;font-size:19px;font-weight:bold;margin-top:0;text-align:center">¡Hola {{ $name }}!</h1>
                    <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:white;font-size:16px;line-height:1.5em;margin-top:0;text-align:center">Te queda sólo una clase en tu cuenta de Vèlo, compra un nuevo paquete de 10 o más clases dentro de las próximas 24 horas y te obsequiamos una clase adicional.</p>
                    <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:white;font-size:16px;line-height:1.5em;margin-top:0;text-align:center">Para comprar tu nuevo paquete haz click <a href="https://www.velocycling.mx/schedule#packages">aquí.</p>
                    <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:white;font-size:16px;line-height:1.5em;margin-top:0;text-align:center">Saludos de parte del equipo de Vèlo.</p>
                </td>
            </tr>
            <tr>
                <td align="center" valign="bottom">
                    <img src="{{env('APP_URL')}}/img/iconos/logo_p.png" height="150" width="300"> 
                    <br><br><br><br>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>
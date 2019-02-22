<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Instructor Info</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>

    {{-- Content --}}
    <div class="container-fluid " style="background-color:#222">
        <div class="container-fluid">
            <!-- Section for the General Info of the Instructor -->
            <div class="row">
                <!-- Image -->
            <div id="instructorImage" class="col-md-5">
                    <img src="https://i.pinimg.com/originals/dd/46/60/dd46604477f46b3e306f5b9600cccb64.png" class="img-fluid" alt="Instructor image">
                </div>
                <!-- Name, Description and Phrase -->
                <div class="info col-md-7">
                    <h1 id="instructorName" class="text-info mt-3">Dani</h1>
                    <div id="instructorDescription" class="text-justify mt-3" style="color:white">
                        <p>
                            Psicóloga en proceso, amante de los viajes y las distintas culturas, pero más importante aún es que es amante de México en todo su esplendor.
                            Todos aquellos que conocemos a Dani podemos decir que es una persona alegre que disfruta de su día al máximo y contagia siempre a los demás de felicidad pura. Precisamente esto es lo que hace que salgas de su clase con una sonrisa de lado a lado.
                        </p>
                        <p>
                            Pasiones: Bailar tap, hacer ejercicio, todo lo que tenga que ver con psicología, mantener su cuerpo y mente en equilibrio e ir a la playa.
                        </p>
                        <p>
                            Drives: a Dani la motiva e inspira rodearse de gente con buena vibra, buen corazón, fortaleza y el apoyo incondicional de personas que quiere. La mueve hacer cosas que la reten, fortalezcan y la hagan crecer como persona.
                        </p>
                        <p>
                            Rolando: Rolo para Dani es un tiempo clave de su día, ya que es aquello que la motiva a dar lo mejor de sí y la reta. Lo más importante para ella en su clase es compartir con todos esa alegría, ser capaz de brindarles un momento divertido, de reflexión, lleno de vida para que todos se motiven a dar lo mejor de sí en cada pedaleada.
                            Su clase es intensa, llena de energía, retadora, reflexiva y por supuesto que no puede fallar la buena música; porque para Dani es importante ver cómo cada canción contagia a todos de una manera distinta y los impulsa a dejarlo todo ahí dentro.
                        </p>
                        <p>
                            Guilty pleasure: Sin duda es el chocolate y el pollo a la naranja de Qin jajaja
                        </p>
                        <p>
                            Máquina del tiempo: Los años 30’s sería una época en la que le gustaría haber vivido ya que ama el estilo de baile que caracterizaba a esta época (el swing) y le fascina la forma tan peculiar y elegante en la que se vestían.
                        </p>
                    </div>
                    <div id="instructorPhrase" class="font-weight-bold lead mt-4" style="color:lightsalmon;">
                        "Busca lo que encienda tu alma."
                    </div>
                </div>
            </div>

            <!-- Section for the Dates available of the Instructor and the Music -->
            <div class="row">
                <div class="col-md-7 rounded" style="background-color:black; color:white;">
                    <!-- div for the selection of the place -->
                    <div class="places mt-2">
                        <select id="instructorPlace" name="places" class="form-control w-25">
                            <option selected>Providencia</option>
                        </select>
                    </div>
                    <!-- div for the dates available -->
                    <div id="calendar" class="row small mt-3">
                        <div class="col text-center">
                            <div id="day_num">20</div>
                            <div id="day_name">Miercoles</div>
                            <div id="time">6:00 hrs</div>
                        </div>
                        <div class="dia col text-center">
                            <div id="day_num">20</div>
                            <div id="day_name">Jueves</div>
                            <div id="time">6:00 hrs</div>
                            <div class="button rounded-circle bg-dark border border-info">
                                <a href="#" class="btn text-info small" style="text-decoration:none">
                                    Gabi <span class="small">7:30 PM</span>
                                </a>
                            </div>
                        </div>
                        <div class="dia col text-center">
                            <div id="day_num">20</div>
                            <div id="day_name">Viernes</div>
                            <div id="time">6:00 hrs</div>
                        </div>
                        <div class="dia col text-center">
                            <div id="day_num">20</div>
                            <div id="day_name">Miercoles</div>
                            <div id="time">6:00 hrs</div>
                        </div>
                        <div class="dia col text-center">
                            <div id="day_num">20</div>
                            <div id="day_name">Miercoles</div>
                            <div id="time">6:00 hrs</div>
                        </div>
                        <div class="dia col text-center">
                            <div id="day_num">20</div>
                            <div id="day_name">Miercoles</div>
                            <div id="time">6:00 hrs</div>
                        </div>
                        <div class="dia col text-center">
                            <div id="day_num">20</div>
                            <div id="day_name">Miercoles</div>
                            <div id="time">6:00 hrs</div>
                        </div>
                    </div>
                </div>
                <!-- Should implement Spotify API here -->
                <div class="col-md-5">
                    <div class="rounded m-2" style="background-color:black; color:white">
                        Implement Spotify API
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/app.js" charset="utf-8"></script>

</body>
</html>
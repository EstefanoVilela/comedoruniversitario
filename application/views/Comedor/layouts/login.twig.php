{% extends "Comedor/templates/base.twig.php" %}

{% block content %}
<header>
    <div class="container p-4">
        <h2 class="text-center text-white">Programa de Comedor Universitario - UNFV</h2>
    </div>
</header>

<div class="container">
    {% include "Comedor/partials/alert.twig.php" %}

    <section class="row mb-3">
        <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="p-5 panel">
                <form action="" id="login">
                    <h2>Comedor Universitario</h2>

                    <div class="form-group">
                        <label for="username">Usuario: </label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Ingrese código">
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña: </label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese contraseña">
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                </form>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="p-5 panel">
                <section class="row">
                    <div class="col-md-4">
                        <div class="p-4 text-center">
                            <img src="assets/img/fork.png">
                        </div>
                        <p class="text-justify">Tiene por finalidad brindar accesibilidad a los estudiantes de pregrado de la UNFV a las comidas fundamentales durante el día</p>
                    </div>

                    <div class="col-md-4">
                        <div class="p-4 text-center">
                            <img src="assets/img/student.png" />
                        </div>
                        <p class="text-justify">Al estar orientado a los alumnos de la UNFV es obligatorio que te identifiques como tal mediante tu carnet universitario.</p>
                    </div>

                    <div class="col-md-4">
                        <div class="p-4 text-center">
                            <img src="assets/img/clock.png" />
                        </div>
                        <p class="text-justify">El servicio está disponible de lunes a viernes<br>
                            Desayuno : 07:30 - 09:30<br>
                            Almuerzo : 12:00 - 15:30<br>
                            Cena : 18:00 - 21:00</p>
                    </div>
                </section>
            </div>
        </div>
    </section>

    <div class="p-5 panel mb-5">
        <section class="row">
            <div class="col-md-6">
                <a target="_blank" href="https://www.google.com/maps/place/UNFV+Bienestar/@-12.0487053,-77.0407256,19z/data=!4m8!1m2!2m1!1sunfv+bienestar+!3m4!1s0x0:0x9924e645ac402620!8m2!3d-12.0486348!4d-77.0402379">
                    <span class="fas fa-map-marker-alt mr-sm-2"></span>
                    Ubícanos!
                </a><br>

                <a href="#">
                    <span class="fas fa-phone-alt mr-sm-2"></span>
                    Teléfono de la ocbu: 748-0888
                </a><br>

                <a href="#">
                    <span class="fas fa-comment mr-sm-2"></span>
                    Secretaría de OCBU Anexos: 9623
                </a><br>

                <a href="#">
                    <span class="fas fa-envelope mr-sm-2"></span>
                    Área de Apoyo Alimentario: aaasp.ocbu@unfv.edu.pe
                </a>
            </div>

            <div class="col-md-6">
                <p class="text-justify">Los programas de Bonos Alimenticios y Servicio de Comedor Universitario son cubiertos con fondos de la universidad destinados a la ejecución de estos programas y administrados por la Oficina Central de Bienestar Universitario a través del área de Servicio Social.</p>
            </div>
        </section>
    </div>
</div>
{% endblock %}
<h3>Bienvenido</h3><hr>
{% include "Comedor/partials/alert.twig.php" %}
<section class="row">
    <div class="col-md-6">
        <div class="cont_carnet">
            <div class="px-5 py-3">
                <img src="assets/img/logounfv.jpg" alt="" width="150px" height="50px">
            </div>
            <div class="pb-4 text-center">
                <img src="assets/img/alumno.png">
            </div>

            <div class="px-5">
                <p>
                    <b>Código: </b>{{ alumno.cod_alumno }} <br>
                    <b>DNI: </b>{{ alumno.num_doc }} <br>
                    <b>Nombres: </b>{{ alumno.nombres }} <br>
                </p>
                <p>
                    <b>Escuela: </b>{{ alumno.nom_escuela }} <br>
                    <b>Facultad: </b>{{ alumno.nom_facu }} <br>
                    <b>Predio: </b>{{ alumno.nom_predio }} <br>
                </p>
                <p>
                    <b>Saldo: </b>{{ alumno.saldo }} <br>
                </p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div id="permitido" class="m-auto {% if hab.permitido == 0 %} d-none {% endif %}">
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead class="thead-light">
                        <tr>
                            <th>Turno</th>
                            <th>Inicio</th>
                            <th>FIN</th>
                            <th>Disponibles</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody id="tbody-horarios">
                        {% for h in horarios %}
                        <tr>
                            <td>{{ h.num_horario }}</td>
                            <td>{{ h.inicio }}</td>
                            <td>{{ h.fin }}</td>
                            <td>{{ h.disponibles }}</td>
                            <td>
                                <!-- <a class="btn btn-success" href="Comedor_Inicio/Reservar?id={{ h.NUM_HORARIO }}">Reservar</a> -->
                                <button type="button" onclick="reservar('{{ h.num_horario }}')" class="btn btn-success">Reservar</button>
                            </td>
                        </tr>
                        {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
        <div id="bloqueado" class="row p-4 bloqueo {% if hab.permitido == 1 %} d-none {% endif %}">
            <div class="m-auto">
                <h5>Usted no puede realizar una reserva</h5>
                <p id="mensaje-reserva">{{ hab.message }}</p>
                <div id="btn-bloqueo">
                    {{ hab.boton|raw }}
                </div>
            </div>
        </div>
    </div>
</section>
<h3>Historial</h3><hr>
<div class="table-responsive">
    <table class="table table-bordered table-hover text-center">
        <thead class="thead-light">
            <tr>
                <th>Código</th>
                <th>Fecha</th>
                <th>Hora de reserva</th>
                <th>Hora de atención</th>
                <th>Tipo de comida</th>
                <th>Turno</th>
                <th>Hora turno</th>
                <th>Atención</th>
            </tr>
        </thead>

        <tbody id="tbody-historial">
            {% for r in reservas %}
            <tr>
                <td>{{ r.id_reserva }}</td>
                <td>{{ r.fecha_reserva }}</td>
                <td>{{ r.hora_reserva }}</td>
                <td>{{ r.hora_atencion }}</td>
                <td>{{ r.nom_tcomida }}</td>
                <td>{{ r.id_horario }}</td>
                <td>{{ r.inicio ~ " - " ~ r.fin }}</td>
                <td>{{ r.nom_atencion }}</td>
            </tr>
            {% endfor %}
        </tbody>
    </table>
</div>
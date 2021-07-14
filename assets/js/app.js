$(document).ready(function(){
    $('.alert').hide();
});

$('#login').submit((ev) => {
    ev.preventDefault();
    const username = login.username.value;
    const password = login.password.value;

    if(username == '' | password == ''){
        mostrarAlert('Advertencia', 'Complete el login', 'warning');
    }else{
        $.ajax({
            'url': 'validar',
            'data': { username, password },
            'method': 'POST',
            'dataType': 'json'
        }).done((res) => {
            console.log();
            const { code, title, message } = res.success;

            if(code == 1){
                mostrarAlert(title, message, 'success');
                window.location.href = '';
            }else{
                mostrarAlert(title, message, 'danger');
            }
        }).fail((err) => {
            $('#modal-body').html(err.responseText);
            $('#myModal').modal('show');
        });
    }
});

function reservar(id_horario){
    $.ajax({
        'url': 'reservar',
        'data': { id_horario },
        'method': 'POST',
        'dataType': 'json'
    }).done((res) => {
        console.log(res);
        const { success, fetchData, hab } = res;
        const { code, title, message } = success;
        const { reservas } = fetchData;

        if(code == 1){
            mostrarAlert(title, message, 'success');
            $('#titulo-reserva').html(hab.message);
            $('#btn-bloqueo').html(hab.boton);

            $('#permitido').addClass('d-none');
            $('#bloqueado').removeClass('d-none');

            let cadena = '';

            for(let i of reservas){
                cadena += 
                `<tr>
                    <td>${ i.id_reserva }</td>
                    <td>${ i.fecha_reserva }</td>
                    <td>${ i.hora_reserva }</td>
                    <td>${ i.hora_atencion }</td>
                    <td>${ i.nom_tcomida }</td>
                    <td>${ i.id_horario }</td>
                    <td>${ i.inicio} - ${ i.fin }</td>
                    <td>${ i.nom_atencion }</td>
                </tr>`;
            }

            $('#tbody-historial').html(cadena);
        }else{
            mostrarAlert('Upsss...', message, 'danger');
        }
    }).fail((err) => {
        $('#modal-body').html(err.responseText);
        $('#myModal').modal('show');
    });
}

function eliminar(){
    $.ajax({
        'url': 'eliminar',
        'data': {},
        'method': 'POST',
        'dataType': 'json'
    }).done((res) => {
        console.log(res);
        const { success, fetchData } = res;
        const { code, title, message } = success;
        const { horarios, reservas } = fetchData;

        if(code == 1){                
            mostrarAlert(title, message, 'success');

            $('#tbody-horarios').html('');
            $('#permitido').removeClass('d-none');
            $('#bloqueado').addClass('d-none');

            let cadena = '';

            for(let i of horarios){
                cadena += 
                `<tr>
                    <td>${ i.num_horario }</td>
                    <td>${ i.inicio }</td>
                    <td>${ i.fin }</td>
                    <td>${ i.disponibles }</td>
                    <td>
                        <button type="button" onclick="reservar(${ i.num_horario })" class="btn btn-success">Reservar</button>
                    </td>
                </tr>`;
            }

            $('#tbody-horarios').html(cadena);

            cadena = '';

            $('#tbody-historial').html('');
            if(reservas){
                for(let i of reservas){
                    cadena += 
                    `<tr>
                        <td>${ i.id_reserva }</td>
                        <td>${ i.fecha_reserva }</td>
                        <td>${ i.hora_reserva }</td>
                        <td>${ i.hora_atencion }</td>
                        <td>${ i.nom_tcomida }</td>
                        <td>${ i.id_horario }</td>
                        <td>${ i.inicio} - ${ i.fin }</td>
                        <td>${ i.nom_atencion }</td>
                    </tr>`;
                }
            }
            $('#tbody-historial').html(cadena);
        }else{
            mostrarAlert(title, message, 'danger');
        }
    }).fail((err) => {
        $('#modal-body').html(err.responseText);
        $('#myModal').modal('show');
    });
}

function pintar(flg){
    if(flg == 0){
        $('body').addClass('bg-coun');
    }else{
        $('body').removeClass('bg-coun');
    }
}
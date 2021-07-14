/*==================== ALERTAS ====================*/
var flg_alert = '';
// var flg_pos = '#home';

function mostrarAlert(p_title, p_message, p_tipo){
    // Quitamos la clase anterior
    $('.alert').removeClass(flg_alert);

    p_message = `<b>${p_title}</b> ${p_message}.`;
    flg_alert = 'alert-'+p_tipo;

    // Agregamos la nueva clase
    $('.alert').addClass(flg_alert);

    // Inyectamos el mensaje al alert
    $('#msn').html(p_message);
    
    // Animación para regresar a la cabecera de la página
    let target_top = $('.alert').offset().top;
    $('html,body').animate({scrollTop:target_top},{duration:"slow"});

    // Mostrar el alert con degradado
    $('.alert').fadeIn();
}

function cerrarAlert(){
    $('.alert').fadeOut();
}

function posicionar(id){
    // $(flg_pos).removeClass('active');
    // flg_pos = id;
    // $(flg_pos).addClass('active');

    let navbar = $('.navbar').height();
    // alert(navbar);
    let target_top = $(id).offset().top - navbar*2;
    $('html,body').animate({scrollTop:target_top},{duration:"slow"});
}

/*==================== BLOQUEO DE PANTALLA ====================*/
// function bloquear(p){
//     $('input[type="checkbox"]').attr('disabled', p);
//     $('input[type="text"]').attr('disabled', p);
//     $('textarea').attr('disabled', p);
//     $('button').attr('disabled', p);
//     $('select').attr('disabled', p);
// }

/*==================== MODALES ====================*/
// var flg_modal = '';
// function mostrarModal(p_msn, p_size, p_title, p_cancel){
//     $('.modal-dialog').removeClass(flg_modal);
//     flg_modal = p_size;

//     // modal-lg
//     $('.modal-dialog').addClass(p_size);
//     $('.modal-title').html(p_title);
//     $('.modal-body').html(p_msn);

//     if(p_cancel == false){
//         // No mostrar el botón close
//         $('.modal-footer').html('');
//     }

//     $('.modal').modal('show');
// }

/* ==================== OBTENER CONFIGURACIÓN ==================== */
DELIMITER //
CREATE OR REPLACE PROCEDURE up_coun_getConfig(
	IN in_idalumno INT,
	OUT out_code INT,
	OUT out_title VARCHAR(50),
	OUT out_message VARCHAR(50),
	OUT out_ayudas TEXT,
	OUT out_dias TEXT,
	OUT out_horarios TEXT,
	OUT out_comidas TEXT,
	OUT out_reservas TEXT
) BEGIN
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		SET out_code = -1;
		SET out_title = 'Error';
		SET out_message = 'SQLEXCEPTION';
        ROLLBACK;
	END;

	DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		SET out_code = -1;
		SET out_title = 'Advertencia';
		SET out_message = 'SQLWARNING';
        ROLLBACK;
	END;
	
	SELECT CONCAT('[', GROUP_CONCAT(JSON_OBJECT('id_ayuda', id_ayuda, 'titulo_ayuda', titulo_ayuda, 'nom_ayuda', nom_ayuda)), ']')
	INTO out_ayudas
	FROM ayuda;
	
	SELECT CONCAT('[', GROUP_CONCAT(JSON_OBJECT('id_dia', id_dia, 'nom_dia', nom_dia)), ']')
	INTO out_dias
	FROM dia;
	
	SELECT CONCAT('[', GROUP_CONCAT(JSON_OBJECT('id_horario', id_horario, 'num_horario', num_horario, 'inicio', inicio, 'fin', fin, 'disponibles', disponibles)), ']')
	INTO out_horarios
	FROM horario;
	
	SELECT CONCAT('[', GROUP_CONCAT(JSON_OBJECT('id_comida', c.id_comida, 'bebida', c.bebida, 'item_1', c.item_1, 'item_2', c.item_2, 'postre', c.postre, 'id_tcomida', tc.id_tcomida, 'nom_tcomida', tc.nom_tcomida, 'id_dia', c.id_dia)), ']')
	INTO out_comidas
	FROM comida c
	INNER JOIN tipo_comida tc
		ON c.id_tcomida=tc.id_tcomida
	ORDER BY tc.id_tcomida;

	SELECT CONCAT('[', GROUP_CONCAT(JSON_OBJECT('id_reserva', r.id_reserva, 'fecha_reserva', r.fecha_reserva, 'hora_reserva', r.hora_reserva, 'hora_atencion', r.hora_atencion, 'nom_tcomida', tc.nom_tcomida, 'id_horario', h.id_horario, 'inicio', h.inicio, 'fin', h.fin, 'id_atencion', ta.id_atencion, 'nom_atencion', ta.nom_atencion)), ']')
	INTO out_reservas
	FROM reserva r
	INNER JOIN tipo_comida tc
		ON r.id_tcomida=tc.id_tcomida
	INNER JOIN horario h
		ON r.id_horario=h.id_horario
	INNER JOIN tipo_atencion ta
		ON r.id_atencion=ta.id_atencion
	WHERE r.id_alumno = in_idalumno
	ORDER BY r.id_reserva DESC;
	
	SET out_code = 1;
	SET out_title = 'Correcto!';
	SET out_message = 'Las transacciones fueron exitosas';
END; //
DELIMITER ;

CALL up_coun_getConfig(1, @code, @title, @message, @ayudas, @dias, @horarios, @comidas, @reservas);
SELECT @code as code, @title as title, @message as message, @ayudas as ayudas, @dias as dias, @horarios as horarios, @comidas as comidas, @reservas as reservas;
/* ==================== OBTENER CONFIGURACIÓN ==================== */



/* ==================== GUARDAR UNA RESERVA ==================== */
DELIMITER //
CREATE OR REPLACE PROCEDURE up_coun_guardarReserva(
	IN  in_idhorario INT,
	IN  in_idalumno  INT,
	OUT out_code     INT,
	OUT out_title    VARCHAR(50),
	OUT out_message  VARCHAR(50),
	OUT out_reservas TEXT
)BEGIN
	DECLARE fecha DATE;
	DECLARE hora TIME;

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		SET out_code = -1;
		SET out_title = 'Error';
		SET out_message = 'SQLEXCEPTION';
		ROLLBACK;
	END;

	DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		SET out_code = -1;
		SET out_title = 'Advertencia';
		SET out_message = 'SQLWARNING';
		ROLLBACK;
	END;

	SET fecha = DATE_FORMAT(NOW(), '%Y-%m-%d');
	SET hora  = DATE_FORMAT(NOW(), '%h:%i:%s');

	INSERT INTO reserva VALUES (NULL, fecha, hora, NULL, 2, in_idhorario, 2, in_idalumno);
	UPDATE horario SET disponibles = disponibles-1 WHERE id_horario = in_idhorario;

	SET out_code = 1;
	SET out_title = 'Correcto';
	SET out_message = 'RESERVA CORRECTA';

   SELECT CONCAT('[', GROUP_CONCAT(JSON_OBJECT('id_reserva', r.id_reserva, 'fecha_reserva', r.fecha_reserva, 'hora_reserva', r.hora_reserva, 'hora_atencion', r.hora_atencion, 'nom_tcomida', tc.nom_tcomida, 'id_horario', h.id_horario, 'inicio', h.inicio, 'fin', h.fin, 'id_atencion', ta.id_atencion, 'nom_atencion', ta.nom_atencion)), ']')
	INTO out_reservas
	FROM reserva r
	INNER JOIN tipo_comida tc
		ON r.id_tcomida=tc.id_tcomida
	INNER JOIN horario h
		ON r.id_horario=h.id_horario
	INNER JOIN tipo_atencion ta
		ON r.id_atencion=ta.id_atencion
	WHERE r.id_alumno = in_idalumno
	ORDER BY r.id_reserva DESC;
END; //
DELIMITER ;

CALL up_coun_guardarReserva(1, 1, @code, @title, @message, @reservas);
SELECT @code, @title, @message, @reservas;
/* ==================== GUARDAR UNA RESERVA ==================== */



/* ==================== VALIDAR LOGIN USUARIO ==================== */
DELIMITER //
CREATE OR REPLACE PROCEDURE up_coun_validarUsuario(
    IN   in_username  VARCHAR(50),
	IN   in_password  VARCHAR(50),
    OUT  out_code     INT,
    OUT  out_title    VARCHAR(50),
    OUT  out_message  VARCHAR(50),
    OUT  out_usuario  TEXT
)BEGIN
    DECLARE var_password VARCHAR(50);

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		SET out_code = -1;
		SET out_title = 'Error';
		SET out_message = 'SQLEXCEPTION';
		ROLLBACK;
	END;

	DECLARE EXIT HANDLER FOR SQLWARNING
	BEGIN
		SET out_code = -1;
		SET out_title = 'Advertencia';
		SET out_message = 'SQLWARNING';
		ROLLBACK;
	END;

    SELECT p.password
    INTO var_password
    FROM persona p
    WHERE p.usuario = in_username;

    IF var_password IS NULL THEN
        SET out_code    = 0;
        SET out_title   = 'Ups...';
        SET out_message = 'Usuario incorrecto!';
    ELSE
        IF var_password = in_password THEN
            SET out_code    = 1;
            SET out_title   = 'Todo bien!';
            SET out_message = 'Bienvenido, usuario!';
        ELSE
            SET out_code    = 0;
            SET out_title   = 'Ups...';
            SET out_message = 'Password incorrecto!';
        END IF;
    END IF;

    SELECT JSON_OBJECT(
        'nombres', CONCAT(p.apl_pat, ' ', p.apl_mat, ' ', p.nom_persona), 
        'cod_alumno', a.cod_alumno, 
        'id_alumno', a.id_alumno, 
        'num_doc', (SELECT d.num_doc FROM documento d WHERE p.id_persona = d.id_persona), 
        'nom_escuela', e.nom_escuela, 
        'nom_facu', f.nom_facu, 
        'nom_predio', pre.nom_predio, 
        'saldo', (SELECT sa.saldo FROM saldo_alumno sa WHERE a.id_alumno=sa.id_alumno)
    )
	INTO out_usuario
    FROM persona p
    INNER JOIN alumno a
        ON p.id_persona=a.id_persona
    INNER JOIN escuela e
        ON a.id_escuela=e.id_escuela
    INNER JOIN facultad f
        ON e.id_facu=f.id_facu
    INNER JOIN predio pre
        ON f.id_predio=pre.id_predio
    WHERE usuario = 'stefano'
        AND PASSWORD = '12345';
END; //
DELIMITER ;
CALL up_coun_validarUsuario('stefano', '12345', @code, @title, @message, @usuario);
SELECT @code, @title, @message, @usuario;
/* ==================== VALIDAR LOGIN USUARIO ==================== */



/* ==================== ELIMINAR UNA RESERVA ==================== */
DELIMITER //
CREATE OR REPLACE PROCEDURE up_coun_eliminarReservar(
	IN  in_id_alumno INT,
	OUT out_code     INT,
	OUT out_title    VARCHAR(50),
	OUT out_message  VARCHAR(50),
	OUT out_horarios TEXT,
	OUT out_reservas TEXT
)BEGIN
	DECLARE cont INT;
	DECLARE var_id_horario INT;
	
	SELECT COUNT(1), id_horario
		INTO cont, var_id_horario
		FROM reserva 
		WHERE id_alumno = in_id_alumno
			AND id_atencion = 2;

	IF cont != 0 THEN 
		DELETE FROM reserva WHERE id_alumno = in_id_alumno AND id_atencion = 2;
		UPDATE horario SET disponibles = disponibles+1 WHERE id_horario = var_id_horario;
		
		SET out_code = 1;
		SET out_title = 'Correcto';
		SET out_message = 'RESERVA ELIMINADA';

		SELECT CONCAT('[', GROUP_CONCAT(JSON_OBJECT('id_horario', id_horario, 'num_horario', num_horario, 'inicio', inicio, 'fin', fin, 'disponibles', disponibles)), ']')
			INTO out_horarios
			FROM horario;

		SELECT CONCAT('[', GROUP_CONCAT(JSON_OBJECT('id_reserva', r.id_reserva, 'fecha_reserva', r.fecha_reserva, 'hora_reserva', r.hora_reserva, 'hora_atencion', r.hora_atencion, 'nom_tcomida', tc.nom_tcomida, 'id_horario', h.id_horario, 'inicio', h.inicio, 'fin', h.fin, 'id_atencion', ta.id_atencion, 'nom_atencion', ta.nom_atencion)), ']')
			INTO out_reservas
			FROM reserva r
			INNER JOIN tipo_comida tc
				ON r.id_tcomida=tc.id_tcomida
			INNER JOIN horario h
				ON r.id_horario=h.id_horario
			INNER JOIN tipo_atencion ta
				ON r.id_atencion=ta.id_atencion
			WHERE r.id_alumno = in_id_alumno
			ORDER BY r.id_reserva DESC;
	ELSE 
		SET out_code = 0;
		SET out_title = 'Upsss...';
		SET out_message = 'RESERVA NO ELIMINADA';
	END IF;
END; //
DELIMITER ;

CALL up_coun_eliminarReservar(1, @code, @title, @message, @horarios, @reservas);
SELECT @code, @title, @message, @horarios, @reservas;
/* ==================== ELIMINAR UNA RESERVA ==================== */
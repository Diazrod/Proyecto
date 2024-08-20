//CONSTANTE PARA EL PAQUETE DE MYSQL
const mysql = require('mysql');
// CONSTANTE PARA EL PAQUETE EXPRESS
const express = require('express');
//VARIABLES PARA LOS METDOS EXPRESS
var app= express();
//CONSTANTE PARA EL PAQUETE DE BODYPARSER
const bp = require('body-parser');

//ENVIANDO LOS DATOS JSON A NODEJS API
app.use(bp.json());

// Configuración de la conexión a la base de datos
const dbConfig = {
    host: 'localhost',
    user: 'root',
    password: '',
    database: '1800Pac2SanMartin',
    multipleStatements: true
};

// Función para crear y manejar la conexión a la base de datos
const pool = mysql.createPool(dbConfig);

// Manejo de desconexiones
pool.on('connection', (connection) => {
    console.log('Nueva conexión a la base de datos establecida');
});

pool.on('error', (err) => {
    console.error('Error en la conexión a la base de datos:', err);
});


// Iniciar el servidor en el puerto 3000
app.listen(3000, () => {
    console.log('Servidor corriendo en el puerto 3000');
});

app.get('/Bpersonas/:tipo', (req, res) => {
    const tipo = req.params.tipo.toUpperCase();

    // Validar el tipo de taabla personas
    const tiposValidos = ['PERSONAS','EMPLEADOS'];
    if (!tiposValidos.includes(tipo)) {
        return res.status(400).json({ error: 'Tipo de no válido' });
    }

    // Llamar al procedimiento almacenado para obtener los datos
    pool.query('CALL SEL_PERSONAS(?)', [tipo], (err, rows, fields) => {
        if (err) {
            console.error('Error ejecutando el procedimiento SEL_PERSONAS:', err);
            return res.status(500).json({ error: 'Error al obtener los datos  de personas.' });
        }
        res.status(200).json(rows[0]);
    });
});

// Ruta para insertar un nuevo registro en la tabla personas
app.post('/personas', (req, res) => {
    let persona = req.body;

    // Llamar al procedimiento almacenado para insertar una nueva persona
    pool.query('CALL INS_PERSONAS(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
        [
            persona.PE_TIP_TABLA, persona.pr_nombre, persona.sg_nombre, persona.pr_apellido, persona.sg_apellido,
            persona.dni_persona, persona.num_telefono, persona.fech_nacimiento, persona.genero, persona.personeria,
            persona.est_civil, persona.nom_depto, persona.municipio, persona.nom_barrio, persona.nom_calle,
            persona.cod_persona_existente, persona.nom_area, persona.fech_contrato, persona.salario, persona.est_empleado
        ],
        (err, rows, fields) => {
            if (err) {
                console.error('Error ejecutando el procedimiento INS_PERSONAS:', err);
                return res.status(500).send('Error al insertar el registro');
            }
            res.send('Ingresado correctamente !!');
        }
    );
});


// Ruta para actualizar una persona
app.put('/personas/:id', (req, res) => {
    const id = req.params.id;
    const persona = req.body;

    // Llamar al procedimiento almacenado para modificar una persona existente
    pool.query('CALL UPD_PERSONAS(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
        [
            persona.PE_TIP_TABLA,
            id,
            persona.pr_nombre,
            persona.sg_nombre,
            persona.pr_apellido,
            persona.sg_apellido,
            persona.dni_persona,
            persona.num_telefono,
            persona.fech_nacimiento,
            persona.genero,
            persona.personeria,
            persona.est_civil,
            persona.nom_depto,
            persona.municipio,
            persona.nom_barrio,
            persona.nom_calle,
            persona.cod_persona_existente,
            persona.nom_area,
            persona.fech_contrato,
            persona.salario,
            persona.est_empleado
        ],
        (err, rows, fields) => {
            if (err) {
                console.error('Error ejecutando el procedimiento UPD_PERSONAS:', err);
                return res.status(500).json({ error: 'Error al modificar el registro.' });
            }
            res.status(200).json({ message: 'Modificado correctamente !!' });
        }
    );
});

// Ruta para obtener una persona por su ID
app.get('/personas/:id', (req, res) => {
    const { id } = req.params;
    pool.query('SELECT * FROM PERSONAS WHERE COD_PERSONAS = ?', [id], (err, rows) => {
        if (!err && rows.length > 0) {
            res.status(200).json(rows[0]);
        } else {
            console.log(err);
            res.status(404).json({ error: 'Persona no encontrada' });
        }
    });
});


// Ruta para obtener una persona por su ID
app.get('/empleados/:id', (req, res) => {
    const { id } = req.params;
    pool.query('SELECT * FROM EMPLEADOS WHERE COD_EMPLEADO = ?', [id], (err, rows) => {
        if (!err && rows.length > 0) {
            res.status(200).json(rows[0]);
        } else {
            console.log(err);
            res.status(404).json({ error: 'EMPLEADO no encontrada' });
        }
    });
});





//**************************MODULO SACRAMENTOS ******************/ 
// Ruta para obtener sacramentos del tipo 1 (BAUTIZO, CONFIRMACION, PRIMERA COMUNION, MATRIMONIO)
app.get('/sacramentos1/:tipo', (req, res) => {
    const tipo = req.params.tipo.toUpperCase();

    // Validar el tipo de sacramento
    const tiposValidos = ['BAUTIZO', 'CONFIRMACION', 'PRIMERA COMUNION', 'MATRIMONIO'];
    if (!tiposValidos.includes(tipo)) {
        return res.status(400).json({ error: 'Tipo de sacramento no válido' });
    }

    // Llamar al procedimiento almacenado para obtener los datos
    pool.query('CALL SEL_SACRAMENTOS_1(?)', [tipo], (err, rows, fields) => {
        if (err) {
            console.error('Error ejecutando el procedimiento SEL_SACRAMENTOS_1:', err);
            return res.status(500).json({ error: 'Error al obtener los datos del sacramento' });
        }
        res.status(200).json(rows[0]);
    });
});





// Ruta para obtener sacramentos del tipo 2 (UNCION ENFERMOS, ORDEN SACERDOTAL, RECONCILIACION, GENERAL)
app.get('/sacramentos2/:tipo', (req, res) => {
    const tipo = req.params.tipo.toUpperCase();

    // Validar el tipo de sacramento
    const tiposValidos = ['UNCION ENFERMOS', 'ORDEN SACERDOTAL', 'RECONCILIACION', 'GENERAL'];
    if (!tiposValidos.includes(tipo)) {
        return res.status(400).json({ error: 'Tipo de sacramento no válido' });
    }

    // Llamar al procedimiento almacenado para obtener los datos
    pool.query('CALL SEL_SACRAMENTOS_2(?)', [tipo], (err, rows, fields) => {
        if (err) {
            console.error('Error ejecutando el procedimiento SEL_SACRAMENTOS_2:', err);
            return res.status(500).json({ error: 'Error al obtener los datos del sacramento' });
        }
        res.status(200).json(rows[0]);
    });
});



/*********************************BUSCAR PERSONA **************************/

app.get('/Bpersonas', (req, res) => {
    // Llamar al procedimiento almacenado SEL_PERSONAS con tipo 'PERSONAS'
    pool.query('CALL SEL_PERSONAS("PERSONAS")', (err, results) => {
        if (err) {
            console.error('Error al ejecutar el procedimiento SEL_PERSONAS:', err);
            return res.status(500).json({ error: 'Error al obtener los datos de personas.' });
        }

        // Los resultados están en results[0]
        res.json(results[0]);
    });
});


// Ruta para insertar un nuevo sacramento
app.post('/sacramentos', (req, res) => {
    let sac = req.body;

    let skipVerification = ['RECONCILIACION', 'ORDEN SACERDOTAL', 'UNCION ENFERMOS'];
    
    if (skipVerification.includes(sac.P_NOM_SACRAMENTO)) {
        // Si el sacramento es uno de los que permite registros duplicados, directamente insertar
        pool.query('CALL INS_SACRAMENTO(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)',
            [
                sac.P_NOM_SACRAMENTO, sac.P_COD_PERSONAS, sac.P_FECHA, sac.P_TIP_HIJO, sac.P_COD_MADRE,
                sac.P_COD_PADRE, sac.P_PADRINOS, sac.P_LIBRO_REG, sac.P_COD_MONS,
                sac.P_COD_PARROCO, sac.P_OBSERVACIONES, sac.P_COD_CONTRAYENTE_MUJER,
                sac.P_COD_CONTRAYENTE_HOMBRE, sac.P_FEC_BAUTIZO, sac.P_NOM_TESTIGOS,
                sac.P_PAR_BAUTIZO, sac.P_NOM_LUGAR, sac.P_FOLIO_REG, sac.P_NUMERO_REG, sac.P_NOM_CIUDAD
            ],
            (err, rows, fields) => {
                if (err) {
                    console.error('Error ejecutando el procedimiento INS_SACRAMENTO:', err);
                    return res.status(500).send('Error al insertar el registro');
                }
                res.send('Ingresado correctamente !!');
            }
        );
    } else {
        // Verificar si la persona ya existe en el sacramento correspondiente
        let query = '';
        switch (sac.P_NOM_SACRAMENTO) {
            case 'BAUTIZO':
                query = 'SELECT COUNT(*) AS count FROM BAUTIZOS WHERE COD_PERSONAS = ?';
                break;
            case 'CONFIRMACION':
                query = 'SELECT COUNT(*) AS count FROM CONFIRMACIONES WHERE COD_PERSONAS = ?';
                break;
            case 'PRIMERA COMUNION':
                query = 'SELECT COUNT(*) AS count FROM PRIMERA_COMUNION WHERE COD_PERSONAS = ?';
                break;
            case 'MATRIMONIO':
                query = 'SELECT COUNT(*) AS count FROM MATRIMONIOS WHERE COD_CONTRAYENTE_MUJER = ? AND COD_CONTRAYENTE_HOMBRE = ?';
                break;
            default:
                return res.status(400).send('Tipo de sacramento no válido');
        }

        // Ejecutar la consulta para verificar la existencia de la persona
        const params = sac.P_NOM_SACRAMENTO === 'MATRIMONIO' ? [sac.P_COD_CONTRAYENTE_MUJER, sac.P_COD_CONTRAYENTE_HOMBRE] : [sac.P_COD_PERSONAS];

        pool.query(query, params, (err, results) => {
            if (err) {
                console.error('Error al verificar existencia de la persona:', err);
                return res.status(500).send('Error al verificar la existencia de la persona');
            }

            // Obtener el resultado de la consulta
            const count = results[0].count;

            // Si la persona ya existe, devolver un error
            if (count > 0) {
                return res.status(400).send('La persona ya está registrada en este sacramento');
            }

            // Llamar al procedimiento almacenado para insertar un nuevo sacramento
            pool.query('CALL INS_SACRAMENTO(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)',
                [
                    sac.P_NOM_SACRAMENTO, sac.P_COD_PERSONAS, sac.P_FECHA, sac.P_TIP_HIJO, sac.P_COD_MADRE,
                    sac.P_COD_PADRE, sac.P_PADRINOS, sac.P_LIBRO_REG, sac.P_COD_MONS,
                    sac.P_COD_PARROCO, sac.P_OBSERVACIONES, sac.P_COD_CONTRAYENTE_MUJER,
                    sac.P_COD_CONTRAYENTE_HOMBRE, sac.P_FEC_BAUTIZO, sac.P_NOM_TESTIGOS,
                    sac.P_PAR_BAUTIZO, sac.P_NOM_LUGAR, sac.P_FOLIO_REG, sac.P_NUMERO_REG, sac.P_NOM_CIUDAD
                ],
                (err, rows, fields) => {
                    if (err) {
                        console.error('Error ejecutando el procedimiento INS_SACRAMENTO:', err);
                        return res.status(500).send('Error al insertar el registro');
                    }
                    res.send('Ingresado correctamente !!');
                }
            );
        });
    }
});



// Ruta para actualizar un sacramento
app.put('/sacramentos/:P_COD_SACRAMENTO', (req, res) => {
    const {
        P_NOM_SACRAMENTO, P_COD_PERSONAS, P_FECHA, P_TIP_HIJO, P_COD_MADRE, P_COD_PADRE,
        P_PADRINOS, P_LIBRO_REG, P_COD_MONS, P_COD_PARROCO, P_OBSERVACIONES,
        P_COD_CONTRAYENTE_MUJER, P_COD_CONTRAYENTE_HOMBRE, P_FEC_BAUTIZO, P_NOM_TESTIGOS,
        P_PAR_BAUTIZO, P_NOM_LUGAR, P_FOLIO_REG, P_NUMERO_REG, P_CIUDAD
    } = req.body;
    const { P_COD_SACRAMENTO } = req.params;

    // Log de los datos recibidos
    console.log('Datos recibidos:', req.body);
    console.log('ID del Sacramento:', P_COD_SACRAMENTO);

    // Llamar al procedimiento almacenado para actualizar el sacramento
    pool.query(
        'CALL UPD_SACRAMENTO(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
        [
            P_NOM_SACRAMENTO, P_COD_PERSONAS, P_FECHA, P_TIP_HIJO, P_COD_MADRE,
            P_COD_PADRE, P_PADRINOS, P_LIBRO_REG, P_COD_MONS, P_COD_PARROCO,
            P_OBSERVACIONES, P_COD_CONTRAYENTE_MUJER, P_COD_CONTRAYENTE_HOMBRE, P_FEC_BAUTIZO,
            P_NOM_TESTIGOS, P_PAR_BAUTIZO, P_NOM_LUGAR, P_FOLIO_REG, P_NUMERO_REG, P_CIUDAD, P_COD_SACRAMENTO
        ],
        (err, rows, fields) => {
            if (err) {
                console.error('Error ejecutando el procedimiento UPD_SACRAMENTO:', err);
                return res.status(500).json({ error: 'Error al actualizar el registro' });
            }
            res.status(200).json({ message: 'Registro actualizado correctamente' });
        }
    );
});








//***********MODULO SOCIAL*************** */



app.get('/selectSocial/:tipo', (req, res) => {
    const tipo = req.params.tipo.toUpperCase();

    // Validar el tipo de tabla
    const tiposValidos = ['TIPO_PROYECTO', 'PROYECTOS', 'SOLICITUD_AYUDA_SOCIAL'];
    if (!tiposValidos.includes(tipo)) {
        return res.status(400).json({ error: 'Tipo de tabla no válido' });
    }

    pool.query('CALL SEL_SOCIAL(?)', [tipo], (err, rows, fields) => {
        if (!err) {
            res.status(200).json(rows[0]);
        } else {
            console.log(err);
            res.status(500).json({ error: 'Internal Server Error' });
        }
    });
});




app.post('/insertSocial', (req, res) => {
    let params = req.body;
    var sql = "CALL INS_SOCIAL(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

    pool.query(sql, [
        params.P_TABLA_TIPO, params.P_NOMBRE, params.P_COD_TIPO_PROYECTO,
        params.P_NOMBRE_PROYECTO, params.P_OBSERVACIONES_PROYECTO,
        params.P_FEC_INICIO, params.P_FEC_FIN, params.P_RECURSOS_NECESARIOS,
        params.P_ESTADO_PROYECTO, params.P_FEC_SOLICITUD, params.P_TIPO_AYUDA,
        params.P_ESTADO_SOLICITUD, params.P_FEC_RESOLUCION, params.P_OBSERVACIONES_SOLICITUD,
        params.P_COD_PERSONAS
    ], (err, rows, fields) => {
        if (!err) {
            res.send("Ingresado correctamente !!");
        } else {
            console.log(err);
            res.status(500).send("Error al insertar el registro");
        }
    });
});





// Ruta para actualizar un registro social
app.put('/updateSocial/:P_ID', (req, res) => {
    const {
        P_TABLA_TIPO, P_NOMBRE, P_COD_TIPO_PROYECTO, P_NOMBRE_PROYECTO,
        P_OBSERVACIONES_PROYECTO, P_FEC_INICIO, P_FEC_FIN, P_RECURSOS_NECESARIOS,
        P_ESTADO_PROYECTO, P_FEC_SOLICITUD, P_TIPO_AYUDA, P_ESTADO_SOLICITUD,
        P_FEC_RESOLUCION, P_OBSERVACIONES_SOLICITUD, P_COD_PERSONAS
    } = req.body;
    const { P_ID } = req.params;

    // Llamar al procedimiento almacenado para actualizar el registro social
    pool.query(
        'CALL UPD_SOCIAL(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
        [
            P_TABLA_TIPO, P_ID, P_NOMBRE, P_COD_TIPO_PROYECTO, P_NOMBRE_PROYECTO,
            P_OBSERVACIONES_PROYECTO, P_FEC_INICIO, P_FEC_FIN, P_RECURSOS_NECESARIOS,
            P_ESTADO_PROYECTO, P_FEC_SOLICITUD, P_TIPO_AYUDA, P_ESTADO_SOLICITUD,
            P_FEC_RESOLUCION, P_OBSERVACIONES_SOLICITUD, P_COD_PERSONAS
        ],
        (err, rows, fields) => {
            if (err) {
                console.error('Error ejecutando el procedimiento UPD_SOCIAL:', err);
                return res.status(500).json({ error: 'Error al actualizar el registro' });
            }
            res.status(200).json({ message: 'Registro actualizado correctamente' });
        }
    );
});



// ************* METODOS DEL CRUD API MODULO COMUNIDAD ************************************************************

// ************************ Insert Comunidad Procedure ************************
// Insert <-> Post con procedimiento almacenado.
// Ruta para insertar una nueva comunidad
app.post('/Comunidad', (req, res) => {
    let params = req.body;
    var sql = "CALL INS_COMUNIDAD(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    pool.query(sql, [
        params.P_ACCION,
        params.P_NOM_COMUNIDAD,
        params.P_DIRECC_COMUNIDAD,
        params.P_CANT_FAMILIAS,
        params.P_COD_COMUNIDAD,
        params.P_COD_PERSONAS,
        params.P_NUM_FAMILIARES,
        params.P_TIP_VIVIENDA,
        params.P_PROFESION_OFICIO,
        params.P_RELIGION,
        params.P_CANT_MATRIMONIO,
        params.P_CANT_BAUTISMO,
        params.P_CANT_COMUNION,
        params.P_CANT_CONFRIMACION,
        params.P_MISA,
        params.P_GRUP_PARROQUIAL,
        params.P_ESTRATO_FAMILIAR
    ], (err, rows, fields) => {
        if (!err) {
            res.send("Ingresado correctamente !!");
        } else {
            console.log(err);
            res.status(500).send("Error al insertar el registro");
        }
    });
});



// ************************ Select Comunidad Procedure ************************
// Select <-> Get con procedimiento almacenado.

app.get('/Comunidad/:tipo', (req, res) => {
    const tipo = req.params.tipo.toUpperCase();

    // Validar el tipo de tabla
    const tiposValidos = ['COMUNIDAD', 'REGISTRO_COMUNIDAD'];
    if (!tiposValidos.includes(tipo)) {
        return res.status(400).json({ error: 'Tipo de tabla no válido' });
    }

    pool.query('CALL SEL_COMUNIDAD(?)', [tipo], (err, rows, fields) => {
        if (!err) {
            res.status(200).json(rows[0]);
        } else {
            console.log(err);
            res.status(500).json({ error: 'Internal Server Error' });
        }
    });
});






/// Ruta para actualizar comunidad
app.put('/Comunidad', (req, res) => {
    const {
        P_ACCION, P_NOM_COMUNIDAD, P_DIRECC_COMUNIDAD, P_CANT_FAMILIAS, P_COD_COMUNIDAD,
        P_COD_HOGAR, P_NUM_FAMILIARES, P_TIP_VIVIENDA, P_PROFESION_OFICIO, P_RELIGION,
        P_CANT_MATRIMONIO, P_CANT_BAUTISMO, P_CANT_COMUNION, P_CANT_CONFRIMACION, P_MISA,
        P_GRUP_PARROQUIAL, P_ESTRATO_FAMILIAR
    } = req.body;

    // Llamar al procedimiento almacenado para actualizar el registro de la comunidad
    pool.query(
        'CALL UPD_COMUNIDAD(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)',
        [
            P_ACCION, P_NOM_COMUNIDAD, P_DIRECC_COMUNIDAD, P_CANT_FAMILIAS, P_COD_COMUNIDAD,
            P_COD_HOGAR, P_NUM_FAMILIARES, P_TIP_VIVIENDA, P_PROFESION_OFICIO, P_RELIGION,
            P_CANT_MATRIMONIO, P_CANT_BAUTISMO, P_CANT_COMUNION, P_CANT_CONFRIMACION, P_MISA,
            P_GRUP_PARROQUIAL, P_ESTRATO_FAMILIAR
        ],
        (err, results) => {
            if (err) {
                console.error('Error ejecutando el procedimiento UPD_COMUNIDAD:', err);
                return res.status(500).json({ error: 'Error al actualizar la comunidad' });
            }
            res.status(200).json({ message: 'Registro actualizado correctamente' });
        }
    );
});


//****************************************************** */
// ------------------- MODULO DE BIENES ---------------
//****************************************************** */
app.get('/bienes', (req, res) => {
    // Llamar al procedimiento almacenado SEL_BIENES
    pool.query('CALL SEL_BIENES()', (err, results) => {
        if (err) {
            console.error('Error al ejecutar el procedimiento SEL_BIENES:', err);
            return res.status(500).json({ error: 'Error al obtener los datos de bienes.' });
        }

        // Los resultados están en results[0]
        res.json(results[0]);
    });
});

app.post('/insertBien', (req, res) => {
    let params = req.body;
    const sql = "CALL INS_BIENES(?, ?, ?, ?, ?, ?, ?)";
    
    pool.query(sql, [
        params.p_tip_bien,
        params.p_des_objeto,
        params.p_cant_bien,
        params.p_costo_adquisicion,
        params.p_fech_adquisicion,
        params.p_est_objeto,
        params.p_observaciones
    ], (err, results) => {
        if (!err) {
            // Asumiendo que el mensaje está en la primera fila de la primera columna del resultado
            res.send(results[0][0].Message);
        } else {
            console.error(err);
            res.status(500).send("Error al insertar el registro");
        }
    });
});

app.put('/updateBien/:p_cod_bien', (req, res) => {
    const {
        p_tip_bien, p_des_objeto, p_cant_bien, p_costo_adquisicion,
        p_fech_adquisicion, p_est_objeto, p_observaciones
    } = req.body;
    const { p_cod_bien } = req.params;

    // Llamar al procedimiento almacenado para actualizar el bien
    pool.query(
        'CALL UPD_BIENES(?, ?, ?, ?, ?, ?, ?, ?)',
        [
            p_cod_bien, p_tip_bien, p_des_objeto, p_cant_bien, p_costo_adquisicion,
            p_fech_adquisicion, p_est_objeto, p_observaciones
        ],
        (err, rows, fields) => {
            if (err) {
                console.error('Error ejecutando el procedimiento UPD_BIENES:', err);
                return res.status(500).json({ error: 'Error al actualizar el bien' });
            }
            // El mensaje de éxito está en rows[0][0].Message según la estructura del procedimiento
            res.status(200).json({ message: rows[0][0].Message });
        }
    );
});


//************************************************************************************************ */
//************************************************************************************************ */
//************************************************************************************************ */
//************************************************************************************************ */



//*************get finanzas******************************
// Ruta para obtener finanzas
app.get('/api/finanzas', (req, res) => {
    const tablaTipo = req.query.tablaTipo.toUpperCase();

    // Validar el tipo de tabla
    const tiposValidos = ['CUENTA', 'CONSULTA MES', 'FINANZA'];
    if (!tiposValidos.includes(tablaTipo)) {
        return res.status(400).json({ error: 'Tipo de tabla no válido' });
    }

    // Llamar al procedimiento almacenado para obtener los datos
    pool.query('CALL SEL_FINANZAS(?)', [tablaTipo], (err, results) => {
        if (err) {
            console.error('Error ejecutando el procedimiento SEL_FINANZAS:', err);
            return res.status(500).json({ error: 'Error al obtener los datos de finanzas' });
        }
        res.status(200).json(results[0]);
    });
});



// ************************ Insert Finanzas ************************


// Insert <-> Post con procedimiento almacenado
app.post('/finanzas', (req, res) => {
    let finanzas = req.body;
    console.log('Datos recibidos:', finanzas); // Log para ver los datos recibidos
    var sql = "CALL INS_FINANZAS(?, ?, ?, ?, ?, ?, ?, ?);";
    
    pool.getConnection((err, connection) => {
        if (err) {
            console.error('Error al obtener la conexión:', err);
            return res.status(500).send("Error al obtener la conexión a la base de datos");
        }

        connection.query(sql, [
            finanzas.P_TIPO_TABLA, finanzas.P_NOM_CUENTA, finanzas.P_TIPO_CUENTA, finanzas.P_COD_CUENTA,
            finanzas.P_OBSERVACIONES, finanzas.P_TIPO_TRANSACCION, finanzas.P_MONTO, finanzas.P_FECHA
        ], (err, rows, fields) => {
            connection.release();

            if (!err) {
                res.send("Transacción registrada con éxito!!");
            } else {
                console.error('Error al ejecutar la consulta:', err);
                res.status(500).send("Error al insertar la transacción");
            }
        });
    });
});

// ************************ Update Finanzas ************************
// Update <-> Put con procedimiento almacenado

app.put('/finanzas/:P_COD_FINANZAS', (req, res) => {
    const {
        P_TIPO_TABLA, P_NOM_CUENTA, P_TIPO_CUENTA, P_COD_CUENTA,
        P_OBSERVACIONES, P_TIPO_TRANSACCION, P_MONTO, P_FECHA
    } = req.body;
    const { P_COD_FINANZAS } = req.params;

    // Log de los datos recibidos
    console.log('Datos recibidos:', req.body);
    console.log('ID de Finanzas:', P_COD_FINANZAS);

    // Llamar al procedimiento almacenado para actualizar las finanzas
    pool.query(
        'CALL UPD_FINANZAS(?, ?, ?, ?, ?, ?, ?, ?, ?)',
        [
            P_TIPO_TABLA, P_NOM_CUENTA, P_TIPO_CUENTA, P_COD_CUENTA,
            P_COD_FINANZAS, P_OBSERVACIONES, P_TIPO_TRANSACCION, P_MONTO, P_FECHA
        ],
        (err, rows, fields) => {
            if (err) {
                console.error('Error ejecutando el procedimiento UPD_FINANZAS:', err);
                return res.status(500).json({ error: 'Error al actualizar el registro' });
            }
            res.status(200).json({ message: 'Transacción actualizada con éxito' });
        }
    );
});

//***********************************************************************
//*********************************************************************
//*********************************************************************
//*********************************************************************
//*********************************************************************
//*********************************************************************
//*********************************************************************



// GET para obtener una beca por COD_PERSONAS
app.get('/becas', (req, res) => {
    // Llamar al procedimiento almacenado para obtener los datos de becas
    pool.query('CALL SEL_BECA()', (err, rows, fields) => {
        if (err) {
            console.error('Error ejecutando el procedimiento SEL_BECA:', err);
            return res.status(500).json({ error: 'Error al obtener los datos de las becas' });
        }
        // La primera fila de resultados contiene los datos
        res.status(200).json(rows[0]);
    });
});


// POST para insertar una nueva beca

// Ruta para insertar una nueva beca
app.post('/becas', (req, res) => {
    let beca = req.body;
    console.log('Datos recibidos:', beca); // Log para ver los datos recibidos
    var sql = "CALL INS_BECA(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    
    pool.getConnection((err, connection) => {
        if (err) {
            console.error('Error al obtener la conexión:', err);
            return res.status(500).send("Error al obtener la conexión a la base de datos");
        }

        connection.query(sql, [
            beca.p_cod_personas, beca.p_carrera, beca.p_duracion, beca.p_ayuda,
            beca.p_horas_trabajo_pastoral, beca.p_registro_avance, beca.p_estado,
            beca.p_fecha_inicio, beca.p_fecha_fin, beca.p_observaciones
        ], (err, rows, fields) => {
            connection.release();

            if (!err) {
                res.send("Beca registrada con éxito!!");
            } else {
                console.error('Error al ejecutar la consulta:', err);
                res.status(500).send("Error al registrar la beca");
            }
        });
    });
});



// PUT para actualizar una beca
app.put('/becas/:p_cod_beca', (req, res) => {
    const {
        p_cod_personas, p_carrera, p_duracion, p_ayuda, p_horas_trabajo_pastoral,
        p_registro_avance, p_estado, p_fecha_inicio, p_fecha_fin, p_observaciones
    } = req.body;
    const { p_cod_beca } = req.params;

    // Llamar al procedimiento almacenado para actualizar la beca
    pool.query(
        'CALL UPD_BECA(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
        [
            p_cod_beca, p_cod_personas, p_carrera, p_duracion, p_ayuda,
            p_horas_trabajo_pastoral, p_registro_avance, p_estado,
            p_fecha_inicio, p_fecha_fin, p_observaciones
        ],
        (err, results) => {
            if (err) {
                console.error('Error ejecutando el procedimiento UPD_BECA:', err);
                return res.status(500).json({ error: 'Error al actualizar la beca' });
            }
            // El mensaje de éxito está en results[0][0].mensaje según la estructura del procedimiento
            res.status(200).json({ message: results[0][0].mensaje });
        }
    );
});

///////////////////////////////////////////////////////////
 /////              --- MODULO AGENDA ---              /////
///////////////////////////////////////////////////////////


app.get('/agenda/:tipo', (req, res) => {
    const tipo = req.params.tipo.toUpperCase();
   

    // Validar el tipo de consulta
    const tiposValidos = ['TIPO_EVENTOS', 'AGENDA', 'SOLICITUD_SERVICIOS'];
    if (!tiposValidos.includes(tipo)) {
        return res.status(400).json({ error: 'Tipo de consulta no válido' });
    }

    pool.query('CALL SEL_AGENDA(?)', [tipo], (err, rows, fields) => {
        if (!err) {
            res.status(200).json(rows[0]);
        } else {
            console.error('Error ejecutando el procedimiento almacenado:', err);
            res.status(500).json({ error: 'Internal Server Error' });
        }
    });
});





app.post('/agenda', (req, res) => {
    let agenda = req.body;
    var sql = "CALL INS_AGENDA(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    
    pool.getConnection((err, connection) => {
        if (err) {
            console.error('Error al obtener la conexión:', err);
            return res.status(500).send("Error al obtener la conexión a la base de datos");
        }

        connection.query(sql, [
            agenda.p_tabla_tipo, 
            agenda.p_nombre, 
            agenda.p_cod_tip_evento, 
            agenda.p_fec_hrs_evento, 
            agenda.p_duracion_evento, 
            agenda.p_lugar, 
            agenda.p_descripcion, 
            agenda.p_responsable, 
            agenda.p_estado, 
            agenda.p_observaciones, 
            agenda.p_desc_evento, 
            agenda.p_nom_solicitante, 
            agenda.p_tel_solicitante, 
            agenda.p_fec_hrs_servicio, 
            agenda.p_obs_solicitud, 
            agenda.p_fec_registro,
            agenda.p_estado
        ], (err, rows, fields) => {
            connection.release();

            if (!err) {
                res.send("Registro ingresado con éxito!!");
            } else {
                console.error('Error al ejecutar la consulta:', err);
                res.status(500).send("Error al insertar el registro");
            }
        });
    });
});

// PUT para actualizar un evento/solicitud/agenda
app.put('/agenda/:p_cod_tip_evento', (req, res) => {
    const {
        p_tabla_tipo,
        p_nombre,
        p_fec_hrs_evento,
        p_duracion_evento,
        p_lugar,
        p_descripcion,
        p_responsable,
        p_estado,
        p_observaciones,
        p_desc_evento,
        p_nom_solicitante,
        p_tel_solicitante,
        p_fec_hrs_servicio,
        p_obs_solicitud,
        p_fec_registro
    } = req.body;
    const { p_cod_tip_evento } = req.params;

    // Llamar al procedimiento almacenado para actualizar
    pool.query(
        'CALL UPD_AGENDA(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
        [
            p_tabla_tipo,
            p_cod_tip_evento,
            p_nombre,
            p_fec_hrs_evento,
            p_duracion_evento,
            p_lugar,
            p_descripcion,
            p_responsable,
            p_estado,
            p_observaciones,
            p_desc_evento,
            p_nom_solicitante,
            p_tel_solicitante,
            p_fec_hrs_servicio,
            p_obs_solicitud,
            p_fec_registro
        ],
        (err, results) => {
            if (err) {
                console.error('Error ejecutando el procedimiento UPD_AGENDA:', err);
                return res.status(500).json({ error: 'Error al actualizar la agendao' });
            }
            if (!results || !results[0] || !results[0][0]) {
                return res.status(500).json({ error: 'Respuesta inesperada del procedimiento almacenado' });
            }
            res.status(200).json({ message: results[0][0].Message });
        }
    );
});





const express = require("express");
const router = express.Router();
const db = require("./db");
const twilio = require("twilio");


router.get("/departamentos", (req, res) => {
  let sql = "SELECT * FROM departamentos";
  db.query(sql, (err, results) => {
    if (err) throw err;
    res.json(results);
  });
});

router.get("/tipos", (req, res) => {
  let sql = "SELECT * FROM tipospersonas";
  db.query(sql, (err, results) => {
    if (err) throw err;
    res.json(results);
  });
});

router.get("/cargos", (req, res) => {
  let sql = "SELECT * FROM cargos";
  db.query(sql, (err, results) => {
    if (err) throw err;
    res.json(results);
  });
});

router.get("/residentes", (req, res) => {
  let sql = "SELECT * FROM residentes";
  db.query(sql, (err, results) => {
    if (err) throw err;
    res.json(results);
  });
});

router.get("/visitantes", (req, res) => {
    let sql = "SELECT visitantes.id, visitantes.documento_visitante, visitantes.nombre_visitante, visitantes.apellido_visitante, tipospersonas.descripcion FROM visitantes INNER JOIN tipospersonas ON visitantes.id_tipo_visitante = tipospersonas.id";

    db.query(sql, (err, results) => {
      if (err) throw err;
      res.json(results);
    });
  });

router.get("/personas", (req, res) => {
  let sql =
    "SELECT personas.documento, personas.nombre_persona, personas.apellido, personas.correo, personas.fecha_contratacion, cargos.nombre_cargo, departamentos.nombre_dpto FROM personas INNER JOIN cargos ON cargos.id=personas.cargo_id INNER JOIN departamentos ON departamentos.id=personas.departamento_id";
  db.query(sql, (err, results) => {
    if (err) throw err;
    res.json(results);
  });
});

router.get("/visitas", (req, res) => {
  let sql =     "SELECT visitas.id, visitas.visitante_id, visitas.residente_id, visitas.fecha_ingreso, visitas.fecha_salida, visitas.motivo_visita, visitas.vehiculo, residentes.nombre, residentes.apellido, residentes.apartamento, visitantes.documento_visitante, visitantes.nombre_visitante, visitantes.apellido_visitante, visitantes.id_tipo_visitante, tipospersonas.id AS tipo_persona_id FROM visitas LEFT JOIN residentes ON visitas.residente_id = residentes.id LEFT JOIN visitantes ON visitas.visitante_id = visitantes.id LEFT JOIN tipospersonas ON visitantes.id_tipo_visitante = tipospersonas.id ORDER BY visitas.id DESC;";
  db.query(sql, (err, results) => {
    if (err) throw err;
    res.json(results);
  });
});

router.post("/departamentosadd", (req, res) => {
  const { nombre_dpto, lider_id } = req.body;

  if (!nombre_dpto || !lider_id) {
    return res.status(400).json({ success: false, error: "nombre_dpto y lider_id son requeridos" });
  }

  let sql = "INSERT INTO departamentos (nombre_dpto, lider_id) VALUES (?, ?)";
  db.query(sql, [nombre_dpto, lider_id], (err, result) => {
    if (err) {
      console.error("Error al insertar departamento:", err);
      return res.status(500).json({ success: false, error: "Error al insertar departamento" });
    }
    res.json({
      success: true,
      message: "Departamento agregado",
      departamentoId: result.insertId,
    });
  });
});



router.post("/personasadd", (req, res) => {
  const {documento, nombre_persona, apellido, correo, telefono, fecha_contratacion, 
    cargo_id, departamento_id
  } = req.body;

  // Validación de los campos recibidos
  if (
    !documento ||!nombre_persona ||!apellido ||!correo ||!telefono ||!fecha_contratacion ||!cargo_id ||!departamento_id 
  ) {
    return res.status(400).json({ success: false, error: "Todos los campos son requeridos" });
  }

  const createdAt = new Date();
  const updatedAt = new Date();

  let sql = "INSERT INTO personas (documento, nombre_persona, apellido, correo, telefono,fecha_contratacion, cargo_id, departamento_id,created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  db.query(sql, [
    documento, nombre_persona, apellido, correo, telefono,
    fecha_contratacion, cargo_id, departamento_id,
    createdAt, updatedAt
  ], (err, result) => {
    if (err) {
      console.error("Error al insertar colaborador:", err);
      return res.status(500).json({ success: false, error: "Error al insertar colaborador" });
    }
    res.json({
      success: true,
      message: "Colaborador agregado",
      personaId: result.insertId,
    });
  });
});


router.post("/visitantesadd", (req, res) => {
  const { documento_visitante, nombre_visitante, apellido_visitante, id_tipo_visitante } = req.body;

  if (!documento_visitante || !nombre_visitante || !apellido_visitante || !id_tipo_visitante) {
    return res.status(400).json({ success: false, error: "Faltan parámetros" });
  }

  let sql = "INSERT INTO `visitantes`(`documento_visitante`, `nombre_visitante`, `apellido_visitante`, `id_tipo_visitante`) VALUES (?, ?, ?, ?)";

  db.query(sql, [documento_visitante, nombre_visitante, apellido_visitante, id_tipo_visitante], (err, result) => {
    if (err) {
      console.error("Error al insertar visitante:", err);
      return res.status(500).json({ success: false, error: "Error al insertar visitante" });
    }
    res.json({
      success: true,
      message: "Visitante agregado",
      visitanteId: result.insertId,
    });
  });
});

router.post("/residentesadd", (req, res) => {
  const { documento, nombre, apellido, edad, telefono, correo, apartamento, mascota, condicion, discapacidad } = req.body;

  // Verificar que los campos obligatorios no estén vacíos
  if (!documento || !nombre || !apellido || !edad || !apartamento) {
    return res.status(400).json({ success: false, error: "Faltan parámetros obligatorios" });
  }

  // Inserción en la base de datos
  let sql = "INSERT INTO `residentes`(`documento`, `nombre`, `apellido`, `edad`, `correo`, `telefono`, `apartamento`, `mascota`, `condicion`, `discapacidad`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";

  db.query(sql, [documento, nombre, apellido, edad, correo || null, telefono || null, apartamento, mascota || null, condicion || null, discapacidad || null], (err, result) => {
    if (err) {
      console.error("Error al insertar residente:", err);
      return res.status(500).json({ success: false, error: "Error al insertar residente" });
    }
    res.json({
      success: true,
      message: "Residente agregado",
      residenteId: result.insertId,
    });
  });
});




router.post('/visitasadd', (req, res) => {
  const { visitante_id, residente_id, fecha_ingreso, vehiculo, motivo_visita } = req.body;

  // Verificar que los campos obligatorios no estén vacíos
  if (!visitante_id || !residente_id || !motivo_visita) {
      return res.status(400).json({ success: false, error: "Faltan parámetros obligatorios" });
  }

  // Inserción en la base de datos
  let sql = "INSERT INTO `visitas`(`visitante_id`, `residente_id`, `fecha_ingreso`, `vehiculo`, `motivo_visita`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, now(), now())";
  db.query(sql, [visitante_id, residente_id, fecha_ingreso || null, vehiculo || null, motivo_visita], (err, result) => {
      if (err) {
          console.error("Error al insertar visita:", err);
          return res.status(500).json({ success: false, error: "Error al insertar visita" });
      }
      res.json({
          success: true,
          message: "Visita agregada",
          residenteId: result.insertId,
      });
  });
});

// Obtener detalles de una visita específica
router.get("/visitas/:id", (req, res) => {
  const { id } = req.params;
  let sql = `SELECT visitas.id, visitas.visitante_id, visitas.residente_id, visitas.fecha_ingreso, visitas.fecha_salida, visitas.motivo_visita, visitas.vehiculo, residentes.nombre, residentes.apellido, residentes.apartamento, visitantes.documento_visitante, visitantes.nombre_visitante, visitantes.apellido_visitante, visitantes.id_tipo_visitante FROM visitas LEFT JOIN residentes ON visitas.residente_id = residentes.id LEFT JOIN visitantes ON visitas.visitante_id = visitantes.id WHERE visitas.id = ?`;
  db.query(sql, [id], (err, result) => {
    if (err) throw err;
    res.json(result[0]);
  });
});

// Actualizar una visita
router.put("/visitas/:id", (req, res) => {
  const { id } = req.params;
  const updatedData = req.body;
  let sql = `UPDATE visitas SET ? WHERE id = ?`;
  db.query(sql, [updatedData, id], (err, result) => {
    if (err) throw err;
    res.json({ message: "Visita actualizada con éxito" });
  });
});


module.exports = router;


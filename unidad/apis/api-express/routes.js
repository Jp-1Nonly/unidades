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

router.get("/visitantes", (req, res) => {
    let sql = "SELECT documento_visitante,  nombre_visitante, apellido_visitante, descripcion FROM visitantes INNER JOIN tipospersonas ON visitantes.id_tipo_visitante=tipospersonas.id";
    db.query(sql, (err, results) => {
      if (err) throw err;
      res.json(results);
    });
  });

router.get("/personas", (req, res) => {
  let sql =
    "SELECT personas.nombre_persona, personas.apellido, personas.correo, personas.fecha_contratacion, cargos.nombre_cargo, departamentos.nombre_dpto FROM personas INNER JOIN cargos ON cargos.id=personas.cargo_id INNER JOIN departamentos ON departamentos.id=personas.departamento_id";
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
  const {
    documento,
    nombre_persona,
    apellido,
    correo,
    telefono,
    fecha_contratacion,
    cargo_id,
    departamento_id
  } = req.body;

  // Validación de los campos recibidos
  if (
    !documento ||
    !nombre_persona ||
    !apellido ||
    !correo ||
    !telefono ||
    !fecha_contratacion ||
    !cargo_id ||
    !departamento_id 
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




module.exports = router;

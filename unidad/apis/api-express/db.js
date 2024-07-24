const mysql = require('mysql');

const db = mysql.createConnection({
    host: 'localhost', 
    user: 'oscarcaas_bases', 
    password: 'Ingresar2025$', 
    database: 'oscarcaas_unidades' 
});

db.connect(err => {
    if (err) {
        throw err;
    }
    console.log('Conectado a la base de datos MySQL');
});

module.exports = db;

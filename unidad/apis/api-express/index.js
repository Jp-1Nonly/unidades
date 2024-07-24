const express = require('express');
const bodyParser = require('body-parser');
const db = require('./db'); // archivo db.js
const routes = require('./routes'); // archivo routes.js

const app = express();
const port = 3000;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

app.use('/api', routes);

app.get('/', (req, res) => {
    res.send('API de artículos');
});

app.listen(port, () => {
    console.log(`Servidor iniciado en el puerto ${port}`);
});

var express = require('express');
var router = express.Router();
const { DatabaseSync } = require('node:sqlite');
const path = require('node:path');
const dbPath = path.resolve(__dirname, '..', 'data.db');
const db = new DatabaseSync(dbPath);

router.post('/create', function(req, res, next) {
    try {
        const { brand, size, color } = req.body;

        const result = db
            .prepare('INSERT INTO wheels (brand, size, color) VALUES (?, ?, ?)')
            .run(brand, size, color);

        return res.redirect('/wheels');
    } catch (err) {
        console.log(err);
        next(err);
    }
});

router.post('/edit', function(req, res, next) {
    try {
        const { wheels_id, new_brand, size, color } = req.body;

        db.prepare('UPDATE wheels SET brand = ?, size = ?, color = ? WHERE id = ?')
            .run(new_brand, size, color, wheels_id);

        return res.redirect('/wheels');
    } catch (err) {
        next(err);
    }
});

router.get('/', function(req, res, next) {
    res.render('wheels');
});

module.exports = router;
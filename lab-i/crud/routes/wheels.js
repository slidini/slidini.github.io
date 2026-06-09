var express = require('express');
var router = express.Router();
const { DatabaseSync } = require('node:sqlite');
const path = require('node:path');

const dbPath = path.resolve(__dirname, '..', 'data.db');
const db = new DatabaseSync(dbPath);

router.get('/', function(req, res, next) {
    try {
        const wheels = db.prepare('SELECT * FROM wheels').all();
        res.render('index', { title: 'Wheels List', bodyClass: 'index', wheels: wheels });
    } catch (err) {
        next(err);
    }
});

router.get('/create', function(req, res) {
    res.render('create', { title: 'Create Wheels', bodyClass: 'edit' });
});


router.post('/create', function(req, res, next) {
    try {
        const { brand, size, color } = req.body;
        db.prepare('INSERT INTO wheels (brand, size, color) VALUES (?, ?, ?)')
            .run(brand, Number(size), color);
        res.redirect('/wheels');
    } catch (err) {
        next(err);
    }
});

router.get('/:id', function(req, res, next) {
    try {
        const wheel = db.prepare('SELECT * FROM wheels WHERE id = ?').get(req.params.id);
        if (!wheel) return res.status(404).send('Not Found');
        res.render('show', { title: "Wheels " + wheel.brand + " (" + wheel.id + ")", bodyClass: 'show', wheel: wheel });
    } catch (err) {
        next(err);
    }
});


router.get('/:id/edit', function(req, res, next) {
    try {
        const wheel = db.prepare('SELECT * FROM wheels WHERE id = ?').get(req.params.id);
        if (!wheel) return res.status(404).send('Not Found');
        res.render('edit', { title: "Edit Wheels " + wheel.brand, bodyClass: 'edit', wheel: wheel });
    } catch (err) {
        next(err);
    }
});


router.post('/:id/edit', function(req, res, next) {
    try {
        const { brand, size, color } = req.body;
        db.prepare('UPDATE wheels SET brand = ?, size = ?, color = ? WHERE id = ?')
            .run(brand, Number(size), color, req.params.id);
        res.redirect('/wheels');
    } catch (err) {
        next(err);
    }
});


router.post('/:id/delete', function(req, res, next) {
    try {
        db.prepare('DELETE FROM wheels WHERE id = ?').run(req.params.id);
        res.redirect('/wheels');
    } catch (err) {
        next(err);
    }
});

module.exports = router;
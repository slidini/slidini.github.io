from flask import Flask, render_template, request, redirect, url_for
import sqlite3
import os
from datetime import datetime

app = Flask(__name__)
DATABASE = 'data.db'

@app.context_processor
def inject_now():
    return {'year': datetime.now().year}

def get_db_connection():
    conn = sqlite3.connect(DATABASE)
    conn.row_factory = sqlite3.Row
    return conn

def init_db():
    if not os.path.exists(DATABASE):
        conn = get_db_connection()
        with open('sql/Wheels-01.sql', 'r') as f:
            conn.executescript(f.read())
        conn.close()

@app.route('/')
def index():
    return redirect(url_for('wheels_index'))

@app.route('/wheels')
def wheels_index():
    conn = get_db_connection()
    wheels = conn.execute('SELECT * FROM wheels').fetchall()
    conn.close()
    return render_template('wheels/index.html', wheels=wheels)

@app.route('/wheels/<int:id>')
def wheels_show(id):
    conn = get_db_connection()
    wheel = conn.execute('SELECT * FROM wheels WHERE id = ?', (id,)).fetchone()
    conn.close()
    if wheel is None:
        return "Wheel not found", 404
    return render_template('wheels/show.html', wheel=wheel)

@app.route('/wheels/create', methods=('GET', 'POST'))
def wheels_create():
    if request.method == 'POST':
        brand = request.form.get('wheel[brand]')
        size = request.form.get('wheel[size]')
        color = request.form.get('wheel[color]')

        conn = get_db_connection()
        conn.execute('INSERT INTO wheels (brand, size, color) VALUES (?, ?, ?)',
                     (brand, size, color))
        conn.commit()
        conn.close()
        return redirect(url_for('wheels_index'))

    return render_template('wheels/create.html', wheel=None)

@app.route('/wheels/edit/<int:id>', methods=('GET', 'POST'))
def wheels_edit(id):
    conn = get_db_connection()
    wheel = conn.execute('SELECT * FROM wheels WHERE id = ?', (id,)).fetchone()

    if request.method == 'POST':
        brand = request.form.get('wheel[brand]')
        size = request.form.get('wheel[size]')
        color = request.form.get('wheel[color]')

        conn.execute('UPDATE wheels SET brand = ?, size = ?, color = ? WHERE id = ?',
                     (brand, size, color, id))
        conn.commit()
        conn.close()
        return redirect(url_for('wheels_index'))

    conn.close()
    if wheel is None:
        return "Wheel not found", 404
    return render_template('wheels/edit.html', wheel=wheel)

@app.route('/wheels/delete/<int:id>', methods=('POST',))
def wheels_delete(id):
    conn = get_db_connection()
    conn.execute('DELETE FROM wheels WHERE id = ?', (id,))
    conn.commit()
    conn.close()
    return redirect(url_for('wheels_index'))

if __name__ == '__main__':
    init_db()
    app.run(port=57839, debug=True)

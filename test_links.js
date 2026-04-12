const axios = require('axios');
const mysql = require('mysql2/promise');

async function testLinks() {
    const connection = await mysql.createConnection({
        host: '127.0.0.1',
        user: 'root',
        password: '',
        database: 'kemet_db'
    });

    const [rows] = await connection.execute('SELECT id, title, image FROM hotels');
    
    for (let row of rows) {
        if (row.image.startsWith('http')) {
            try {
                const res = await axios.head(row.image, { 
                    timeout: 4000, 
                    headers: { 'User-Agent': 'Mozilla/5.0', 'Referer': 'http://localhost:5173' },
                    validateStatus: function (status) {
                        return status >= 200 && status < 400; // default
                    }
                });
            } catch (error) {
                console.log(`BROKEN [${row.id}] ${row.title}: ${row.image}`);
            }
        }
    }
    
    await connection.end();
}

testLinks();

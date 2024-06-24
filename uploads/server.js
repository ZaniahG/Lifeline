const express = require('express');
const multer = require('multer');
const path = require('path');
const app = express();
const port = 3000;

// Set storage engine
const storage = multer.diskStorage({
    destination: './uploads/',
    filename: function(req, file, cb) {
        cb(null, file.fieldname + '-' + Date.now() + path.extname(file.originalname));
    }
});

// Init upload
const upload = multer({
    storage: storage,
    limits: { fileSize: 1000000 }, // 1MB
    fileFilter: function(req, file, cb) {
        checkFileType(file, cb);
    }
}).single('image');

// Check file type
function checkFileType(file, cb) {
    const filetypes = /jpeg|jpg|png|gif/;
    const extname = filetypes.test(path.extname(file.originalname).toLowerCase());
    const mimetype = filetypes.test(file.mimetype);

    if (mimetype && extname) {
        return cb(null, true);
    } else {
        cb('Error: Images Only!');
    }
}

// Serve static files from the "public" directory
app.use(express.static('public'));

// Upload endpoint
app.post('/upload', (req, res) => {
    upload(req, res, (err) => {
        if (err) {
            res.json({ success: false, message: err });
        } else {
            if (req.file == undefined) {
                res.json({ success: false, message: 'No file selected' });
            } else {
                res.json({
                    success: true,
                    message: 'File uploaded!',
                    filePath: `/uploads/${req.file.filename}`
                });
            }
        }
    });
});

app.listen(port, () => {
    console.log(`Server started on http://localhost:${port}`);
});
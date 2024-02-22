// src/routes/index.js

const express = require('express');
const router = express.Router();
const loginRouter = require('./loginRouter');
const bookListRouter = require('./bookListRouter');
const recordRouter = require('./recordRouter');
const searchBookRouter = require('./searchBookRouter');

// ルーターの統合
router.use(loginRouter);
router.use(bookListRouter);
router.use(recordRouter);
router.use(searchBookRouter);

module.exports = router;

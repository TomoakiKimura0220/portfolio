// src/routes/searchBookRouter.js

const express = require('express');
const router = express.Router();
const { showSearchBook, searchBooks, registerBook, redirectToLogin } = require('../controllers/searchBookController');

router.get('/', showSearchBook);
// 書籍を検索する
router.post('/', searchBooks);
// 書籍を登録する
router.post('/register', registerBook);
// 新しいルートを追加
router.get('/redirect-to-login', redirectToLogin);

module.exports = router;

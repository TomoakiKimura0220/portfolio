// routes/loginRouter.js

const express = require('express');
const loginController = require('../controllers/loginController');

const router = express.Router();

// ログイン画面の表示
router.get('/', loginController.showLoginForm);

// ログイン処理
router.post('/', loginController.login);

module.exports = router;

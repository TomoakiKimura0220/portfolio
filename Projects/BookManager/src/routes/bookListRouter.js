// src/routes/bookListRouter.js

const express = require('express');
const router = express.Router();
const { renderBookList, deleteRecord } = require('../controllers/bookListController');

// ユーザーが登録している本一覧を表示する
router.get('/', renderBookList);

// レコードの削除を行うエンドポイント
router.delete('/delete/:recordId', deleteRecord);

module.exports = router;

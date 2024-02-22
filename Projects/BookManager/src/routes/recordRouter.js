// recordRouter.js

const express = require('express');
const router = express.Router();
const { renderMarkdown, getRecord } = require('../controllers/recordController');

const { renderRecordForm } = require('../controllers/recordController');
const { updateRecord } = require('../controllers/recordController');

// マークダウン形式の内容をHTMLに変換して返すエンドポイント
router.post('/render', renderMarkdown);

// レコードの編集フォームを表示するエンドポイント
router.get('/:recordId', renderRecordForm);

// レコードの更新を行うエンドポイント
router.post('/edit/:recordId', updateRecord);

// GETリクエストに対するエンドポイント
router.get('/', getRecord);

module.exports = router;

// Prismaのインスタンスを作成
const { PrismaClient } = require('@prisma/client');
const prisma = new PrismaClient();

const express = require('express');
const router = express.Router();
const MarkdownIt = require('markdown-it');
const markdown = new MarkdownIt();

// マークダウン形式の内容をHTMLに変換して返す関数
const renderMarkdown = (req, res, next) => {
    try {
        const source = req.body.source;
        const renderedContent = markdown.render(source);
        res.json({ render: renderedContent });
    } catch (error) {
        console.error('Error rendering markdown:', error);
        res.status(500).json({ error: 'Internal Server Error' });
    }
};

// GETリクエストに対するハンドラ
const getRecord = (req, res) => {
    res.send('Hello Record!');
};

const renderRecordForm = async (req, res, next) => {
    try {
        // レコードのIDを取得
        const recordId = req.params.recordId;

        // Prisma を使ってレコードをデータベースから取得
        const record = await prisma.bOOK_READING_RECORDS_TABLE.findUnique({
            where: {
                Record_ID: parseInt(recordId),
            },
        });

        // レコードが存在しない場合はエラーを返す
        if (!record) {
            console.error(`Record not found for ID: ${recordId}`);
            return res.status(404).send('Record not found');
        }

        // マークダウン形式の内容をHTMLに変換
        const renderedContent = markdown.render(record.Record_Content);
        console.log('renderedContent:', renderedContent);

        // レコードの情報を使って編集フォームを表示
        res.render('recordForm', { title: 'Edit Record', record, renderedContent });
    } catch (error) {
        console.error('Error rendering record form:', error);
        res.status(500).send('Internal Server Error');
    }
};




// 読書記録の更新処理
const updateRecord = async (req, res) => {
    //const recordId = req.params.id;
    const recordId = req.params.recordId;
    const { content } = req.body;

    console.log('Updating record:', recordId);
    console.log('New content:', content);

    try {
        // 読書記録を更新
        const updatedRecord = await prisma.bOOK_READING_RECORDS_TABLE.update({
            where: { 
                Record_ID: parseInt(recordId) 
            },
            data: {
                Record_Content: content 
            }
        });

        // 更新後の読書記録をクライアントに返す
        res.json({ success: true, updatedRecord });
        console.log('Record updated successfully:', updatedRecord);
    } catch (error) {
        console.error('Error updating record:', error);
        res.status(500).json({ success: false, error: 'Internal Server Error' });
    }
};

module.exports = { renderMarkdown, getRecord, renderRecordForm, updateRecord };

// src/controllers/bookListController.js

const { PrismaClient } = require('@prisma/client');
const prisma = new PrismaClient();

// ユーザーが登録した本の一覧を表示する
const renderBookList = async (req, res) => {
    try {
        // セッションからユーザー情報を取得
        const user = req.session.user;

        // ユーザーがログインしていない場合はログインページにリダイレクト
        if (!user) {
            res.redirect('/login');
            return;
        }

        // ユーザーが登録した本の一覧をデータベースから取得
        const books = await prisma.bOOK_READING_RECORDS_TABLE.findMany({
            where: { Record_User_ID: user.id },
        });

        // bookList.ejs にデータを渡して表示
        res.render('bookList', { title: 'Book List', user, books });
    } catch (error) {
        console.error('本一覧表示エラー:', error);
        res.status(500).send('Internal Server Error');
    }
};

// レコードの削除を行う
const deleteRecord = async (req, res) => {
    const recordId = req.params.recordId;

    try {
        // 読書記録を削除
        const deletedRecord = await prisma.bOOK_READING_RECORDS_TABLE.delete({
            where: {
                Record_ID: parseInt(recordId),
            },
        });

        // 削除が成功したことをクライアントに返す
        res.json({ success: true, deletedRecord });
    } catch (error) {
        console.error('Error deleting record:', error);
        res.status(500).json({ success: false, error: 'Internal Server Error' });
    }
};

module.exports = { renderBookList, deleteRecord };

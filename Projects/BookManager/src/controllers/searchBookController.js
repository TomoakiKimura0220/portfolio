// src/controllers/searchBookController.js

const fetch = require('node-fetch');
const { PrismaClient } = require('@prisma/client');
const prisma = new PrismaClient();

// 書籍検索画面を表示
exports.showSearchBook = (req, res) => {
    res.render('searchBook', { title: '書籍検索' });
};

// 書籍を検索
exports.searchBooks = async (req, res) => {

    const { textValue } = req.body;

    try {
        const response = await fetch(`https://www.googleapis.com/books/v1/volumes?q=${textValue}&maxResults=40`);
        const data = await response.json();
        console.log('data:', data);

        res.json({ success: true, data });
    } catch (error) {
        console.error('Error fetching book data:', error);
        res.json({ success: false, data: error.message });
    }
};

// 書籍を登録
exports.registerBook = async (req, res) => {
    const { book } = req.body;
    const user = req.session.user;

    try {
        //console.log('req.session.user.id:',user.id);
        // データベースに本を登録
        const createdBook = await prisma.BOOK_READING_RECORDS_TABLE.create({
            data: {
                // ここに本の情報を指定
                Record_User_ID: user.id, // セッションから取得したユーザーのIDを使用
                Record_Title: book.title,
                Record_Book_Image_Url: book.image_url,
                Record_Content: "# " + book.title, // "# "+book.titleを設定
                // 他にも必要な情報があれば適切に指定
            },
        });

        res.json({ success: true, createdBook });
        //alert('登録が成功しました');
    } catch (error) {
        console.error('Error registering book:', error);
        res.json({ success: false, error: error.message });
    }
};

// ログインページにリダイレクト
exports.redirectToLogin = (req, res) => {
    // セッションからユーザー情報を取得
    const user = req.session.user;

    // ユーザーがログインしていない場合はログインページにリダイレクト
    if (!user) {
        res.redirect('/login');
        return;
    }
};
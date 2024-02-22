// src/index.js
const { PrismaClient } = require('@prisma/client');
const prisma = new PrismaClient();

const express = require('express');
const session = require('express-session');
const path = require('path');
const loginRouter = require('./routes/loginRouter');
const bookListRouter = require('./routes/bookListRouter');
const searchBookRouter = require('./routes/searchBookRouter');
const recordRouter = require('./routes/recordRouter');

const app = express();
const port = 3000;

app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

app.use(express.static(path.join(__dirname, 'public')));
app.use(express.static(path.join(__dirname, 'public'), { 'Content-Type': 'text/css' }));
app.use(express.json());
app.use(express.urlencoded({ extended: false }));

app.use(session({
    secret: 'secret',// セッションIDの暗号化に利用するキー、自動生成の方がいい
    resave: false,
    saveUninitialized: false,
    cookie: {
        httpOnly: true,
        secure: false,
        maxAge: 1000 * 60 * 30,
    },
}));

// ログイン関連のルート
app.use('/login', loginRouter);
//ユーザーの登録済み本一覧表示関連のルート
app.use('/bookList', bookListRouter);
// 書籍検索関連のルート
app.use('/search', searchBookRouter);
// ユーザーの読書記録関連のルート
app.use('/record', recordRouter);

app.get('/', (req, res) => {
    res.send('Hello World!');
});

app.listen(port, () => {
    console.log(`Server is running on http://localhost:${port}/login`);
});

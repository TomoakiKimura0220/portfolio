// controllers/loginController.js

const { PrismaClient } = require('@prisma/client');
const prisma = new PrismaClient();

// ログインフォームの表示
exports.showLoginForm = (req, res) => {
    res.render('login', { title: 'Login Page', error: null }); // エラーがない場合は null を渡す
};

// ログイン処理
exports.login = async (req, res) => {
    const { username, password } = req.body;

    try {
        // ユーザー名とパスワードでユーザーを検索
        const user = await prisma.USERS_TABLE.findUnique({
            where: { User_Name: username },
        });

        // ユーザーが存在し、パスワードが一致する場合
        if (user && user.User_Password === password) {
            // ログイン成功時の処理
            // セッションなどにユーザー情報を保存する
            req.session.user = { id: user.User_ID, username: user.User_Name };
            // ユーザーが登録した本一覧画面にリダイレクト
            res.redirect('/bookList');
        } else {
            // ログイン失敗時の処理
            // ログインフォームにエラーメッセージを含めて再表示
            res.render('login', { title: 'ログイン', error: 'ユーザー名またはパスワードが正しくありません。' });
        }
    } catch (error) {
        console.error('ログイン処理エラー:', error);
        res.status(500).send('Internal Server Error');
    }
};

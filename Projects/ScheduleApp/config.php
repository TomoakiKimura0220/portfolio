<?php
// ----------------------------------------------------------------
//オンラインリンク設定ファイル
// ----------------------------------------------------------------
//プログラム定数
define("DEFSCR","log");//デフォルト画面
define("AUTHADMIN","1");//管理セッション識別用

//ユーザ用設定
define("APPNAME","スケジュール管理用WEBアプリケーション");//アプリケーション名
define("PAGESIZE","10");//1ページ表示数
define("ENCDISP","UTF-8");//表示文字コード
define("ENCDB","UTF-8");//データベース文字コード

//管理者用設定
define("ADMINAPPNAME","スケジュール管理用Webアプリ");//アプリケーション名
define("ADMINPAGESIZE","10");//1ページ表示数
define("LOGINID","testid");//ログインID（要変更）
define("LOGINPASS","testpass");//パスワード（要変更）

//データベース設定
define("DBSV","localhost");
define("DBNAME","SCHEDULE_DB");
define("DBUSER","root");//ユーザ名(要変更)
define("DBPASS","root");//パスワード(要変更)
?>
# portfolio

## 1.書籍管理Webアプリ
### 概要
- 書籍を一括管理できるWebアプリ
- ユーザーごとに書籍の登録とメモが可能

### ビジュアル（UI）の紹介
[![](http://markdown-videos-api.jorgenkh.no/youtube/lPSApYnldCg)](https://youtu.be/lPSApYnldCg)

### 製作期間と製作時期
- 大学の講義内で期末課題として製作
- 実装期間１週間

### 使用技術・言語・ライブラリ
- HTML
- CSS
- JavaScript
- Node.js
- Prisma（SQLite3）
- Express
- Markdown-it

### 特徴や工夫点
- ソースファイルをMVCモデルを模倣したフォルダにて実装した
- GoogleBooksAPIを使用することで書籍の表紙画像を表示することができるようにした
- メモはMarkdown記法で書き込みが可能

### 問題点や今後の展望
- 製作期間が短いため機能が不足している
- 書籍の一覧性を向上させるためにUIの見直しが必要
- GoogleBooksAPIだけでは取得できる書籍の量が少ないため、別の書籍データ取得用APIを費用することで網羅率を上げたい

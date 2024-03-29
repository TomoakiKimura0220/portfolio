# portfolio

## 1.書籍管理Webアプリ
### 概要
- 書籍を一括管理できるWebアプリ
- ユーザーごとに書籍の登録とメモが可能

### デモ動画
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
- GoogleBooksAPIを使用することで書籍の表紙画像を表示することができるようにした
- メモはMarkdown記法で書き込みが可能

### 問題点や今後の展望
- 製作期間が短いため機能が不足している
- 書籍の一覧性を向上させるためにUIの見直しが必要
- GoogleBooksAPIだけでは取得できる書籍の量が少ないため、別の書籍データ取得用APIを費用することで網羅率を上げたい
- MVCモデル学習のためにLaravelでプログラムを置き換えたい

## 2.スケジュール管理用Webアプリ
### 概要
- カレンダー形式でタスクを表示できるスケジュール管理用Webアプリ

### デモ動画
[![](http://markdown-videos-api.jorgenkh.no/youtube/7wY413eWs34)](https://youtu.be/7wY413eWs34)

### 製作期間と製作時期
- 大学の講義内で製作
- 実装期間2週間

### 使用技術・言語・ライブラリ
- PHP8.2.0
- HTML
- MySQL8.2.0
- MAMP 6.8(1258)
- Apache/2.4.54 (Unix)

### 特徴や工夫点
- カレンダーの表示は月別と週別に切り替えができるようにした

### 問題点や今後の展望
- コードのリファクタリングが必要

## 3.MarkdownエディタWebアプリ
### 概要
- 直感的で使いやすいMarkdownエディタを目指した

### デモ動画
[![](http://markdown-videos-api.jorgenkh.no/youtube/3aq7QApzbtw)](https://youtu.be/3aq7QApzbtw)

### 製作期間と製作時期
- JavaScriptの学習のために作成
- 実装期間1週間

### 使用技術・言語・ライブラリ
- HTML
- CSS
- JavaScript
- marked.js
- highlight.js
- Bootstrap

### 特徴や工夫点
- 入力内容のサニタイズ機能
- リアルタイムプレビューの実装
- ツールバーによる使いやすいUI

### 問題点や今後の展望
- 画像のアップロード機能の追加
- エクスポート機能の拡充（他のフォーマットへの対応など）

## 4.Javaオブジェクト指向プログラミングの学習
Javaでオブジェクト指向の３大要素であるカプセル化、継承、多態性(ポリモーフィズム)を学習
- SimpleRPGでカプセル化、継承
- TimesTableで多態性

### SimpleRPG

以下は、SimpleRPGの動作例です。
![](img/SimpleRPG.png)

- キャラクターのステータス値はカプセル化をすることで他のクラスから不正に変更されないようにしています。
- CharactorBaseクラスをHeroクラスとEnemyクラスで継承しています。Heroクラスを継承したArcherクラス、Warriorクラスのように職業を追加することができます。

### TimesTable

以下は、TimesTableの動作例です。
![](img/TimesTable.png)

- TimesTableを実体化する際に設定する引数によって異なる九九表を表示させます。引数によって動作が変わり、異なる形式の九九表を扱うことができるため、この部分において多態性が実現されています。

### 製作期間と製作時期
- 大学の講義内で製作
- 実装期間1日

### 使用技術・言語・ライブラリ
- Java17.0.6


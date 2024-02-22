<?php
// ----------------------------------------------------------------
//オフラインリンク 管理者向けスクリプト
// ----------------------------------------------------------------

//セッションの開始
session_cache_limiter("public");
session_start();

//設定ファイルインクルード
require "config.php";

// ----------------------------------------------------------------
// パラメータ取得
// ----------------------------------------------------------------
//フォームデータ変換
$prmarray=cnv_formstr($_POST);

//表示ページ
if(!chk_auth($prmarray)){
    $act=DEFSCR;
}
elseif(isset($prmarray["act"])){
    $act=$prmarray["act"];
}
else{
    $act=DEFSCR;
}

//処理日時
$dt=date("Y-m-d H:i:s");

// ----------------------------------------------------------------
// 処理開始
// ----------------------------------------------------------------
?>
<?php $conn=db_conn();?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title><?=ADMINAPPNAME?></title>
    </head>
    <body>
        <div align="center">
            <?php
            //画面ルーチンの呼び出し
            call_user_func("screen_".$act,$prmarray);
            ?>
        </div>
    </body>
</html>
<?php db_close($conn);?>
<?php

// ----------------------------------------------------------------
// ログイン画面
// ----------------------------------------------------------------
function screen_log($array){
    ?>
    <h3>ログイン画面</h3>
    <form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
    <table border="1">
        <tr>
            <td>ログインID</td>
            <td><input type="text" name="l_id"></td>
        </tr>
        <tr>
            <td>パスワード</td>
            <td><input type="password" name="l_pass"></td>
        </tr>
        <tr>
            <td>  </td>
            <td><input type="submit" value="ログイン" name="sub1"></td>
        </tr>
    </table>
    <input type="hidden" name="act" value="src">
    </form>
<?php
}

// ----------------------------------------------------------------
// 検索画面
// ----------------------------------------------------------------
function screen_src($array){
    //検索キーワード
    $key=(isset($array["key"])) ? $array["key"] : "";

    //表示するページ
    $p=(isset($array["p"])) ? intval($array["p"]) : 1;
    $p=($p<1) ? 1 : $p;
?>
    <!-- メニュー -->
    <?php disp_menu(); ?>

    <!-- 検索フォーム -->
    <form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
        <table border="0">
        <tr>
            <td><input type="text" name="key" value="<?=$key?>"></td>
            <td><input type="submit" value="検索" name="sub1"></td>
        </tr>
        </table>
        <input type="hidden" name="act" value="src">
    </form>

    <!-- 検索結果 -->
    <?php disp_listdata($key,$p); ?>
<?php
}

// ----------------------------------------------------------------
// 登録画面
// ----------------------------------------------------------------
function screen_ent(){
?>
    <!-- メニュー -->
    <?php disp_menu(); ?>
    <h3>登録画面</h3>

    <!-- 登録フォーム -->
    <form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
        <table border="1">
            <tr>
                <td>開始日時</td>
                <td><input type="datetime-local" name="CONTENT_START_DATETIME" size="100"></td>
            </tr>
            <tr>
                <td>終了日時</td>
                <td><input type="datetime-local" name="CONTENT_END_DATETIME" size="100"></td>
            </tr>
            <tr>
                <td>タイトル</td>
                <td><input type="text" name="CONTENT_TITLE" size="50"></td>
            </tr>
            <tr>
                <td>内容</td>
                <td><input type="text" name="CONTENT_TEXT" size="100"></td>
            </tr>
            <tr>
                <td>場所</td>
                <td><input type="text" name="CONTENT_PLACE" size="100"></td>
            </tr>
            <tr>
                <td>  </td>
                <td><input type="submit" value="登録確認" name="sub1"></td>
            </tr>
        </table>
        <input type="hidden" name="act" value="entconf">
    </form>
<?php
}

// ----------------------------------------------------------------
// 登録確認画面
// ----------------------------------------------------------------
function screen_entconf($array){
    if(!chk_data($array)) {return;}
    extract($array);
?>
    <!-- メニュー -->
    <?php disp_menu(); ?>
    <h3>登録確認画面</h3>

    <!-- 登録データ情報表示 -->
    <form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
        <table border="1">
            <tr>
                <td>開始日時</td>
                <td><?=$CONTENT_START_DATETIME?></td>
            </tr>
            <tr>
                <td>終了日時</td>
                <td><?=$CONTENT_END_DATETIME?></td>
            </tr>
            <tr>
                <td>タイトル</td>
                <td><?=$CONTENT_TITLE?></td>
            </tr>
            <tr>
                <td>内容</td>
                <td><?=$CONTENT_TEXT?></td>
            </tr>
            <tr>
                <td>場所</td>
                <td><?=$CONTENT_PLACE?></td>
            </tr>
            <tr>
                <td>  </td>
                <td><input type="submit" value="登録実行" name="sub1"></td>
            </tr>
        </table>
        <input type="hidden" name="CONTENT_START_DATETIME" value="<?=$CONTENT_START_DATETIME?>">
        <input type="hidden" name="CONTENT_END_DATETIME" value="<?=$CONTENT_END_DATETIME?>">
        <input type="hidden" name="CONTENT_TITLE" value="<?=$CONTENT_TITLE?>">
        <input type="hidden" name="CONTENT_TEXT" value="<?=$CONTENT_TEXT?>">
        <input type="hidden" name="CONTENT_PLACE" value="<?=$CONTENT_PLACE?>">
        <input type="hidden" name="act" value="dojob">
        <input type="hidden" name="kbn" value="ent">
    </form>
<?php
}

// ----------------------------------------------------------------
// 更新画面
// ----------------------------------------------------------------
function screen_upd($array){
    if(!isset($array["CONTENT_ID"])){return;}
    $row=get_data($array["CONTENT_ID"]);
?>
    <!-- メニュー -->
    <?php disp_menu(); ?>
    <h3>更新画面</h3>

    <!-- 更新フォーム -->
    <form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
        <table border="1">
            <tr>
                <td>ID</td>
                <td><?=$row["CONTENT_ID"]?></td>
            </tr>
            <tr>
                <td>開始日時</td>
                <td><input type="datetime-local" name="CONTENT_START_DATETIME" value="<?=$row["CONTENT_START_DATETIME"]?>" size="100"></td>
            </tr>
            <tr>
                <td>終了日時</td>
                <td><input type="datetime-local" name="CONTENT_END_DATETIME" value="<?=$row["CONTENT_END_DATETIME"]?>" size="100"></td>
            </tr>
            <tr>
                <td>タイトル</td>
                <td><input type="text" name="CONTENT_TITLE" value="<?=$row["CONTENT_TITLE"]?>" size="50"></td>
            </tr>
            <tr>
                <td>内容</td>
                <td><input type="text" name="CONTENT_TEXT" value="<?=$row["CONTENT_TEXT"]?>" size="100"></td>
            </tr>
            <tr>
                <td>場所</td>
                <td><input type="text" name="CONTENT_PLACE" value="<?=$row["CONTENT_PLACE"]?>" size="100"></td>
            </tr>
            <tr>
                <td>  </td>
                <td><input type="submit" value="更新確認" name="sub1"></td>
            </tr>
        </table>
        <input type="hidden" name="CONTENT_ID" value="<?=$row["CONTENT_ID"]?>">
        <input type="hidden" name="act" value="updconf">
    </form>
<?php
}

// ----------------------------------------------------------------
// 更新確認画面
// ----------------------------------------------------------------
function screen_updconf($row){
    if(!chk_data($row)){return;}
?>
    <!-- メニュー -->
    <?php disp_menu(); ?>
    <h3>更新確認画面</h3>

    <!-- 更新データ確認表示 -->
    <form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
        <table border="1">
            <tr>
                <td>ID</td>
                <td><?=$row["CONTENT_ID"]?></td>
            </tr>
            <tr>
                <td>開始日時</td>
                <td><?=$row["CONTENT_START_DATETIME"]?></td>
            </tr>
            <tr>
                <td>終了日時</td>
                <td><?=$row["CONTENT_END_DATETIME"]?></td>
            </tr>
            <tr>
                <td>タイトル</td>
                <td><?=$row["CONTENT_TITLE"]?></td>
            </tr>
            <tr>
                <td>内容</td>
                <td><?=$row["CONTENT_TEXT"]?></td>
            </tr>
            <tr>
                <td>場所</td>
                <td><?=$row["CONTENT_PLACE"]?></td>
            </tr>
            <tr>
                <td>  </td>
                <td><input type="submit" value="更新実行" name="sub1"></td>
            </tr>
        </table>
        <input type="hidden" name="CONTENT_ID" value="<?=$row["CONTENT_ID"]?>">
        <input type="hidden" name="CONTENT_START_DATETIME" value="<?=$row["CONTENT_START_DATETIME"]?>">
        <input type="hidden" name="CONTENT_END_DATETIME" value="<?=$row["CONTENT_END_DATETIME"]?>">
        <input type="hidden" name="CONTENT_TITLE" value="<?=$row["CONTENT_TITLE"]?>">
        <input type="hidden" name="CONTENT_TEXT" value="<?=$row["CONTENT_TEXT"]?>">
        <input type="hidden" name="CONTENT_PLACE" value="<?=$row["CONTENT_PLACE"]?>">
        <input type="hidden" name="act" value="dojob">
        <input type="hidden" name="kbn" value="upd">
    </form>
<?php
}

// ----------------------------------------------------------------
// 削除確認画面
// ----------------------------------------------------------------
function screen_delconf($array){
    if(!isset($array["CONTENT_ID"])){return;}
    $row=get_data($array["CONTENT_ID"]);
?>
    <!-- メニュー -->
    <?php disp_menu(); ?>
    <h3>削除確認画面</h3>

    <!-- 削除データ確認表示 -->
    <form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
        <table border="1">
        <tr>
            <td>ID</td>
                <td><?=$row["CONTENT_ID"]?></td>
            </tr>
            <tr>
                <td>開始日時</td>
                <td><?=$row["CONTENT_START_DATETIME"]?></td>
            </tr>
            <tr>
                <td>終了日時</td>
                <td><?=$row["CONTENT_END_DATETIME"]?></td>
            </tr>
            <tr>
                <td>タイトル</td>
                <td><?=$row["CONTENT_TITLE"]?></td>
            </tr>
            <tr>
                <td>内容</td>
                <td><?=$row["CONTENT_TEXT"]?></td>
            </tr>
            <tr>
                <td>場所</td>
                <td><?=$row["CONTENT_PLACE"]?></td>
            </tr>
            <tr>
                <td>  </td>
                <td><input type="submit" value="削除実行" name="sub1"></td>
            </tr>
        </table>
        <input type="hidden" name="CONTENT_ID" value="<?=$row["CONTENT_ID"]?>">
        <input type="hidden" name="act" value="dojob">
        <input type="hidden" name="kbn" value="del">
    </form>
<?php
}

// ----------------------------------------------------------------
// 処理完了画面
// ----------------------------------------------------------------
function screen_dojob($array){
    $res_mes=db_update($array);
?>
    <!-- メニュー -->
    <p><?php disp_menu(); ?>
    <h3>処理完了画面</h3>
    <!-- 処理結果表示 -->
    <table border="0" bgcolor="pink">
        <tr>
            <td>処理結果</td>
            <td><?=$res_mes; ?></td>
        </tr>
    </table>
<?php
}

// ----------------------------------------------------------------
// ユーザ権限チェック
// ----------------------------------------------------------------
function chk_auth($array){
    if(isset($_POST["l_id"]) and isset($_POST["l_pass"])){
        if($_POST["l_id"] == LOGINID and $_POST["l_pass"] == LOGINPASS){
            $_SESSION["auth"]=AUTHADMIN;
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    else{
        if(!isset($_SESSION["auth"])){
            return FALSE;
        }
        else{
            if($_SESSION["auth"] == AUTHADMIN){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
    }
}

// ----------------------------------------------------------------
// 登録データチェック
// ----------------------------------------------------------------
function chk_data($array){
    $strerr="";
    if($array["CONTENT_START_DATETIME"]==""){
        echo "<p>開始日時が入力されていません。";
        $strerr="1";
    }
    if($array["CONTENT_END_DATETIME"]==""){
        echo "<p>終了日時が入力されていません。";
        $strerr="1";
    }
    if($array["CONTENT_TITLE"]==""){
        echo "<p>タイトルが入力されていません。";
        $strerr="1";
    }
    if($array["CONTENT_TEXT"]==""){
        echo "<p>内容が入力されていません。";
        $strerr="1";
    }
    if($array["CONTENT_PLACE"]==""){
        echo "<p>場所が入力されていません。";
        $strerr="1";
    }
    

    if($strerr=="1"){
        return FALSE;
    }
    else{
        return TRUE;
    }
}

// ----------------------------------------------------------------
// 配列データ一括変換
// ----------------------------------------------------------------
function cnv_formstr($array){
    foreach($array as $k => $v){
        //「magic_quotes_gpc = On」の時はエスケープ解除
        //PHP7.4以降get_magic_quotes_gpcは廃止
        
        //if(get_magic_quotes_gpc()){
        //    $v=stripslashes($v);
        //}
        
        $v=htmlspecialchars($v);
        $array[$k]=$v;
    }
    return $array;
}

// ----------------------------------------------------------------
// データをSQL用に変換
// ----------------------------------------------------------------
function cnv_sqlstr($string){
    //文字コードを変換する
    $det_enc=mb_detect_encoding($string,"UTF-8, EUC-JP, SJIS");
    if($det_enc and $det_enc != ENCDB){
        $string=mb_convert_encoding($string,ENCDB,$det_enc);
    }
    //バックスラッシュを付加
    $string=addslashes($string);
    return $string;
}

// ----------------------------------------------------------------
// 表示する文字コードに変換
// ----------------------------------------------------------------
function cnv_dispstr($string){
    //文字コードを変換
    $det_enc=mb_detect_encoding($string, "UTF-8, EUC-JP, SJIS");
    if($det_enc and $det_enc!=ENCDISP){
        return mb_convert_encoding($string,ENCDISP,$det_enc);
    }
    else{
        return $string;
    }
}

// ----------------------------------------------------------------
// リンク先のURLとタイトルをリンクに変換
// ----------------------------------------------------------------
function cnv_link($url,$title){
    $string="<a href=\"$url\">".$title."</a>";
    return $string;
}

// ----------------------------------------------------------------
// 指定データ抽出
// ----------------------------------------------------------------
function get_data($CONTENT_ID){
    global $conn;
    //指定データ数を抽出
    $sql="SELECT * FROM CONTENTS_TABLE";
    $sql.=" WHERE (CONTENT_ID = ".cnv_sqlstr($CONTENT_ID).")";
    $res=db_query($sql,$conn);
    $row=$res->fetch_array(MYSQLI_ASSOC);

    return $row;
}

// ----------------------------------------------------------------
// データ一覧表示
// ----------------------------------------------------------------
function disp_listdata($key,$p){
    global $conn;

    //表示するデータの位置
    $st=($p-1)*intval(ADMINPAGESIZE);

    //データ抽出SQL作成
    $sql="SELECT * FROM CONTENTS_TABLE";
    if(strlen($key)>0){//タイトル、内容、場所のどれかの項目であいまい検索
        $sql.=" WHERE (CONTENT_TITLE LIKE '%".cnv_sqlstr($key)."%')";
        $sql.=" OR (CONTENT_TEXT LIKE '%".cnv_sqlstr($key)."%')";
        $sql.=" OR (CONTENT_PLACE LIKE '%".cnv_sqlstr($key)."%')";
    }
    $sql.=" ORDER BY CONTENT_START_DATETIME DESC LIMIT $st,".intval(ADMINPAGESIZE);//開始日時の降順で10行ずつ
    //データ抽出
    $res=db_query($sql,$conn);
    if($res->num_rows<=0){
        echo "<p>データは登録されていません。";
        return;
    }

?>
<table border="1">
<tr>
    <td>開始日時</td>
    <td>終了日時</td>
    <td>タイトル</td>
    <td>内容</td>
    <td>場所</td>
    <td>  </td>
</tr>
<?php while($row=$res->fetch_array(MYSQLI_ASSOC)){?>
    <tr>
        <td><?=date("Y/m/d H:i:s",strtotime($row["CONTENT_START_DATETIME"]))?></td>
        <td><?=date("Y/m/d H:i:s",strtotime($row["CONTENT_END_DATETIME"]))?></td>
        <td><?=cnv_dispstr($row["CONTENT_TITLE"])?></td>
        <td><?=cnv_dispstr($row["CONTENT_TEXT"])?></td>
        <td><?=cnv_dispstr($row["CONTENT_PLACE"])?></td>
        <td>
            <table>
                <tr>
                    <form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
                    <td><input type="submit" value="更新"></td>
                    <!-- 管理項目 -->
                    <input type="hidden" name="act" value="upd">
                    <!-- キー -->
                    <input type="hidden" name="CONTENT_ID" value="<?=$row["CONTENT_ID"]?>">
                    </form>
                    <form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
                    <td width="50%"><input type="submit" value="削除"></td>
                    <!-- 管理項目 -->
                    <input type="hidden" name="act" value="delconf">
                    <!-- キー -->
                    <input type="hidden" name="CONTENT_ID" value="<?=$row["CONTENT_ID"]?>">
                    </form>
                </tr>
            </table>
        </td>
    </tr>
    <?php }?>
</table>
<!--前後ページへのリンク-->
<?php disp_pagenav($key,$p); ?>
<?php
}

// ----------------------------------------------------------------
// カレンダー表示画面
// ----------------------------------------------------------------
function screen_calendar(){
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Schedule App</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <!-- Moment.jsの日本語ロケールファイルを読み込む -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/ja.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    </head>
    <body>
        <?php disp_menu(); ?>
        <h3>カレンダー表示画面</h3>
        <div id="calendar"></div>
        <script>
            $(document).ready(function () {
                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek'
                    },
                    defaultView: 'month',
                    editable: true,
                    events: 'fetch-events.php',
                    locale: 'ja', // 日本語ロケールを設定
                    timeFormat: 'h:mm A', // 時間を英語で表示
                    eventClick: function (event) {
                        // イベントがクリックされた時の処理
                        alert('タイトル：' + event.title + '\n' 
                            + '時間：' + moment(event.start).format('YYYY-MM-DD HH:mm:ss') + ' 〜 ' + moment(event.end).format('YYYY-MM-DD HH:mm:ss') + '\n'
                            + '場所：' + event.location + '\n'
                            + '内容：' + event.description + '\n'
                            );
                    }
                });
            });
        </script>
    </body>
    </html>
    <?php
}

// ----------------------------------------------------------------
// メニュー表示
// ----------------------------------------------------------------
function disp_menu(){
?>
    <table>
        <tr>
            <td><b><?=ADMINAPPNAME?></b></td>
            <form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
            <td><input type="submit" value="登録画面へ"></td>
            <input type="hidden" name="act" value="ent">
            </form>
            <form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
            <td><input type="submit" value="検索画面へ"></td>
            <input type="hidden" name="act" value="src">
            </form>
            <form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
            <td><input type="submit" value="カレンダー表示画面へ"></td>
            <input type="hidden" name="act" value="calendar">
            </form>
        </tr>
    </table>
<?php
}

// ----------------------------------------------------------------
// 前後ページへのリンク表示
// ----------------------------------------------------------------
function disp_pagenav($key,$p=1){
    global $conn;

    //前後ページ番号取得
    $prev=$p-1;
    $prev=($prev<1) ? 1 : $prev;
    $next = $p + 1;

    //全データ数を取得
    $sql="SELECT COUNT(*) AS cnt FROM CONTENTS_TABLE";
    if(isset($key)){
        if(strlen($key)>0){
            $sql.=" WHERE (CONTENT_TITLE LIKE '%".cnv_sqlstr($key)."%')";
            $sql.=" OR (CONTENT_TEXT LIKE '%".cnv_sqlstr($key)."%')";
            $sql.=" OR (CONTENT_PLACE LIKE '%".cnv_sqlstr($key)."%')";
        }
    }
    $res=db_query($sql,$conn) or die("データ抽出エラー");
    $row=$res->fetch_array(MYSQLI_ASSOC);
    $recordcount=$row["cnt"];

    ?>
    <table>
        <tr>
            <?php if($p>1){ ?>
                <form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
                <td><input type="submit" value="<< 前"></td>
                <input type="hidden" name="act" value="src">
                <input type="hidden" name="p" value="<?=$prev?>">
                <input type="hidden" name="key" value="<?=$key?>">
                </form>
                <?php } ?>
                <?php if($recordcount>($next-1)*intval(ADMINPAGESIZE)) { ?>
                    <form method="POST" action="<?=$_SERVER["SCRIPT_NAME"]?>">
                    <td width="50%"><input type="submit" value="次 >>"></td>
                    <input type="hidden" name="act" value="src">
                    <input type="hidden" name="p" value="<?=$next?>">
                    <input type="hidden" name="key" value="<?=$key?>">
                </form>
                <?php }?>
        </tr>
    </table>
    <?php
    }

// ----------------------------------------------------------------
// db接続
// ----------------------------------------------------------------
function db_conn(){
    $conn = new mysqli(DBSV, DBUSER, DBPASS, DBNAME);
    if($conn->connect_error){
        error_log($conn->connect_error);
        exit;
    }
    $conn->set_charset("utf8mb4");
    return $conn;
}

// ----------------------------------------------------------------
// SQL実行
// ----------------------------------------------------------------
function db_query($sql,$conn){
    $res=$conn->query($sql);
    return $res;
}

// ----------------------------------------------------------------
// db更新
// ----------------------------------------------------------------
function db_update($array){
    global $conn;
    global $dt;
    if(!isset($array["kbn"])){return "パラメータエラー";}
    if($array["kbn"]!="del"){
        if(!chk_data($array)){return "パラメータエラー";}
    }
    if($array["kbn"]!="ent"){
        if(!isset($array["CONTENT_ID"])){return "パラメータエラー";}
    }

    extract($array);

    //データ追加
    //$insertSQL = "INSERT INTO CONTENTS_TABLE (CONTENT_START_DATETIME, CONTENT_END_DATETIME, CONTENT_TITLE, CONTENT_TEXT, CONTENT_PLACE) VALUES ('$startDatetime', '$endDatetime', '$title', '$text', '$place')";
    if($kbn=="ent"){
        $sql="INSERT INTO CONTENTS_TABLE (";
        $sql.=" CONTENT_START_DATETIME, ";
        $sql.=" CONTENT_END_DATETIME, ";
        $sql.=" CONTENT_TITLE, ";
        $sql.=" CONTENT_TEXT, ";
        $sql.=" CONTENT_PLACE ";
        $sql.=") VALUES (";
        $sql.="'" . cnv_sqlstr(date("Y-m-d H:i:s", strtotime($CONTENT_START_DATETIME))) . "',";
        $sql.="'" . cnv_sqlstr(date("Y-m-d H:i:s", strtotime($CONTENT_END_DATETIME))) . "',";
        $sql.="'" . cnv_sqlstr($CONTENT_TITLE) . "',";
        $sql.="'" . cnv_sqlstr($CONTENT_TEXT) . "',";
        $sql.="'" . cnv_sqlstr($CONTENT_PLACE) . "'";
        $sql.=")";

        $res=db_query($sql,$conn);
        if($res){
            return "登録完了";
        }
        else{
            return "登録失敗";
        }
    }

    //データ変更
    //$updateSQL = "UPDATE CONTENTS_TABLE SET CONTENT_TITLE='$title', CONTENT_TEXT='$text' WHERE CONTENT_ID=$contentId";
    if($kbn=="upd"){
        $sql="UPDATE CONTENTS_TABLE SET ";
        //cnv_sqlstr(date("Y/m/d H:i:s", strtotime($CONTENT_START_DATETIME)))
        $sql.=" CONTENT_START_DATETIME = '" . cnv_sqlstr(date("Y-m-d H:i:s", strtotime($CONTENT_START_DATETIME))) . "',";
        $sql.=" CONTENT_END_DATETIME = '" . cnv_sqlstr(date("Y-m-d H:i:s", strtotime($CONTENT_END_DATETIME))) . "',";
        $sql.=" CONTENT_TITLE = '" . cnv_sqlstr($CONTENT_TITLE) . "',";
        $sql.=" CONTENT_TEXT = '" . cnv_sqlstr($CONTENT_TEXT) . "',";
        $sql.=" CONTENT_PLACE = '" . cnv_sqlstr($CONTENT_PLACE) . "'";
        $sql.=" WHERE CONTENT_ID = " . cnv_sqlstr($CONTENT_ID);

        $res=db_query($sql,$conn);
        if($res){
            return "更新完了";
        }
        else{
            return "更新失敗";
        }
    }

    //データ削除
    //$deleteSQL = "DELETE FROM CONTENTS_TABLE WHERE CONTENT_ID=$contentId";
    if($kbn=="del"){
        $sql="DELETE FROM CONTENTS_TABLE ";
        $sql.="WHERE CONTENT_ID = " . cnv_sqlstr($CONTENT_ID);

        $res=db_query($sql,$conn);
        if($res){
            return "削除完了";
        }
        else{
            return "削除失敗";
        }
    }

}

// ----------------------------------------------------------------
// db接続解除
// ----------------------------------------------------------------
function db_close($conn){
    //接続を解除
    $conn->close();
}
?>
<?php
include 'includes.php';
require_once("database.php");
$done = $_POST['done'];
$goal_id = $_POST['goal_id'];


//doneをパラメータとして受け取る。
//データベースからデータを取得
/*ini_set('display_errors',"on");//エラーを画面に出力
//ホスト名、DB名、ユーザ名、パスワード、ポートを定義
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mygoals');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_PORT', '8889');

try{
    $dbh = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo $e->getMessage();
    exit;
}*/

function updateDone($dbh,$done,$goal_id) {
    $stmt = $dbh->prepare("UPDATE goals SET done=?,done_date=? where id=?");
    $data = [];
    $data[] = $done;
    $data[] = date("Y-m-d H:i:s");
    $data[] = $goal_id;
    $stmt->execute($data);
    return $dbh->lastInsertId();
}

$updateDone = updateDone($dbh,$done,$goal_id);

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Sawarabi+Gothic&display=swap" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- font-family: 'Sawarabi Gothic', sans-serif; -->
    <title>mygoals</title>
        <!-- BootstrapのCSS読み込み -->
        <!-- jQuery読み込み -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- BootstrapのJS読み込み -->
        <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <h1 class="text-center">おめでとうございます！</h1>
    <p class="text-center">一つの目標に向けて、最後までやり遂げました。</p>
    <p class="text-center">理想のあなたに近づきましたね。</p>
    <button onclick="document.location.href='r-index.php'" class="btn btn-info m-3">トップページに戻る</button>
</body>
</html>
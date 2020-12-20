<?php

ini_set('display_errors',"on");//エラーを画面に出力
//ホスト名、DB名、ユーザ名、パスワード、ポートを定義
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'mygoals');
define('DB_USER', 'root');
define('DB_PASSWORD', 'root');
define('DB_PORT', '8889');

$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET 'utf8'");

//エラー表示
error_reporting(E_ALL & ~E_NOTICE);

//データベースへ接続
try{
    $dbh = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo $e->getMessage();
    exit;
}


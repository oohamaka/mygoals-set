

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
<header><?php include 'header.php'; ?></header>
<body>
    <h2 class="m-4">理想の自分に近づく</h2>
    <p class="m-4">誰しも、自分がこうありたい、こうなりたい、という思いはあります。</P>
    <p class="m-4">自分の理想に向かって、何をいつまでにすればいいのか。My Goalsは微力ながら、そのお手伝いをします。</p>
 
  <h2 class="text-left m-4">My Goalsの使い方</h2>
  <p class="ml-4">・まずはアカウントを作成してください。ユーザーID、パスワードを自由に設定してください。ただし、ユーザーIDの作成にあたっては、本名などの使用は避けてください。</p>
  <p class="ml-4">・アカウント作成後は、ログインして活用してください。</P>
  <p class="ml-4">・「ゴール」と「いつまでに？」はセットです。アカウント作成の際は両方入力しないとエラーになります。
  <p class="ml-4">・具体的なタスクは、「タスク行を追加」で枠を増やせ、「タスク行を削除」で枠を減らせます。
  <p class="ml-4">・タスクの設定をしたら、「新しいゴールを追加」をクリックしてください。左側の挑戦中のゴールに表示されます。
  <p class="ml-4">・タスクの追加や削除は、ゴールをクリックしたらゴールごとのタスクリストが表示されますが、その際に削除も可能です。
  <p class="ml-4">・タスクを完了したら、「完了！」ボタンを押してください。タスクが見え消しされます。間違えて完了にしちゃった、という場合は、「やっぱりまだでした」ボタンを押してください。未完了状態に復活します。
  <p class="ml-4">・すべてのタスクが終了したら、「ゴール達成」ボタンが押せるにようになります。これを押すと、終了したゴールの一覧にタスクが表示されます</p>

<div class="form-group text-center">
 <button class="btn btn-info mr-5" onclick="location.href='http:////localhost:8888/mygoals/bootstrap-4.5.1-dist/sign-in.php'">アカウントを作成する</button>
 <button class="btn btn-info ml-5" onclick="location.href='http://localhost:8888/mygoals/bootstrap-4.5.1-dist/login.php'">ログインする</button>
</div>
</body>
</html>

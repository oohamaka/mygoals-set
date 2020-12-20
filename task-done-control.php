<?php
//var_dump($_POST);
//exit();
include 'includes.php';
require_once("database.php");
$taskDone = $_POST['done'];
$taskId = $_GET['id'];
$delete_tasks = $_POST['task_id'];
$user_id = $_SESSION['user']['id'];
$task_id = $_POST['task_id'];
//doneをパラメータとして受け取る。
//データベースからデータを取得

//taskを削除する関数の作成
function deleteTask($dbh,$id,$user_id){
    $stmt = $dbh->prepare('DELETE from tasks where id = ? and user_id = ?'); 
    $data = [];
    $data[] = $id;
    $data[] = $user_id;
    return $stmt->execute($data);
}


//databaseのtable'tasks'に、doneの値を登録する関数の作成
function updateDone($dbh,$done,$id) {
    $stmt = $dbh->prepare("UPDATE tasks SET done=? where id=?");
    $data = [];
    $data[] = $done;
    $data[] = $id;
    $stmt->execute($data);
    return $dbh->lastInsertId();
}
//var_dump($taskDone);

//$deleteTasks = deleteTasks($dbh,$user_id,$goal_id);

if(isset($_POST['task_id'])){
    foreach($task_id as $id){
    $deleteTask = deleteTask($dbh,$id,$user_id);
    }
}else{
    $updateDone = updateDone($dbh, $taskDone, $task_id);
}

$server = $_SERVER['HTTP_REFERER'];
header("Location: $server");
 
?>

<!--<script>
    var request = new XMLHttpRequest();
    request.open('GET', URL, true);
    request.responseType = 'int';
    request.addEventListener('load', function (response) {
    // JSONデータを受信した後の処理
    });
    request.send();
</script>-->

<?php
session_start();
//$user = $_SESSION['auth_id'];
//var_dump($user['auth_id']);
if (!$_SESSION["login"]) {
  header('Location: login.php');
  exit;
}
else{
    echo $user['auth_id'] ;
}
$user = $_SESSION['user'];
$user_id = $user['id'];

//var_dump($user_id);
//var_dump($user);

//データベースへ接続
require_once("database.php");

function h($s) {
  return htmlspecialchars($s, ENT_QUOTES);
}

//データベースへmygoalを登録する関数の作成
function create($dbh, $user_id,$contents, $deadline) {
    $stmt = $dbh->prepare("INSERT INTO goals(user_id,contents,deadline) VALUES(?,?,?)");
    $data = [];
    $data[] = $user_id;
    $data[] = $contents;
    $data[] = $deadline;
    $stmt->execute($data);
    return $dbh->lastInsertId();
}
//データベースのtasksを登録する関数の作成
function create_tasks($dbh,$goal_id,$task_contents,$task_deadline,$task_done,$user_id){
    $stmt = $dbh->prepare("INSERT INTO tasks(goal_id,contents,deadline,done,user_id) VALUES(?,?,?,?,?)");
    $task_data = [];
    $task_data[] = $goal_id;
    $task_data[] = $task_contents;
    $task_data[] = $task_deadline;
    $task_data[] = $task_done;
    $task_data[] = $user_id;
    $stmt->execute($task_data);
}

//データベースからデータを取得する   
function selectAll($dbh) {
    $stmt = $dbh->prepare('SELECT * FROM goals ORDER BY updated_at DESC');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function selectAlltasks($dbh) {
    $stmt = $dbh->prepare('SELECT * FROM tasks ORDER BY updated_at DESC');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//データベースからuser_idが一致するものについて抽出
function selectuserid($dbh,$user_id){
    $stmt = $dbh->prepare('SELECT contents,deadline,id FROM goals where user_id = :user_id');
    $stmt->bindParam(':user_id',$user_id,PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
//goalのdoneが１のレコードを抽出する
function doneGoals($dbh,$user_id){
    $stmt = $dbh->prepare('SELECT contents,deadline,id,done_date FROM goals where user_id = :user_id and done = 1');
    $stmt->bindParam(':user_id',$user_id,PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//goalのdoneが0のレコードを抽出する
function NotdoneGoals($dbh,$user_id){
    $stmt = $dbh->prepare('SELECT contents,deadline,id,done_date FROM goals where user_id = :user_id and done = 0');
    $stmt->bindParam(':user_id',$user_id,PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
//設定したゴールをやっぱり削除したい時の関数
function deleteGoals($dbh,$user_id,$goal_id){
  $stmt = $dbh->prepare('DELETE from goals where id = :goal_id and user_id = :user_id');
  $stmt->bindParam(':user_id',$user_id,PDO::PARAM_INT);
  $stmt->bindParam(':goal_id',$goal_id,PDO::PARAM_INT);
  return $stmt->execute();
}

//var_dump($_POST);

if (!empty($_POST) && isset($_POST['add_goal'])){
    $contents = $_POST['goals_contents'];
    $deadline = $_POST['goals_deadline'];
    $goal_id = create($dbh,$user_id,$contents,$deadline);
    //var_dump($goal_id);
    $contents = $_POST['task_contents'];
    $deadline = $_POST['task_deadline'];
    $done = $_POST['task_done'];
    for($i = 0;count($_POST['task_contents']) > $i ; $i++){//postされるtask_contentsの数（count関数)で判断
        create_tasks($dbh,$goal_id,$_POST['task_contents'][$i],$_POST['task_deadline'][$i],$_POST['task_done'][$i],$user_id);
    }
}

if(isset($_POST['delete_goal'])){
  $goal_id =$_POST['goal_id'];
  foreach($goal_id as $id){
    $deleteGoals = deleteGoals($dbh,$user_id,$id);
  }
}
if(isset($_POST['delete_forever'])){
  $goal_id =$_POST['goal_id'];
  foreach($goal_id as $id){
    $deleteForeverGoals = deleteGoals($dbh,$user_id,$id);
  }
}

$result = selectAll($dbh);
$result_tasks = selectAll($dbh);
//var_dump($result);

$selectuserid = selectuserid($dbh,$user_id);
//var_dump($selectuserid);//$selectuseridは、ゴールの連想配列になっている。
$doneGoals = doneGoals($dbh,$user_id);
$NotdoneGoals = NotdoneGoals($dbh,$user_id);

//var_dump($NotdoneGoals);
/*
if(!empty($_POST)){
    $server = $_SERVER['HTTP_REFERER'];
    header("Location:$server");
    exit();
}*/
//var_dump($NotdoneGoals);
//var_dump($_POST['goal_id']);

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
    <header>
        <?php include 'header.php'; ?>
        <h5 class="text-right mr-4"><?php echo h($user['auth_id']).'さんログインなう' ?></h5>
    </header>
    <div class="container-fluid">
     <div class="row">
      <div class="col-sm-6">
       <div class="row">
        <div class="col-sm-12">
         <h3>挑戦中のゴール</h3>
          <table id="target-table" class="table table-striped table-hover">
            <tr>
              <th scope="col">チェックボックス</th>
              <th scope="col">挑戦中のゴール</th>
              <th scope="col">達成予定日</th>
            </tr>
          <!--設定したゴールの表示及び削除を制御するform-->
          <form method ="post" action="r-index.php" value="delete">                      
            <?php foreach($NotdoneGoals as $rec):?>
              <tr>
                <td><input type="checkbox" name="goal_id[]" value="<?php echo h($rec['id']) ?>"></td>
                <td><a href="contents.php?id=<?php echo h($rec['id']) ?>"><?php echo h($rec['contents']) ?></a></td>
                <td><?php echo h(date('Y年m月d日',strtotime($rec["deadline"])))?></td>
              </tr>        
            <?php endforeach ?>
            <!-- 削除ボタンを押したら「本当に削除していいか」という確認ウィンドウを表示させる-->
            <!-- javascriptのconfirmコードをかく-->
            <!-- OKボタンを押したら削除、キャンセルしたら何もしない-->
            <!-- if文で制御 onclick-->
            <button class="btn btn-danger my-3" type="submit" name='delete_goal'>削除する</button>
          </form>   
            </tr>                   
          </table>
        </div>
       </div>
         <div class="row">
          <div class="col-12">
            <h3>終了したゴール</h3>
            <div class="btn new">
             <!--<a href="/contact.html" class="btn"><i class="fas fa-trash-alt fa-border fa-2x"></i></a>-->
              </div>
              <!-- 終了したゴールを永遠に削除する -->
              <form method="post" value='delete_forever'>
                <table class="table table-striped table-hover" id='target-table'>
                 <tr>
                  <th scope="col">チェックボックス</th>
                  <th scope="col">達成したゴール</th>
                  <th scope="col">達成した日</th>
                 </tr>
                 <tr>
                 <?php foreach($doneGoals as $goals):?>
                   <td><input type="checkbox" name="goal_id[]" value="<?php echo h($goals['id']) ?>"></td>
                   <td><a href="contents.php?id=<?php echo h($goals['id']) ?>"><?php echo h($goals['contents']) ?></a></td>
                   <td><?php echo h(date('Y年m月d日',strtotime($goals["done_date"])))?></td>
                 </tr>
                 <?php endforeach ?>
                  <button class="btn btn-danger my-3" type="submit" name='delete_forever'>削除する</button>
                </table>
              </form>
          </div>
         </div>
      </div>
        <div class="col-sm-6">
          <form class="form-horizontal" method="post" action="r-index.php">
            <div class="form-group">
              <button type="submit" class="btn btn-info mt-5" name="add_goal" value="1">新しいゴールを追加</button>
              <input type="hidden" name="auth_id">
            </div>
            <div class="form-group">
               <label class="col-sm-3 control-label">ゴール</label>
              <div class="col-sm-9">
               <input type="text" class="form-control input-sm" name="goals_contents">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">いつまでに？</label>
              <div class="col-sm-9">
                <input type="date" class="form-control" name="goals_deadline">
              </div>
            </div>
            <div class="form-group">
              <div class="form-group">
                <button type="button" class="btn btn-info " onclick="clickBtn1()">タスク行を追加する</button>                    
              </div>
            </div>
              <template id="template">
                <div class="form-inline">
                  <div class="form-group">
                    <label class="checkbox-inline col-sm-1"><input type="checkbox"></label>
                    <input type="hidden" name="task_done[]" value="0">
                   <div class="col-sm-6">
                    <input type="text" class="form-control" name="task_contents[]">
                   </div>
                   <div class="col-sm-4">
                    <input type="date" class="form-control" name="task_deadline[]">
                   </div>
                  </div>
                </div>
              </template>
                <div id="container"></div>
                <div class="form-group">
                 <button type="button" class="btn btn-info" onclick="clickBtn2()">タスク行を削除する</button>
                </div>
            
                <!--ボタンの制御-->
                <script>
                    function clickBtn1(){
                           // template要素を取得
                            var template = document.querySelector('template');
                            //template要素の内容を複製
                            var clone = template.content.cloneNode(true);
                            // div#containerの中に追加
                            document.getElementById('container').appendChild(clone);
                    }
                    function clickBtn2(){
                        // 要素の削除
                        const container = document.getElementById('container');
                        const last_child = container.querySelector(".form-inline:last-child");
                        //var deleted = document.getElementById('template');
                        //var last_child = document.getElementById('container').lastChild;
                        console.log(last_child);
                        document.getElementById('container').removeChild(last_child);
                    //最後の要素を取って消すのもあり。
                    }
                    document.myform.addEventListner('click',function(){
                      var result = window.confirm('本当に削除して良いですか？');
                      
                      if(result){

                      }
    
                    })
                </script>
          </form>
            
            </div>
        </div>
    </div>    
</body>
</html>


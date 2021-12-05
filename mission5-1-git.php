mission3-5のパスワードができるようにする！<br>
<hr>

<?php
    // →データベース内にテーブルを作成(接続してから)
    // DB接続設定
    $dsn = 'ʼデータベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
//このデータベースサーバに、データを登録するための「テーブル」を作成
//テーブル名は「mission514」//[-]つけるとエラーなる
    $sql = "CREATE TABLE IF NOT EXISTS mission516"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    // パスワード
    . "pass TEXT,"
    // 時間
    . "time DATETIME"
    .");";
    $stmt = $pdo->query($sql);

// 一応データベースのテーブル一覧を表示して確認　おけ
//     $sql ='SHOW TABLES';
//     $result = $pdo -> query($sql);
//     foreach ($result as $row){
//         echo $row[0];
//         echo '<br>';
//     }
//     echo "<hr>";
//     echo "success connect!";

// // テーブルの詳細  
//     $sql ='SHOW CREATE TABLE mission516';
//     $result = $pdo -> query($sql);
//     foreach ($result as $row){
//         echo $row[1];
//     }
//     echo "<hr>";
//     echo "success connect!";
    
    // 新規投稿(hiddenの番号が入力されていないことに注意！+パスワードが入力されているか)
    if (!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["passNew"]) && empty($_POST["hiddenNumber"])) {
        $postTime = date ( "Y/m/d G:i:s" );
        // 時間 :分 : 秒 = G:i:s
        
// テキストに書き込む文章
        //　→多分 id,name,commentを格納できる！（mission4-5）
        //$postTotal = $postNumber."<>".$namae."<>".$come."<>".$postTime;
        $sql = $pdo -> prepare("INSERT INTO mission516 (name, comment, time, pass) VALUES (:name, :comment, :time, :pass)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindParam(':time', $time, PDO::PARAM_STR);
        $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
        // 接続するときに$password使ってる！
        $name = $_POST["name"];
        $comment = $_POST["comment"]; 
        $time = " ".$postTime;
        // パスワード
        $pass = $_POST["passNew"];
        $sql -> execute();
        
    // 削除の番号が送信されたとき
    }else if(!empty($_POST["deleteNumber"])){
        //$delete = $_POST["number"];
        
        //削除パスワードの取得
        $id = $_POST["deleteNumber"];
        $sql = 'SELECT * FROM mission516 WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();                             // ←SQLを実行する。
        $results = $stmt->fetchAll(); 
        foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
            // echo $row['id'].',';
            // echo $row['name'].',';
            // echo $row['comment'].',';
            // echo $row['pass'].'<br>';
        }
        
        // 確認！
        // var_dump($results);　//格納はされてる
        // echo $results['pass'];　//でもダメ
        // echo $results['pass']; //ダメ
        //var_dump($row);
        //echo "<br>".$row[3]."<br>"; //row[3]にパスワード入ってる
        //削除パスワードの取得できた！
        $passDel = $row[3];
        //echo $passdel."<br>";
            
        //パスワードの照合
        if($_POST["passwordDel"] == $passDel){
            $id = $_POST["deleteNumber"];
            $sql = 'delete from mission516 where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            //コメントアウト
            //echo "success connect!";
        }else {
            echo "パスワードが一致していません！<br><br>";
        }
        
    }else if(!empty($_POST["editNumber"])){
        // 編集番号が送信されたとき
        // $editNumber = $_POST["editNumber"];
        
        //編集パスワードの取得
        $id = $_POST["editNumber"];
        $sql = 'SELECT * FROM mission516 WHERE id=:id ';
        $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
        $stmt->execute();                             // ←SQLを実行する。
        $results = $stmt->fetchAll(); 
        foreach ($results as $row){
        }
        // 代入
        $passEdi = $row[3];
        
        //パスワードの照合
        if($_POST["passwordEdi"] == $passEdi){
            //テーブルに$editNumberと同じidの番号があったとき（せんでいいかも）
            // $editNumberと同じ番号idのデータレコードを抽出し
            // $numberEdit,$nameEdit,$commetEditに代入する！
            $id =  $_POST["editNumber"]; // idがこの値のデータだけを抽出したい、とする
            $sql = 'SELECT * FROM mission516 WHERE id=:id ';
            $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
            $stmt->execute();                             // ←SQLを実行する。
            $results = $stmt->fetchAll(); 
            foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
                $hiddenNumber = $row['id'];
                $nameEdit = $row['name'];
                $commetEdit = $row['comment'];
                // パスワードを送る 違う
                $passEdit =$row['pass'];
            }
        }else {
            echo "パスワードが一致していません！<br><br>";
        }
        
    }else if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["passNew"]) && !empty($_POST["hiddenNumber"])){
        // 編集機能
        // 名前かつコメントかつhiddenの編集番号が入ってたらif文通る

        // パスワード
        $pass = $_POST["passNew"]; //変更パスワード
        // 12/3 ここでエラー →　166のタイプミス！(time=:timeのとこ)
        
        $id = $_POST["hiddenNumber"]; //変更する投稿番号
        // echo $id;
        $name = $_POST["name"];
        //変更したい名前
        $comment = $_POST["comment"]; 
        //変更したいコメントは自分で決めること
        
        $postTime = date("Y/m/d G:i:s");
        $time = $postTime;//変更時間 　// スペースもエラーとして出てくる！
        
        $sql = 'UPDATE mission516 SET name=:name,comment=:comment,time=:time,pass=:pass WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':time', $time, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
    }else {
        echo "名前とコメント両方入力してください<br><br>";
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>mission5-1</title>
</head>
<body>
<form method = "POST">
    名前：<input type="text" name="name"
        value = <?php if(!empty($nameEdit)){echo "\"".$nameEdit."\"";}?> ><br>
    コメント：<input type="text" name="comment"
        value = <?php if(!empty($commetEdit)){echo "\"".$commetEdit."\"";}?> ><br>
    パスワード：<input type="password" name="passNew"
        value = <?php if(!empty($passEdit)){echo "\"".$passEdit."\"";}?> ><br>
    <!--編集（隠れている）-->
    <input type="hidden" name="hiddenNumber"
         value = <?php if(!empty($hiddenNumber)){echo "\"".$hiddenNumber."\"";}?>><br>
         <!--$nameEditが定義されたらvalueに値が入る(上の名前、コメントも同様)-->
    <input type="submit" name="submit" value="送信"><br><br>
    <!--削除-->
    削除番号: <input type="number" name="deleteNumber"><br>
    パスワード：<input type="password" name="passwordDel"><br>
    <input type="submit" name="submit" value="削除"><br><br>
    <!--編集-->
    編集番号: <input type="number" name="editNumber"><br>
    パスワード：<input type="password" name="passwordEdi"><br>
    <input type="submit" name="submit" value="編集">
</form>
<br>
<hr>
</body>
</html>
    
<?php
    //表示する
    $sql = 'SELECT * FROM mission516';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].'  ';
        echo $row['name'].' ';
        echo $row['comment'].' ';
        // 時間
        echo "  ".$row['time'].' ';
        // echo $row['pass'].'<br>';
    echo "<hr>";
    }
?>
<!DOCTYPE HTML>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>join table 1</title>
  <link rel="stylesheet" href="join.css">
</head>

<body>
  <?php
function db_output($result){
    $field_name = array();
    for($i=0;$i<$result->columnCount();$i++){
        $meta = $result->getColumnMeta($i);
        $field_name[]=$meta['name'];
    }
    
    echo "<table>\n\t<tr>";
    echo "<th>".implode("</th><th>",$field_name)."</th></tr>\n";
    
    foreach ($result as $kekka){
        $td=array();
        for($i=0;$i<$result->columnCount();$i++){
            $td[]=$kekka[$i];
        }
        echo "\t<tr><td>".implode("</td><td>",$td)."</td></tr>\n";
    }
    echo "</table>\n";
}

// main

require "../../pass.php";

try{
    $pdo = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",$username,$password);

    $sql=<<<EOSQL
    select count(*) from student_friend as f
    join student_list as L1 on L1.student_id=f.student_id
    join student_list as L2 on L2.student_id=f.friend_id
    where L1.sex<>L2.sex
EOSQL;
    $num = $pdo->query($sql)->fetch()[0];

    $sql=<<<EOSQL
    select f.student_id,L1.name,(case when L1.sex=1 then '男' when L1.sex=2 then '女' else null end) as 性別,
    f.friend_id,L2.name,(case when L2.sex=1 then '男' when L2.sex=2 then '女' else null end) as 性別
    from student_friend as f
    join student_list as L1 on L1.student_id=f.student_id
    join student_list as L2 on L2.student_id=f.friend_id
    where L1.sex<>L2.sex
    order by L1.name_kana
EOSQL;
    $result = $pdo->query($sql);

    echo "<h1>検索結果　一覧１</h1>";
    echo "友達（異性）の検索結果　データ件数：{$num}件";
    db_output($result);



}catch(PDOException $e){
    print("Error:" . $e->getMessage());
    die();
}

$pdo = null;

?>
</body>

</html>
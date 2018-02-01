<!DOCTYPE HTML>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>join table 2</title>
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

function output_form($name="")
{
    echo <<< EOFORM
    <form action="" method = "POST">
    <input type="hidden" name="cmd" value="hoge">
    <input type="text" name="name" value="{$name}">
    <input type="submit" value="検索">
    </form>
EOFORM;
}

// main

require "../../pass.php";

try{
    $pdo = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",$username,$password);

    if(isset($_POST['cmd'])){
        $name=$_POST['name'];
    }else{
        $name="";
    }

    $sql_where = "where name like ? or name_kana like ?";

    $sql=<<<EOSQL
    select count(*)
    from student_list
    {$sql_where}
EOSQL;
    $result = $pdo->prepare($sql);
    $result->execute(array("%$name%","%$name%"));
    $num = $result->fetch()[0];
    
    $sql=<<<EOSQL
    select student_id,name,name_kana,(case when sex=1 then '男' when sex=2 then '女' else null end) as 性別,
    timestampdiff(year,birthday,CURDATE()) as 年齢
    from student_list
    {$sql_where}
    order by 年齢 desc,name_kana
EOSQL;
    $result = $pdo->prepare($sql);
    $result->execute(array("%$name%","%$name%"));
    
    echo "<h1>検索結果　一覧２</h1>";

    output_form($name);
    echo "検索結果　データ件数：{$num}件";
    if($num==0){
        ;
    }else{
        db_output($result);
    }
}catch(PDOException $e){
    print("Error:" . $e->getMessage());
    die();
}

$pdo = null;

?>
</body>

</html>
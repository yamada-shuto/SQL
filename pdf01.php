<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>select table</title>
<style>
<!--
table,td,th,tr  {
  border : 1px solid black;
  border-collapse: collapse;
  line-height:1.5em;
}
td {width:5em;}
-->
</style>
</head>
<body>
<h1>テーブル一覧</h1><hr>
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

function db_output_form($result){
    echo <<< EOFORM
        <form action="pdf02.php" method="post">
        <table>
            <tr>
EOFORM;
    $field_name = array();
    for($i=0;$i<$result->columnCount();$i++){
        $meta = $result->getColumnMeta($i);
        $field_name[]=$meta['name'];
    }
    echo "<th>".implode("</th><th>",$field_name)."</th></tr>\n";

    foreach ($result as $kekka){
        echo "\t<tr>";
        for($i=0;$i<$result->columnCount();$i++){
            echo "<td><input type=\"radio\" name=\"tbname\" value=\"$kekka[$i]\">".$kekka[$i]."</td>" ;
        }
    	echo "</tr>\n";
    }
    echo <<< EOFORM
        </table>
        <input type="submit" name="cmd" value="OK">
    </form>

EOFORM;
}

// main
require "../../pass.php";

try{
    $pdo = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",$username,$password);

    $sql="show tables";
    db_output_form($pdo->query($sql));
}catch(PDOException $e){
    print("Error:" . $e->getMessage());
    die();
}
$pdo = null;
?>
</body>
</html>

<?php
    session_start();
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>download DB data</title>
<link rel="stylesheet" href="download.css">
</head>
<body>
<?php
setlocale(LC_ALL,'ja_JP.utf-8');

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

function db_csv_output($result,$filename){
    $field_name = array();
    for($i=0;$i<$result->columnCount();$i++){
        $meta = $result->getColumnMeta($i);
        $field_name[]=$meta['name'];
    }
    
    $fp=fopen($filename,"w") or die("Can't open write:$filename\n");
    fputs($fp,implode(",",$field_name)."\n");
        
    foreach ($result as $kekka){
        $line=array();
        for($i=0;$i<$result->columnCount();$i++){
            $line[]=$kekka[$i];
        }
        $line=implode(",",$line)."\n";
        fputs($fp,$line);
    }
    fclose($fp);
}

function form_output()
{
echo <<< EOFORM
  <form action="file_download.php" method="post">
    <input type="submit" name="cmd" value="download">
  </form>

EOFORM;
}
function csv_output($filename)
{
  $fp=fopen($filename,"r") or die("Can't open read:$filename\n");
  echo "<table>\n";
  while($row=fgetcsv($fp)){
    $line="<tr><td>".implode("</td><td>",$row)."</td></tr>\n";
    echo $line;
  }
  echo "</table>\n";
  fclose($fp);
}

// main
require "../../pass.php";
$filename="sql.csv";
$tempname=tempnam("./", "tmp");
try{
    $pdo = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",$username,$password);

    echo "<h1>SQL DATA</h1>\n";
    $sql="select bang as 番号,nama as 名前,tosi as 年齢 from tb1";
    $result=$pdo->query($sql);
    db_output($result);

    $result=$pdo->query($sql);
    db_csv_output($result,$tempname);
    $_SESSION['tempname']=$tempname;
    form_output();
    echo "<h1>CSV DATA</h1>\n";
    csv_output($tempname);
}catch(PDOException $e){
    print("Error:" . $e->getMessage());
    die();
}

$pdo = null;

?>
</body>
</html>

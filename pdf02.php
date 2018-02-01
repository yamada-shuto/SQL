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
function db_html($result){
    $field_name = array();
    for($i=0;$i<$result->columnCount();$i++){
        $meta = $result->getColumnMeta($i);
        $field_name[]=$meta['name'];
    }
    
    $html = "<table>\n\t<tr>";
    $html.= "<th>".implode("</th><th>",$field_name)."</th></tr>\n";
    
    foreach ($result as $kekka){
        $td=array();
        for($i=0;$i<$result->columnCount();$i++){
            $td[]=$kekka[$i];
        }
        $html.= "\t<tr><td>".implode("</td><td>",$td)."</td></tr>\n";
    }
	$html.= "</table>\n";
	return $html;
}

require_once('mpdf-6.1/mpdf.php');

require "../../pass.php";

$tbname = $_POST['tbname'];
if(isset($_POST['cmd'])){
	try{
		$pdo = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8",$username,$password);

		$sql="select * from {$tbname}";
		$html="<h1>{$tbname}</h1>";
		$html.=db_html($pdo->query($sql));

		$css = <<<EOCSS
		table,td,th,tr  {
			border : 1px solid black;
			border-collapse: collapse;
			line-height:1.5em;
		  }
		  td {width:5em;}

EOCSS;

		$pdf = new mpdf('ja+aCJK','A4');
		$pdf->WriteHTML($css,1);
		$pdf->WriteHTML($html);
		$pdf->Output();
	}catch(PDOException $e){
		print("Error:" . $e->getMessage());
		die();
	}
}
$pdo = null;
?>

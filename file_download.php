<?php
    session_start();

    $tempname=$_SESSION['tempname'];
    $filename="sql.csv";

    if(file_exists($tempname)){
        header('Content-Type: application/force-download');
        header('Content-Length: '.filesize($tempname));
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        readfile($tempname);
        unlink($tempname);
    }
?>

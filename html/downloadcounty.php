<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    $filename = 'county.csv';
    if(isset($_POST['export_data'])){
        $export_data = unserialize($_POST['export_data']);
    }

    // file creation
    $file = fopen($filename,"w");

    foreach ($export_data as $line){
     fputcsv($file,$line);
    }

    fclose($file);

    // download
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=".$filename);
    header("Content-Type: application/csv; "); 

    readfile($filename);

    // deleting file
    exit();
?>
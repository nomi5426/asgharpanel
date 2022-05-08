<?php
include "../base/db.php";
$pdfUpload = "../pdfUploads/";

// Downloads files
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];
    // fetch file to download from database
    $sql = "SELECT * FROM product WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $file = mysqli_fetch_assoc($result);
    $filepath = $pdfUpload . $file['deliveryNote'];

    if (!file_exists($filepath)) {
        echo "<script type='text/javascript'>alert('No File Exists')</script>";
    }
    else{
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($pdfUpload . $file['deliveryNote']));
        //ob_clean();
        //flush();  
        readfile($filepath);
        exit;
    }

}

?>
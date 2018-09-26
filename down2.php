<?php
session_start();
$currentDir = getcwd();
$uploadDirectory = "/img/tmp_pic/";

$errors = []; // Store all foreseen and unforseen errors here

$fileExtensions = ['jpeg','jpg','png']; // Get all the file extensions

$fileName = $_FILES['myfile']['name'];
$fileSize = $_FILES['myfile']['size'];
$fileTmpName  = $_FILES['myfile']['tmp_name'];
$fileType = $_FILES['myfile']['type'];
$fileExtension = strtolower(end(explode('.',$fileName)));
$file_namo = basename($fileName);

$uploadPath = $currentDir . $uploadDirectory . $file_namo; 

if (isset($_POST['submit'])) {

    if (! in_array($fileExtension,$fileExtensions)) {
        $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
    }

    if ($fileSize > 2000000) {
        $errors[] = "This file is more than 2MB. Sorry, it has to be less than or equal to 2MB";
    }

    if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);
        rename($currentDir .  $uploadDirectory . $file_namo, $currentDir . $uploadDirectory . "tmp_pic_name.jpg");

        if ($didUpload) {
            $_SESSION["tmp_for_js"] = true;
            header('Location: take_pic.php');
        } else {
            echo "An error occurred somewhere. Try again or contact the admin";
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "These are the errors" . "\n";
        }
    }
}
?>
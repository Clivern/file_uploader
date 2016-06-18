<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once dirname(__FILE__) . '/vendor/autoload.php';

if( isset($_FILES['test']) ){

    $uploader = new \Clivern\FileUploader\Uploader([
        'dir_path' => dirname(__FILE__),
        'dir_name' => 'storage',
        'year_storage_based' => true,
        'month_storage_based' => true,
    ]);

    $uploader->uploadFile('test', [
        'supported_extensions' => ['txt'],
        'supported_types' => ['text/plain'],
        'max_size' => '2MB',
    ]);

    $errors = $uploader->getErrors();
    $file_info = $uploader->getFileInfo();
    echo '<pre>';
    var_dump($errors);
    var_dump($file_info);
    die();
}

?>

 <form action="" method="POST" enctype="multipart/form-data">
         <input type="file" name="test" />
         <input type="submit"/>
      </form>
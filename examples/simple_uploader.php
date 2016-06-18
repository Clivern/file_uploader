<?php
include_once dirname(__FILE__) . '/vendor/autoload.php';

if( isset($_FILES['test']) ){

    $uploader = new \Clivern\FileUploader\Uploader([
        'dir_path' => dirname(__FILE__), # Path to storage directory
        'dir_name' => 'storage', # Storage directory name
        'year_storage_based' => true, # Whether to arrange uploaded file in year directories
        'month_storage_based' => true, # Whether to arrange uploaded file in months under year directories
    ]);

    $result = $uploader->uploadFile('test', [ # test is the file input name

        # validate allowed extensions
        # Possible values are:
        #   false => to stop extension validation.
        #   array of allowed extensions.
        'supported_extensions' => ['txt'],

        # validate allowed types
        # Possible values are:
        #   false => to stop type validation.
        #   array of allowed types.
        'supported_types' => ['text/plain'],

        # Maximum upload size
        # Possible values are:
        #   false => to stop size validation.
        #   1KB or 2KB or 8KB and so on.
        #   2MB or 3MB or 8MB and so on.
        #   3GB or 4GB or 5GB and so on.
        #   4TP or 8TP or 10TP and so on.
        #   9PB or 8PB and so on.
        'max_size' => '2MB',
    ]);

    echo '<pre>';
    if (!$result) {
        # Get Errors List
        $errors = $uploader->getErrors();
        var_dump($errors);
    }else{
        # Get uploaded file info
        $file_info = $uploader->getFileInfo();
        var_dump($file_info);
    }
    die();
}

?>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="file" name="test" />
    <input type="submit"/>
</form>
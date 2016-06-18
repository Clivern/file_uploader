<?php

namespace Clivern\FileUploader;

use Clivern\FileUploader\Storage as Storage;
use Clivern\FileUploader\Uploader as Uploader;
use Clivern\FileUploader\Validator as Validator;

class UploaderTest extends \PHPUnit_Framework_TestCase
{

    public function testFileUpload()
    {

        $file = 'test.txt';
        $content = "Hello World\n";
        file_put_contents(dirname(__FILE__) . '/' . $file, $content, FILE_APPEND | LOCK_EX);

        $_FILES = array(
            'test' => array(
                'name' => 'test.txt',
                'type' => 'text/plain',
                'size' => 542,
                'tmp_name' => dirname(__FILE__) . '/test.txt',
                'error' => 0
            )
        );

        $uploader = new Uploader([
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

        $this->assertCount(1, $errors);
        $this->assertContains('Error while uploading the file.', $errors);

        $this->assertEquals($file_info['name'], 'test.txt');
        $this->assertEquals($file_info['type'], 'text/plain');
        $this->assertEquals($file_info['tmp_name'], dirname(__FILE__) . '/test.txt');
        $this->assertEquals($file_info['error'], 0);
        $this->assertEquals($file_info['size'], 542);
        $this->assertEquals($file_info['dirname'], '.');
        $this->assertEquals($file_info['basename'], 'test.txt');
        $this->assertEquals($file_info['extension'], 'txt');
        $this->assertEquals($file_info['filename'], 'test');

        unlink(dirname(__FILE__) . '/' . $file);
        rmdir(dirname(__FILE__) . '/storage' . '/' . date("Y") . '/' . date("m"));
        rmdir(dirname(__FILE__) . '/storage' . '/' . date("Y"));
        rmdir(dirname(__FILE__) . '/storage');
    }
}

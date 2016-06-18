<?php

namespace Clivern\FileUploader;

use Clivern\FileUploader\Storage as Storage;
use Clivern\FileUploader\Uploader as Uploader;
use Clivern\FileUploader\Validator as Validator;

class StorageTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test Base Storage Builder
     */
    public function testStorageBuilder()
    {
        $storage = new Storage(dirname(__FILE__), 'storage', false, false);
        $result = $storage->buildStorage();
        $this->assertTrue($result);

        $upload_path = $storage->getUploadPath();
        $this->assertEquals($upload_path, dirname(__FILE__) . '/storage');

        rmdir(dirname(__FILE__) . '/storage');
    }

    /**
     * Test Storage Builder With Years
     */
    public function testStorageBuilderWithYears()
    {
        $storage = new Storage(dirname(__FILE__), 'storage', true, false);
        $result = $storage->buildStorage();
        $this->assertTrue($result);

        $upload_path = $storage->getUploadPath();
        $this->assertEquals($upload_path, dirname(__FILE__) . '/storage' . '/' . date("Y"));

        rmdir(dirname(__FILE__) . '/storage' . '/' . date("Y"));
        rmdir(dirname(__FILE__) . '/storage');
    }

    /**
     * Test Storage Builder With Months
     */
    public function testStorageBuilderWithMonths()
    {
        $storage = new Storage(dirname(__FILE__), 'storage', true, true);
        $result = $storage->buildStorage();
        $this->assertTrue($result);

        $upload_path = $storage->getUploadPath();
        $this->assertEquals($upload_path, dirname(__FILE__) . '/storage' . '/' . date("Y") . '/' . date("m"));

        rmdir(dirname(__FILE__) . '/storage' . '/' . date("Y") . '/' . date("m"));
        rmdir(dirname(__FILE__) . '/storage' . '/' . date("Y"));
        rmdir(dirname(__FILE__) . '/storage');
    }
}

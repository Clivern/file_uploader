<?php

namespace Clivern\FileUploader;

use Clivern\FileUploader\Storage as Storage;
use Clivern\FileUploader\Uploader as Uploader;
use Clivern\FileUploader\Validator as Validator;

class StorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that true does in fact equal true
     */
    public function testTrueIsTrue()
    {
        $validator = Validator(false, false, '32MB');
        $this->assertTrue(true);
    }
}
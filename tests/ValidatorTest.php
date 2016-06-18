<?php

namespace Clivern\FileUploader;

use Clivern\FileUploader\Storage as Storage;
use Clivern\FileUploader\Uploader as Uploader;
use Clivern\FileUploader\Validator as Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that true does in fact equal true
     */
    public function testTrueIsTrue()
    {
        $this->assertTrue(true);
    }

    public function testUploadError()
    {
        $Validator = new Validator(false, false, '32MB');
        $result = $Validator->validate([
            'error' => 2,
            'size' => 2000
        ]);
        $errors = $Validator->getErrors();

        $this->assertFalse($result);
        $this->assertCount(1, $errors);
        $this->assertContains('Error while uploading the file', $errors);
    }

    public function testSupportedTypes()
    {
        /*
        $Validator = new Validator(false, false, '32MB');
        $result = $Validator->validate([

        ]);
        $errors = $Validator->getErrors();

        $this->assertFalse($result);
        $this->assertTrue($result);
        */
    }

    public function testSupportedExtensions()
    {
        /*
        $Validator = new Validator(false, false, '32MB');
        $result = $Validator->validate([

        ]);
        $errors = $Validator->getErrors();

        $this->assertFalse($result);
        $this->assertTrue($result);
        */
    }

    public function testMaxSize()
    {
        $Validator = new Validator(false, false, '32MB');
        $result = $Validator->validate([
            'error' => 0,
            'size' => 2000
        ]);
        $errors = $Validator->getErrors();

        $this->assertTrue($result);
        $this->assertCount(0, $errors);
    }
}

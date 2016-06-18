<?php

namespace Clivern\FileUploader;

use Clivern\FileUploader\Storage as Storage;
use Clivern\FileUploader\Uploader as Uploader;
use Clivern\FileUploader\Validator as Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test Upload Error Validation
     */
    public function testUploadError()
    {
        $Validator = new Validator(false, false, '32MB');
        $result = $Validator->validate([
            'error' => 2,
            'size' => 2000,
            'type' => 'application/png',
            'extension' => 'pdf'
        ]);
        $errors = $Validator->getErrors();

        $this->assertFalse($result);
        $this->assertCount(1, $errors);
        $this->assertContains('Error while uploading the file.', $errors);
    }

    /**
     * Test Supported Types Validation
     */
    public function testSupportedTypes()
    {
        $Validator = new Validator(false, ['application/png'], '32MB');
        $result = $Validator->validate([
            'error' => 0,
            'size' => 2000,
            'type' => 'application/png',
            'extension' => 'pdf'
        ]);
        $errors = $Validator->getErrors();

        $this->assertTrue($result);
        $this->assertCount(0, $errors);


        $Validator = new Validator(false, ['application/png'], '32MB');
        $result = $Validator->validate([
            'error' => 0,
            'size' => 2000,
            'type' => 'application/pdf',
            'extension' => 'pdf'
        ]);
        $errors = $Validator->getErrors();

        $this->assertFalse($result);
        $this->assertCount(1, $errors);
        $this->assertContains('File type is invalid.', $errors);
    }

    /**
     * Test Supported Extensions Validation
     */
    public function testSupportedExtensions()
    {
        $Validator = new Validator(['pdf', 'doc', 'docx'], false, '32MB');
        $result = $Validator->validate([
            'error' => 0,
            'size' => 2000,
            'type' => 'application/png',
            'extension' => 'pdf'
        ]);
        $errors = $Validator->getErrors();

        $this->assertTrue($result);
        $this->assertCount(0, $errors);


        $Validator = new Validator(['pdf', 'doc', 'docx'], false, '32MB');
        $result = $Validator->validate([
            'error' => 0,
            'size' => 2000,
            'type' => 'application/png',
            'extension' => 'png'
        ]);
        $errors = $Validator->getErrors();

        $this->assertFalse($result);
        $this->assertCount(1, $errors);
        $this->assertContains('File extension is invalid.', $errors);
    }

    /**
     * Test Max Size Validation
     */
    public function testMaxSize()
    {
        $Validator = new Validator(false, false, '32MB');
        $result = $Validator->validate([
            'error' => 0,
            'size' => 31 * pow(1024,2),
            'type' => 'application/png',
            'extension' => 'png'
        ]);
        $errors = $Validator->getErrors();

        $this->assertTrue($result);
        $this->assertCount(0, $errors);


        $Validator = new Validator(false, false, '32MB');
        $result = $Validator->validate([
            'error' => 0,
            'size' => 33 * pow(1024,2),
            'type' => 'application/png',
            'extension' => 'png'
        ]);
        $errors = $Validator->getErrors();

        $this->assertFalse($result);
        $this->assertCount(1, $errors);
        $this->assertContains('File size must not exceed 32MB.', $errors);


        $Validator = new Validator(false, false, '3GB');
        $result = $Validator->validate([
            'error' => 0,
            'size' => 3.3 * pow(1024,3),
            'type' => 'application/png',
            'extension' => 'png'
        ]);
        $errors = $Validator->getErrors();

        $this->assertFalse($result);
        $this->assertCount(1, $errors);
        $this->assertContains('File size must not exceed 3GB.', $errors);

        $Validator = new Validator(false, false, '3TP');
        $result = $Validator->validate([
            'error' => 0,
            'size' => 3.2 * pow(1024,4),
            'type' => 'application/png',
            'extension' => 'png'
        ]);
        $errors = $Validator->getErrors();

        $this->assertFalse($result);
        $this->assertCount(1, $errors);
        $this->assertContains('File size must not exceed 3TP.', $errors);
    }
}

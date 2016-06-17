<?php

namespace Clivern\FileUploader;

class StorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test that true does in fact equal true
     */
    public function testTrueIsTrue()
    {
        $validator = \Clivern\FileUploader\Validator(false, false, '32MB');
        $this->assertTrue(true);
    }
}

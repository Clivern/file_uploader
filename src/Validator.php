<?php

namespace Clivern\FileUploader;

/**
 * Validator Class
 */
class Validator
{

    /**
     * A list of catched errors
     *
     * @since  1.0.0
     * @access private
     * @var    array
     */
    private $errors = [];

    /**
     * A list of validation rules
     *
     * @since  1.0.0
     * @access private
     * @var    array
     */
    private $roles;

    /**
     * Class constructor
     *
     * @since  1.0.0
     * @access public
     * @param  boolean $supported_extensions
     * @param  boolean $supported_types
     * @param  string  $max_size
     */
    public function __construct($supported_extensions = false, $supported_types = false, $max_size = "32MB")
    {
        $this->roles['supported_extensions'] = $supported_extensions;
        $this->roles['supported_types'] = $supported_types;
        $this->roles['max_size'] = $max_size;
    }

    /**
     * Validate uploaded file
     *
     * @since  1.0.0
     * @access public
     * @param  array $file_info
     * @return boolean
     */
    public function validate($file_info)
    {
        if ((isset($file_info['error'])) && ($file_info['error'] > 0)) {
            $this->errors[] = "Error while uploading the file.";
        }

        if ((is_array($this->roles['supported_extensions']))
            && !(in_array($file_info['extension'], $this->roles['supported_extensions']))
        ) {
            $this->errors[] = "File extension is invalid.";
        }

        if ((is_array($this->roles['supported_types']))
            && !(in_array($file_info['type'], $this->roles['supported_types']))
        ) {
            $this->errors[] = "File type is invalid.";
        }

        $max_size = $this->updateSize($this->roles['max_size']);

        if (($this->roles['max_size'] != false) && ($file_info['size'] > $max_size)) {
            $this->errors[] = "File size must not exceed {$this->roles['max_size']}.";
        }

        return ( count($this->errors) > 0 ) ? false : true;
    }

    /**
     * Get Upload Errors
     *
     * @since  1.0.0
     * @access public
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Update size to bytes
     *
     * @since  1.0.0
     * @access private
     * @param  string $size
     * @return mixed
     */
    private function updateSize($size)
    {
        if (strpos($size, "KB") !== false) {
            return intval($size) * 1024;
        } elseif (strpos($size, "MB") !== false) {
            return intval($size) * pow(1024, 2);
        } elseif (strpos($size, "GB") !== false) {
            return intval($size) * pow(1024, 3);
        } elseif (strpos($size, "TB") !== false) {
            return intval($size) * pow(1024, 4);
        } elseif (strpos($size, "PB") !== false) {
            return intval($size) * pow(1024, 5);
        } else {
            return false;
        }
    }
}

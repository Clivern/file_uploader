<?php

namespace Clivern\FileUploader;
use Clivern\FileUploader\Storage as Storage;
use Clivern\FileUploader\Validator as Validator;

/**
 * Uploader Class
 */
class Uploader {

    private $storage;
    private $validator;
    private $file_info;
    private $errors;

    /**
     * Class constuctor
     *
     * @since 1.0.0
     * @access public
     * @param array $configs
     */
    public function __construct($configs)
    {
        $configs['year_storage_based'] = !(isset($configs['year_storage_based'])) ? false : $configs['year_storage_based'];
        $configs['month_storage_based'] = !(isset($configs['month_storage_based'])) ? false : $configs['month_storage_based'];
        $configs['supported_extensions'] = !(isset($configs['supported_extensions'])) ? false : $configs['supported_extensions'];
        $configs['supported_types'] = !(isset($configs['supported_types'])) ? false : $configs['supported_types'];
        $configs['max_size'] = !(isset($configs['max_size'])) ? '32MB' : $configs['max_size'];

        $this->storage = Storage($configs['dir_path'], $configs['dir_name'], $configs['year_storage_based'], $configs['month_storage_based']);
        $this->validator = Validator($configs['supported_extensions'], $configs['supported_types'], $configs['max_size']);
    }

    /**
     * Upload, validate and store the file
     *
     * @since 1.0.0
     * @access public
     * @param string $input_name
     * @param array $validation_rules
     * @return mixed
     */
    public function uploadFile($input_name, $validation_rules)
    {

        $this->file_info = (isset($_FILES[$input_name])) ? $_FILES[$input_name] : false;

        if( $this->file_info == false ){

        }
        if( !(is_array($this->file_info)) || !(count($this->file_info) > 0) ){

        }

        $this->file_info = array(
            'name' => (isset($this->file_info['name'])) ? $this->file_info['name'] : "",
            'type' => (isset($this->file_info['type'])) ? $this->file_info['type'] : "",
            'tmp_name' => (isset($this->file_info['tmp_name'])) ? $this->file_info['tmp_name'] : "",
            'error' => (isset($this->file_info['error'])) ? $this->file_info['error'] : "",
            'size' => (isset($this->file_info['size'])) ? $this->file_info['size'] : "",
        );

        $this->file_info = array_merge($this->file_info, pathinfo($this->file_info['name']));

        if( !$this->validator->validate($this->file_info) ){
            $this->errors = $this->validator->getErrors();
        }else{
            return $this->uploadAndStore();
        }

    }

    /**
     * Ger Errors
     *
     * @since 1.0.0
     * @access public
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Upload and store file
     *
     * @since 1.0.0
     * @access private
     * @return string
     */
    private function uploadAndStore()
    {
        $file_name = time() . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 15) . "." . $file_info['extension'];

        $upload_status = (boolean) move_uploaded_file($file_data['tmp_name'], $this->storage_path . $this->storage_iden . $sub_path . "/" . $file_name);

        if( !$upload_status ){
            return false;
        }

        $this->file_data['hash'] = date("Y") . "__" . date("m") . "__" . $file_name;

        return $this->file_data;
    }
}
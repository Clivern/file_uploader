<?php

/**
 * Storage Class
 *
 * @since 1.0
 */
class Storage {

    /**
     * Storage Base Path
     *
     * @since 1.0
     * @access private
     * @var string $this->storage_path
     */
    private $storage_path;

    /**
     * Custom Storage Name
     *
     * @since 1.0
     * @access private
     * @var string $this->storage_iden
     */
    private $storage_iden;

    /**
     * Current File Data
     *
     * @since 1.0
     * @access private
     * @var array $this->file_data
     */
    private $file_data;

    /**
     * Holds an instance of this class
     *
     * @since 1.0
     * @access private
     * @var object self::$instance
     */
    private static $instance;

    /**
     * Create instance of this class or return existing instance
     *
     * @since 1.0
     * @access public
     * @return object an instance of this class
     */
    public static function instance()
    {
        if ( !isset(self::$instance) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Config Class
     *
     * @since 1.0
     * @access public
     * @param string $storage_iden
     * @return object
     */
    public function config($storage_iden = 'steps')
    {
        $this->storage_path = base_path('storage/app/');
        $this->storage_iden = $storage_iden;
        $this->buildStorage();

        return $this;
    }

    /**
     * Build Site Storage
     *
     * @since 1.0
     * @access public
     */
    public function buildStorage()
    {
        if( !is_dir($this->storage_path . $this->storage_iden) ){
            mkdir($this->storage_path . $this->storage_iden);
        }

        /*
        if( !is_file($this->storage_path . $this->storage_iden . "/.htaccess") ){
            $fh = fopen($this->storage_path . $this->storage_iden . "/.htaccess", 'w');
            fwrite($fh, "deny from all");
            fclose($fh);
        }
        */

        if( !is_dir($this->storage_path . $this->storage_iden . "/" . date("Y")) ){
            mkdir($this->storage_path . $this->storage_iden . "/" . date("Y"));
        }
    }

    /**
     * Map Files
     *
     * @since 1.0
     * @access public
     * @param string $input_name
     * @param array $validation_rules
     */
    public function uploadFiles($input_name, $validation_rules)
    {
        $file_data = (isset($_FILES[$input_name])) ? $_FILES[$input_name] : false;

        if( $file_data == false ){
            return array();
        }
        if( !(is_array($file_data)) || !(count($file_data) > 0) ){
            return array();
        }

        $file_data = array(
            'name' => (isset($file_data['name'])) ? $file_data['name'] : "",
            'type' => (isset($file_data['type'])) ? $file_data['type'] : "",
            'tmp_name' => (isset($file_data['tmp_name'])) ? $file_data['tmp_name'] : "",
            'error' => (isset($file_data['error'])) ? $file_data['error'] : "",
            'size' => (isset($file_data['size'])) ? $file_data['size'] : "",
        );

        $this->file_data = $file_data;

        $file_url = $this->uploadFile($file_data, $validation_rules);

        return $file_url;
    }

    /**
     * Upload File
     *
     * @since 1.0
     * @param  array $file_data
     * @param  array $validation_rules
     * @return boolean
     */
    public function uploadFile($file_data, $validation_rules)
    {
        if( !isset($file_data['name']) ){
            return false;
        }

        $file_info = pathinfo($file_data['name']);

        if( !isset($file_info['extension']) ){
            return false;
        }

        $file_info['extension'] = strtolower($file_info['extension']);

        if( (isset($file_data['error'])) && ($file_data['error'] > 0) ){
            return false;
        }

        if( !(isset($file_data['tmp_name'])) || ( (isset($validation_rules['supported_extensions'])) && !(in_array($file_info['extension'], $validation_rules['supported_extensions'])) ) ){
            return false;
        }

        if( !(isset($file_data['type'])) || ( (isset($validation_rules['supported_types'])) && !(in_array($file_data['type'], $validation_rules['supported_types'])) ) ){
            return false;
        }

        if( !(isset($file_data['size'])) || ($file_data['size'] > $validation_rules['max_size']) ){
            return false;
        }

        $sub_path = "/" . date("Y") . "/" . date("m");

        if( !is_dir($this->storage_path . $this->storage_iden . $sub_path) ){
            mkdir($this->storage_path . $this->storage_iden . $sub_path);
        }

        if( !is_dir($this->storage_path . $this->storage_iden . $sub_path) ){
            return false;
        }

        $file_info = pathinfo($file_data['name']);
        $file_info['extension'] = strtolower($file_info['extension']);
        $file_name = time() . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 15) . "." . $file_info['extension'];

        $upload_status = (boolean) move_uploaded_file($file_data['tmp_name'], $this->storage_path . $this->storage_iden . $sub_path . "/" . $file_name);

        if( !$upload_status ){
            return false;
        }

        $this->file_data['hash'] = date("Y") . "__" . date("m") . "__" . $file_name;

        return $this->file_data;
    }

    /**
     * Dump File By Hash
     *
     * @since 1.0
     * @access public
     * @param string $hash
     * @return boolean
     */
    public function dumpFileByHash($hash)
    {
        $file_path = $this->storage_path . $this->storage_iden . '/' . str_replace('__', '/', $hash);

        if( (is_file($file_path)) && (file_exists($file_path)) ){
            unlink($file_path);
            return true;
        }
        return false;
    }

    /**
     * Download File By Hash
     *
     * @since 1.0
     * @access public
     * @param string $hash
     * @param string $title
     * @return boolean
     */
    public function getFileDownloadByHash($hash, $title)
    {
        $file_path = $this->storage_path . $this->storage_iden . '/' . str_replace('__', '/', $hash);

        if( (is_file($file_path)) && (file_exists($file_path)) ){
            return $file_path;
        }

        return false;
    }

}
<?php

namespace Clivern\FileUploader;

class Storage
{
    private $dir_name;
    private $dir_path;
    private $year_storage_based;
    private $month_storage_based;

    public funtion setDir($dir_path, $dir_name, $year_storage_based = true, $month_storage_based = true)
    {
        $this->dir_path = rtrim($dir_path, '/') . '/';
        $this->dir_name = $dir_name;
        $this->year_storage_based = $year_storage_based;
        $this->month_storage_based = $month_storage_based;
    }

    public buildStorage()
    {

    }

    public funtion getUploadPath()
    {

    }

    public funtion buildBaseDir()
    {
        if( !$this->dirExists() ){
            return (boolean) @mkdir($this->dir_path . $this->dir_name);
        }
        return true;
    }

    public funtion buildYearDir()
    {
        if( !$this->currentYearDirExists() ){
            return (boolean) @mkdir($this->dir_path . $this->dir_name . "/" . date("Y"));
        }
        return true;
    }

    public funtion buildMonthDir()
    {
        if( !$this->currentMonthDirExists() ){
            return (boolean) @mkdir($this->dir_path . $this->dir_name . "/" . date("Y") . "/" . date("m"));
        }
        return true;
    }

    public funtion dirExists()
    {
        return (boolean) ( is_dir($this->dir_path . $this->dir_name) );
    }

    public funtion currentYearDirExists()
    {
        return (boolean) ( is_dir($this->dir_path . $this->dir_name . "/" . date("Y")) );
    }

    public funtion currentMonthDirExists()
    {
        return (boolean) ( is_dir($this->dir_path . $this->dir_name . "/" . date("Y") . "/" . date("m")) );
    }
}
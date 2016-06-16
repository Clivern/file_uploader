<?php

namespace Clivern\FileUploader;

/**
 * Storage Class
 */
class Storage
{

    /**
     * Storage dir name
     *
     * @since 1.0.0
     * @access private
     * @var string
     */
    private $dir_name;

    /**
     * Storage dir path
     *
     * @since 1.0.0
     * @access private
     * @var string
     */
    private $dir_path;

    /**
     * Whether storage is year based
     *
     * @since 1.0.0
     * @access private
     * @var boolean
     */
    private $year_storage_based;

    /**
     * Whether storage is month based
     *
     * @since 1.0.0
     * @access private
     * @var boolean
     */
    private $month_storage_based;

    /**
     * Class constructor
     *
     * @since 1.0.0
     * @access public
     * @param string $dir_path
     * @param string $dir_name
     * @param boolean $year_storage_based
     * @param boolean $month_storage_based
     */
    public funtion __construct($dir_path, $dir_name, $year_storage_based = true, $month_storage_based = true)
    {
        $this->dir_path = rtrim($dir_path, '/') . '/';
        $this->dir_name = $dir_name;
        $this->year_storage_based = $year_storage_based;
        $this->month_storage_based = $month_storage_based;
    }

    /**
     * Build Storage Folders
     *
     * @since 1.0.0
     * @access public
     * @return boolean
     */
    public buildStorage()
    {

        $base_storage = $this->buildBaseDir();
        if (!$base_storage) {
            throw new \Exception('Error while creating ' . this->dir_path . $this->dir_name);
        }

        $year_based_storage = ($this->year_storage_based) ? $this->buildYearDir() : true;
        if (!$year_based_storage) {
            throw new \Exception('Error while creating ' . $this->dir_path . $this->dir_name . "/" . date("Y"));
        }

        $month_based_storage = ($this->year_storage_based && $this->month_storage_based) ? $this->buildMonthDir() : true;
        if (!$month_based_storage) {
            throw new \Exception('Error while creating ' . $this->dir_path . $this->dir_name . "/" . date("Y") . "/" . date("m"));
        }

        return true;
    }

    /**
     * Get Upload Path
     *
     * @since 1.0.0
     * @access public
     * @return string
     */
    public funtion getUploadPath()
    {
        $path = $this->dir_path . $this->dir_name;

        if ($this->year_storage_based) {
            $path .= "/" . date("Y");
        }

        if ($this->year_storage_based && $this->month_storage_based){
            $path .= "/" . date("m");
        }

        return $path;
    }

    /**
     * Buid base dir if not exist
     *
     * @since 1.0.0
     * @access private
     * @return boolean
     */
    private funtion buildBaseDir()
    {
        if (!$this->baseDirExists()) {
            return (boolean) @mkdir($this->dir_path . $this->dir_name);
        }
        return true;
    }

    /**
     * Build year dir if not exist
     *
     * @since 1.0.0
     * @access private
     * @return boolean
     */
    private funtion buildYearDir()
    {
        if (!$this->currentYearDirExists()) {
            return (boolean) @mkdir($this->dir_path . $this->dir_name . "/" . date("Y"));
        }
        return true;
    }

    /**
     * Build month dir if not exist
     *
     * @since 1.0.0
     * @access private
     * @return boolean
     */
    private funtion buildMonthDir()
    {
        if (!$this->currentMonthDirExists()) {
            return (boolean) @mkdir($this->dir_path . $this->dir_name . "/" . date("Y") . "/" . date("m"));
        }
        return true;
    }

    /**
     * Check if base dir exist
     *
     * @since 1.0.0
     * @access private
     * @return boolean
     */
    private funtion baseDirExists()
    {
        return (boolean) ( is_dir($this->dir_path . $this->dir_name) );
    }

    /**
     * Check if current year dir exist
     *
     * @since 1.0.0
     * @access private
     * @return boolean
     */
    private funtion currentYearDirExists()
    {
        return (boolean) ( is_dir($this->dir_path . $this->dir_name . "/" . date("Y")) );
    }

    /**
     * Check if current month dir exist
     *
     * @since 1.0.0
     * @access private
     * @return boolean
     */
    private funtion currentMonthDirExists()
    {
        return (boolean) ( is_dir($this->dir_path . $this->dir_name . "/" . date("Y") . "/" . date("m")) );
    }
}

<?php

class Uploaded {

    private $_file;
    private $_fileInfo;
    private $_uploadDir;
    private $_details = array();
    private $_error   = 0;

    private $_allowedExtensions = array();
    private $_allowedTypes      = array();
    private $_allowedSize       = null;

    // list of errors
    const ERROR_OK         = 0;
    const ERROR_INI_SIZE   = 1;
    const ERROR_FORM_SIZE  = 2;
    const ERROR_PARTIAL    = 3;
    const ERROR_NO_FILE    = 4;
    const ERROR_NO_TMP_DIR = 6;
    const ERROR_CANT_WRITE = 7;

    const ERROR_EXTENSION  = 100;
    const ERROR_TYPE       = 102;
    const ERROR_SIZE       = 104;
    const ERROR_DIR_NOT_W  = 110;
    const ERROR_UNKNOWN    = 200;

    // titles of errors
    public static $ERRORS = array(
        self::ERROR_OK         => 'There is no error, the file uploaded with success.',
        self::ERROR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        self::ERROR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        self::ERROR_PARTIAL    => 'The uploaded file was only partially uploaded.',
        self::ERROR_NO_FILE    => 'No file was uploaded.',
        self::ERROR_NO_TMP_DIR => 'Missing a temporary folder. Introduced in PHP 5.0.3.',
        self::ERROR_CANT_WRITE => 'Failed to write file to disk. Introduced in PHP 5.1.0.',
        self::ERROR_EXTENSION => 'Extenstion not allowed.',
        self::ERROR_TYPE       => 'Type not allowed.',
        self::ERROR_SIZE       => 'file is to big.',
        self::ERROR_DIR_NOT_W  => 'Directory not writable.',
        self::ERROR_UNKNOWN    => 'Error unkonwo.'
    );

    // some array of mime type
    public static $TYPES = array(
        'image' => array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/png')
    );

    public function __construct($file = null)
    {
        $this->setFile($file);
        $this->_fileInfo = $this->info();
    }

    /**
    *   upload file
    */
    public function up()
    {
        $this->_error = 0;

        if ($this->_file['error'] != 0)
        {
            $this->_error = $this->_file['error'];
            return false;
        }

        if (!$this->isExtensions() || !$this->isType() ||
            !$this->isSize() || !$this->isDirectoryWritable())
        {
            return false;
        }

        $fileName = time() . '_' . $this->name();
        $path     = $this->uploadDirectory() . $fileName;

        $this->_details['basename']  = $fileName;
        $this->_details['directory'] = $this->uploadDirectory();
        $this->_details['location']  = $this->_uploadDir . DIRECTORY_SEPARATOR . $fileName;
        $this->_details['path']      = $path;

        if (move_uploaded_file($this->_file['tmp_name'], $path))
        {
            return true;
        }

        $this->_error = self::ERROR_UNKNOWN;
        return false;
    }

    public function setFile($file)
    {
        $this->_file = $file;
    }

    /**
    *  get path info
    */
    public function info()
    {
        return pathinfo($this->_file['name']);
    }

    public function setUploadDir($dir)
    {
        $this->_uploadDir = rtrim($dir, DIRECTORY_SEPARATOR);
    }

    public function setAllowedExtensions(array $allowedExtensions = null)
    {
        $this->_allowedExtensions = $allowedExtensions;
    }
    public function setAllowedTypes(array $allowedTypes = null)
    {
        $this->_allowedTypes = $allowedTypes;
    }
    public function setAllowedSize($allowedSize = null)
    {
        $this->_allowedSize = $allowedSize;
    }

    /**
    * is extension allowed
    */
    private function isExtensions()
    {
        if (empty($this->_allowedExtensions) ||
            in_array($this->_fileInfo['extension'], $this->_allowedExtensions))
        {
            return true;
        }
        $this->_error = self::ERROR_EXTENSION;

        return false;
    }

    /**
    * is mime type allowed
    */
    private function isType()
    {
        if (empty($this->_allowedTypes) ||
            in_array($this->_file['type'], $this->_allowedTypes))
        {
            return true;
        }
        $this->_error = self::ERROR_TYPE;

        return false;
    }

    /**
    * is size allowed
    */
    private function isSize()
    {
        if ($this->_allowedSize == null ||
            $this->size() <= $this->_allowedSize)
        {
            return true;
        }
        $this->_error = self::ERROR_SIZE;

        return false;
    }

    private function isDirectoryWritable()
    {
        if (is_writable($this->uploadDirectory()))
        {
            return true;
        }
        $this->_error = self::ERROR_DIR_NOT_W;
        return false;
    }

    /**
    * get absolute uploaded directory
    */
    public function uploadDirectory()
    {
        return realpath($this->_uploadDir) . DIRECTORY_SEPARATOR;
    }

    /**
    *  get name of file
    */
    public function name()
    {
        if (isset($this->_file['name'])) {
            return $this->_file['name'];
        }
    }

    /**
    *  get mime type of file
    */
    public function type()
    {
        if (isset($this->_file['type'])) {
            return $this->_file['type'];
        }
    }

    /**
    *  get size of file
    */
    public function size()
    {
        if (isset($this->_file['size'])) {
            return $this->_file['size'];
        }
    }

    /**
    * get error
    */
    public function error()
    {
        return $this->_error;
    }

    /**
    * get details of file uploaded
    */
    public function details()
    {
        return $this->_details;
    }

}

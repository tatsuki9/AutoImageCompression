<?php
/**
 * Created by PhpStorm.
 * User: nyoronyoro-kun
 * Date: 2017/06/26
 * Time: 1:52
 */

class Model_Image_Error
{
    private $file;
    
    public function __construct($file)
    {
        $this->file = $file;
    }
    
    public function handle()
    {
        if (empty($this->file))
        {
            throw new \ErrorException(
                'Uploaded file is not found',
                Error_Image::CODE_ERROR_UPLOADED_FILE_IS_NOT_FOUND
            );
        }
        
        switch ($this->file['error'])
        {
            case UPLOAD_ERR_INI_SIZE:
                throw new \ErrorException(
                    'The uploaded file exceeds the upload_max_filesize directive in php.ini',
                    UPLOAD_ERR_INI_SIZE
                );
                break;
            case UPLOAD_ERR_FORM_SIZE:
                throw new \ErrorException(
                    'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
                    UPLOAD_ERR_FORM_SIZE
                );
                break;
            case UPLOAD_ERR_PARTIAL:
                throw new \ErrorException(
                    'The uploaded file was only partially uploaded',
                    UPLOAD_ERR_PARTIAL
                );
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new \ErrorException(
                    'No file was uploaded',
                    UPLOAD_ERR_NO_FILE
                );
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                throw new \ErrorException(
                    'Missing a temporary folder',
                    UPLOAD_ERR_NO_TMP_DIR
                );
                break;
            case UPLOAD_ERR_CANT_WRITE:
                throw new \ErrorException(
                    'Failed to write file to disk.',
                    UPLOAD_ERR_CANT_WRITE
                );
                break;
            case UPLOAD_ERR_EXTENSION:
                throw new \ErrorException(
                    'A PHP extension stopped the file upload.',
                    UPLOAD_ERR_EXTENSION
                );
                break;
        }
    }
}
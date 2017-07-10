<?php
/**
 * Created by PhpStorm.
 * User: nyoronyoro-kun
 * Date: 2017/07/02
 * Time: 16:44
 */

class Error_Image extends \ErrorException
{
    const CODE_ERROR_NOT_INT    = 1;
    const CODE_ERROR_NOT_FLOAT  = 2;
    const CODE_ERROR_NOT_DOUBLE = 3;
    const CODE_ERROR_NOT_STRING = 4;

    const CODE_ERROR_UPLOADED_FILE_IS_NOT_FOUND = 10;
    const CODE_ERROR_EXTENSION_IS_NOT_SUPPORTED = 11;
}
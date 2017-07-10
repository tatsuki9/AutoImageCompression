<?php
/**
 * Created by PhpStorm.
 * User: nyoronyoro-kun
 * Date: 2017/06/26
 * Time: 1:48
 */
class Controller_Image_Base extends Controller_Hybrid
{
    protected function validate_file($file)
    {
        $validater = new Model_Image_Error($file);
        $validater->handle();
    }

    protected function validate_params_type($params)
    {
        foreach($params as $param_info)
        {
            switch($param_info['type'])
            {
                case 'int':
                    if (!is_numeric($param_info['value']))
                    {
                        throw new Error_Image(
                            'parameter : '.$param_info['value']." is not int.",
                            Error_Image::CODE_ERROR_NOT_INT
                        );
                    }
                    break;
                case 'float':
                    if (!is_float($param_info['value']))
                    {
                        throw new Error_Image(
                            'parameter : '.$param_info['value']." is not float.",
                            Error_Image::CODE_ERROR_NOT_FLOAT
                        );
                    }
                    break;
                case 'double':
                    if (!is_double(
                        $param_info['value']))
                    {
                        throw new Error_Image(
                            'parameter : '.
                            $param_info['value']." is not double.",
                            Error_Image::CODE_ERROR_NOT_DOUBLE
                        );
                    }
                    break;
                case 'string':
                    if (!is_string(
                        $param_info['value']))
                    {
                        throw new Error_Image(
                            'parameter : '.$param_info['value']." is not string.",
                            Error_Image::CODE_ERROR_NOT_STRING
                        );
                    }
            }
        }
    }
}
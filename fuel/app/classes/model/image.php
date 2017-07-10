<?php
/**
 * Created by PhpStorm.
 * User: nyoronyoro-kun
 * Date: 2017/06/26
 * Time: 1:26
 */

class Model_Image
{
    const ZIP_FILE = '../resize_result/result.zip';

    public static function resize_and_crop($file)
    {
        $org_filename = $file['tmp_name'];

        $type = "";
        if (preg_match('/image\/([a-z]+)/', $file['type'], $m))
        {
            $type = $m[1];
        }

        switch($type)
        {
            case 'png':
                $image = imagecreatefrompng($org_filename);
                break;
            case 'jpeg':
            case 'jpg':
                $image = imagecreatefromjpeg($org_filename);
                break;
            default:
                throw new Error_Image(
                    'extension of you uploaded file is not supported',
                    Error_Image::CODE_ERROR_EXTENSION_IS_NOT_SUPPORTED
                );
                break;
        }
        $compression_info = Model_Tbl_Image_CompressionInfo::find_all_by();

        // 前回圧縮したファイルを削除
        self::delete('../resize_result/*');

        $compressioned_files = array();
        foreach($compression_info as $index => $info)
        {
            for($i = 0; $i < $info['num']; $i++)
            {
                $output = '../resize_result/'.$info['id']."_".$i.".".$type;
                $compressioned_files[] = self::execute($image, $output, $info, $type);
            }
        }

        $zip = new ZipArchive();
        $zip->open(self::ZIP_FILE, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        foreach($compressioned_files as $filename)
        {
            $zip->addFile($filename);
        }
        $zip->close();

        return self::ZIP_FILE;
    }

    public static function regist($data)
    {
        Model_Tbl_Image_CompressionInfo::insert(array(
            'width'  => $data['width'],
            'height' => $data['height'],
            'num'    => $data['num'],
        ));
    }

    public static function remove($data)
    {
        Model_Tbl_Image_CompressionInfo::delete(array(
            'and' => array(
                'id' => $data['id'],
            ),
        ));
    }

    private static function execute($image, $filename, $info, $type)
    {
        $thumb_width  = $info['width'];
        $thumb_height = $info['height'];

        $width  = imagesx($image);
        $height = imagesy($image);

        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;

        if ( $original_aspect >= $thumb_aspect )
        {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ($height / $thumb_height);
        }
        else
        {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }

        $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

        // Resize and crop
        imagecopyresampled($thumb,
            $image,
            0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height);

        switch ($type)
        {
            case 'png':
                imagepng($thumb, $filename, 9);
                break;
            case 'jpeg':
            case 'jpg':
                imagejpeg($thumb, $filename, 100);
                break;
        }

        return $filename;
    }

    private static function delete($delete_path)
    {
        $delte_list = glob($delete_path, GLOB_MARK);
        foreach($delte_list as $path)
        {
            unlink($path);
        }
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: nyoronyoro-kun
 * Date: 2017/06/05
 * Time: 1:49
 */

class Controller_Image extends Controller_Image_Base
{
    public function action_index()
    {
        // 圧縮リスト取得
        $compression_info = Model_Tbl_Image_CompressionInfo::find_all_by();
        $data = array(
            'compression_info' => $compression_info,
        );
        return View::forge('image/index', $data);
    }

    public function action_regist_resize()
    {
        $params = Input::param();
        $width  = Arr::get($params, 'width', 0);
        $height = Arr::get($params, 'height', 0);
        $num    = Arr::get($params, 'num', 0);

        // 型チェック
        parent::validate_params_type(array(
            array(
                'type'  => 'int',
                'value' => $width,
            ),
            array(
                'type'  => 'int',
                'value' => $height,
            ),
            array(
                'type'  => 'int',
                'value' => $num,
            )
        ));

        // 圧縮サイズを登録
        Model_Image::regist(array(
            'width'  => $width,
            'height' => $height,
            'num'    => $num,
        ));

        return Response::redirect('image/index');
    }

    /*
     * ↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓REST API↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
     */
    public function post_delete()
    {
        $params = Input::param();
        $id     = Arr::get($params, 'id', 0);

        // 型チェック
        parent::validate_params_type(array(
            array(
                'type'  => 'int',
                'value' => $id,
            ),
        ));

        // 登録の削除
        Model_Image::remove(array(
            'id' => $id,
        ));

        return $this->response->body = array(
            'delete_id' => $params['id'],
        );
    }

    public function post_resize_and_crop()
    {
        $file_info = Input::file();
        $file = Arr::get($file_info, 'userfile', array());

        // アップロードされたファイルのチェック
        parent::validate_file($file);

        $file_path = Model_Image::resize_and_crop($file);

        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="hogehoge.zip"');
        // Content-Length付けないと、ダウンロードしたファイルが空になってしまう
        header('Content-Length: '.filesize($file_path));
        readfile($file_path);
    }
}
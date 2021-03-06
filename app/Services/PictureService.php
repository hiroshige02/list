<?php

namespace App\Services;

use App\MasterDefine;
use App\Models\Picture;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PictureService
{


    /**
     * 画像のバリデーションを通す拡張子の配列
     *
     */
    const EXTENSION = [
        'jpeg',
        'png',
        'jpg',
        'bmb',
        'gif'
    ];

    /**
     * 画像IDが編集中の酒IDと結びついているかチェック
     *
     * @param array $picture_ids
     * @param int $id
     *
     */
    public function checkSakeRelation($picture_ids, $id) {
        foreach($picture_ids as $p_id){
            $picture = Picture::find($p_id);
            if(empty($picture) || ($picture->sake_id != $id)){
                abort(505, '不正な画像データです。');
            }
        }
        return;
    }


    /**
     * postされた画像にバリデーションをかけて通ったら仮ディスクに保存
     *
     * @param int $user_id
     * @param array $upload_files
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return \Illuminate\Validation\Validator $validator
     *
     */
    public function validateStoreImage($user_id, $upload_files, $validator){
        if (empty($upload_files)
        || (empty($upload_files))
        || (empty($validator))) {
            return;
        }

        foreach ($upload_files as $file) {
            if(empty($file->getSize())){
                $validator->errors()->add('file', "画像サイズが2M以下か確認してください。");
                Log::info('failed image file update');
                return $validator;
            }
            $post_file = new File($file);

            $file_name = $file->getClientOriginalName();
            $extension = $post_file->extension();

            if (!in_array($extension, static::EXTENSION)) {
                $mime_type = implode(',', static::EXTENSION);
                $validator->errors()->add('file', "画像{$file_name}は{$mime_type}のうちいずれかの形式にしてください");
                continue;
            }

            //バリデーション に問題がなければ仮ディスクに格納する
            $path = $file->storeAs("/img/tmp/{$user_id}", $file_name, ['disk' => 'public']);
        }

        return $validator;
    }


    /**
     * 酒IDに結びつくS3の画像データを取得する
     *
     * @param int $sake_id
     * @param array $not_display
     * @param boolean $if_confirm
     * @return array $image_datas
     *
     */
    public function getS3ImageData($sake_id,$not_display=[],$if_confirm=false){
        $image_datas = [];

        $images = Picture::whereSakeId($sake_id)->get();
        if (!empty($images)) {
            foreach ($images as $image) {

                //削除予定の画像であれば表示しないためデータに含まない
                if(in_array($image->id, $not_display)){
                    continue;
                }
                $image_datas[] = [
                    'id' => $image->id,
                    'path' => $image->image_path,
                    'confirm_flag' => $if_confirm
                ];
            }
        }

        return $image_datas;
    }




  /**
     * ユーザーIDに結びつく仮ディスク内の画像を取得する
     *
     * @param int $user_id
     * @return array $images
     *
     */
    public function getTentativeImage($user_id){
        $images = [];
        if (!empty(Storage::disk('public')->exists("img/tmp/{$user_id}"))) {
            $images = Storage::disk('public')->files("img/tmp/{$user_id}");
        }
        return $images;
    }

    /**
     * ユーザーIDに結びつく仮ディスク内の画像パスのデータを取得する
     *
     * @param int $user_id
     * @param boolean $if_confirm
     * @return array $image_datas
     *
     */
    public function getTentativeImageData($user_id,$if_confirm=false){
        $new_images = [];
        if(!empty(Storage::disk('public')->exists("img/tmp/{$user_id}"))){
            $storage_files = Storage::disk('public')->files("img/tmp/{$user_id}");
            foreach($storage_files as $f){
                $f = basename($f);
                $new_images[] = [
                    'path' => $f,
                    'create_flag' => true,
                    'confirm_flag' => $if_confirm
                ];
            }
        }
        return $new_images;
    }

    /**
     * ユーザーIDに結びつく仮ディスクを削除する
     *
     * @param int $user_id
     * @return void
     *
     */
    public function deleteTentativeImageData($user_id){
        $storage_files = Storage::disk('public')->exists("img/tmp/{$user_id}");
        if(empty($storage_files)){
            return;
        }
        Storage::disk('public')->deleteDirectory("img/tmp/{$user_id}");

        return;
    }

    /**
     * 登録用のPictureデータを作る
     *
     * @param int $user_id
     * @param int $sake_id
     * @return array $picture_datas
     *
     */
    public function makePictureData($sake_id, $user_id) {
        $file_paths = Storage::disk('public')->files("img/tmp/{$user_id}");
        $picture_datas = [];
        foreach($file_paths as $f){
            $path = Storage::disk('s3')->putFile('sake', 'storage/app/public/' . $f, 'public');
            $picture = new Picture;
            $picture->image_path = Storage::disk('s3')->url($path);
            $picture->sake_id = $sake_id;
            $picture_datas[] = $picture;
        }
        return $picture_datas;
    }

}


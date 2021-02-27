<?php

namespace App\Http\Controllers\Maintenance;

use Exception;
use App\Models\Sake;
use App\MasterDefine;
use App\Models\Picture;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Services\SakeService;
use App\Models\MakerEvaluation;
use App\Services\PictureService;
use App\Models\PersonalEvaluation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Exceptions\HttpResponseException;

class SakeController extends Controller
{

    /**
     * Sakeサービス
     *
     * @var \App\Services\SakeService
     */
    protected $sakeService;

    /**
     * Pictureサービス
     *
     * @var \App\Services\PictureService
     */
    protected $pictureService;

    /**
     * コンストラクタ
     *
     * @param SakeService $sakeService
     * @param PictureService $pictureService
     */
    public function __construct(SakeService $sakeService, PictureService $pictureService)
    {
        $this->sakeService = $sakeService;
        $this->pictureService = $pictureService;
    }


    /**
     * 詳細画面から「戻る」際に必要なセッションをセット
     *
     * @param int $sake_id
     * @param int $page
     * @param \Illuminate\Http\Request $request
     * @return void
     *
     */
    public function pageSet($sake_id, $page, Request $request)
    {
        $request->session()->put('page_number', $page);
        return redirect("/maintenance/sake/{$sake_id}");
    }

    /**
     * 酒の詳細表示画面に遷移
     *
     * @param int $sake_id
     * @param \Illuminate\Http\Request $request
     * @return void
     *
     */
    public function show($sake_id, Request $request)
    {
        $joined_data = Sake::getSakeDatasFromId($sake_id)->first();
        if (empty($joined_data)) {
            //酒が存在しない
            Log::info('sake show NOT EXIST id:' . $sake_id);
            abort(500);
        }

        $viewData = [];
        $viewData['title'] = $joined_data->name . "({$joined_data->name_kana})";

        $datas = $this->sakeService->getConfirmColumns();
        foreach ($datas as $column => &$data) {
            if (!empty($data['pulldown']) && !empty($joined_data->{$column})) {
                $datas[$column]['value'] = $data['pulldown'][$joined_data->{$column}];
                //プルダウン選択肢は不要
                unset($data['pulldown']);
                continue;
            }

            $datas[$column]['value'] = $joined_data->{$column};
        }

        //画像のパスを取得
        $image_datas = $this->pictureService->getS3ImageData($sake_id);
        $viewData['images'] = array_column($image_datas, "path");
        $viewData['datas'] = $datas;
        $viewData['sake_id'] = $sake_id;
        //カルーセルスライダーの画面上の表示枚数
        $viewData['set_per_page'] = 2;

        $rader_data = $this->sakeService->getRaderDatas($joined_data);
        $viewData['rader_data'] = $rader_data;

        if (!empty($request->session()->get('prefecture'))) {
            $viewData['back_to'] = "/maintenance/sake/prefecture/{$request->session()->get('prefecture')}";
        }

        return view('maintenance.sake', $viewData);
    }

    /**
     * アイテム作成画面に遷移
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $user_id = Auth::user()->id;

        $viewData = [];

        //戻る or リダイレクトの時にstorage内の仮ディスクを呼び出して格納。
        $images=[];

        //画像データ取得のために
        $flag = false;
        $old_input = null;
        $old_prefecture = null;

        //リダイレクトした時と戻るの時
        if (!empty($request->session()->get('preserve'))) {
            $old_input = $request->old();
            $images = $this->pictureService->getTentativeImageData($user_id);
        } elseif (!empty($request->session()->get('back'))) {
            $flag = true;
            $old_input = $request->old();
            $images = $this->pictureService->getTentativeImageData($user_id);
        } else {
            //最初の遷移時には仮ディスクの画像は全て消去する
            $this->pictureService->deleteTentativeImageData($user_id);
        }

        //確認画面から戻ってき時に画像の仮フォルダを削除
        $viewData['user_id'] = $user_id;
        $viewData['title'] = '新規登録';
        $viewData['sake_info'] = $this->sakeService->getSakeOptions();

        if (isset($old_input['prefecture'])) {
            $old_prefecture = $old_input['prefecture'];
        }

        $viewData['tasts'] = $this->sakeService->getTasteOptions($old_input);
        $viewData['evaluations'] = $this->sakeService->getMakerEvaluations($old_input, $flag);
        $viewData['prefecture'] = $this->sakeService->getPrefectureOptions($old_prefecture, $flag);
        $viewData['input_images'] = $images;

        return view('maintenance.sake-create', $viewData);
    }

    /**
     * バリデーションルールを返す
     *
     * @return array
     */
    public function getSakeValidationRules()
    {
        $rules = [
            'name' => ['required','string','max:256'],
            'name_kana' => ['required','string','max:256','regex:/^[ァ-ヶー　]+$/u'],
            'kura' => ['required','string','max:256'],
            'prefecture' => ['required','string'],
            'sweetness' => ['required','string'],
            'acidity' => ['required','string'],
            'richness' => ['required','string'],
            'cost_performance' => ['required','string'],
            'recommend_point' => ['required','string'],
            'sake_degree' => ['nullable','string'],
            'amino_acid_degree' => ['nullable','string'],
            'memo' => ['required','string','max:1000'],
            // 'file' => 'nullable|array',
            'file.*' => ['nullable','max:5000'],
        ];

        return $rules;
    }

    /**
      * バリデーション用オリジナルメッセージ
      *
      * @return array
      *
      */
    public function customMessages()
    {
        return [
            'name_kana.regex' => '酒名(全角カタカナ)はカタカナのみで入力してください',
            // 'file.*.max' => '最大ファイルサイズを超えています'
        ];
    }

    /**
     * アイテム作成確認画面遷移
     *
     * @param \Illuminate\Http\Request
     * @return void
     *
     */
    public function createConfirm(Request $request)
    {
        $user_id = Auth::user()->id;

        //バリデーション
        $validator = Validator::make(
            $request->all(),
            $this->getSakeValidationRules(),
            $this->customMessages()
        );

        // var_dump($validator->errors());exit;
        if (!empty($request->file('file'))) {
            //上記メソッドでバリデーションを通過した画像は仮ディスクに保管される
            $validator = $this->pictureService->validateStoreImage($user_id, $request->file('file'), $validator);
        }

        if ($validator->fails()) {
            //バリデーション を通過した画像はリダイレクト先で表示する。そのためのサイン
            $request->session()->flash('preserve', true);
            return redirect('/maintenance/sake/create')->withInput()
            ->withErrors($validator);
        }

        $viewData = [];
        $viewData['title'] = '新規登録確認';

        $datas = $this->sakeService->getConfirmColumns($request->post());

        //確認画面のモーダル用のデータを取得
        $new_images = $this->pictureService->getTentativeImageData($user_id, true);

        $viewData['user_id'] = $user_id;
        $viewData['datas'] = $datas;
        $viewData['new_images'] = $new_images;

        return view('maintenance.sake-create-confirm', $viewData);
    }

    /**
     * アイテム作成完了画面遷移
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     *
     */
    public function createComplete(Request $request)
    {
        //戻るボタン押下の際
        $back = $request->post('back', false);
        if ($back !== false) {
            $request->session()->flash('back', true);
            return redirect('/maintenance/sake/create')->withInput();
        }

        //バリデ〜ション
        $validator = Validator::make(
            $request->all(),
            $this->getSakeValidationRules(),
            $this->customMessages()
        );
        if ($validator->fails()) {
            return redirect('/maintenance/sake/create')->withInput()
            ->withErrors($validator);
        }

        //sakesデータ
        $sake = new Sake;
        $personal = new PersonalEvaluation;
        $maker = new MakerEvaluation;

        $post_data = $request->post();
        $create_sake = $this->sakeService->makeSakeData($sake, $post_data);
        $create_personal = $this->sakeService->makePersonalData($personal, $post_data);
        $create_maker = $this->sakeService->makeMakerData($maker, $post_data);

        $user_id = Auth::user()->id;

        //トランザクション開始
        DB::transaction(function () use ($create_sake,$create_personal,$create_maker,$user_id) {
            $create_sake->save();
            $sake_id = $create_sake->id;

            $create_personal->sake_id = $sake_id;
            $create_personal->save();

            $create_maker->sake_id = $sake_id;
            $create_maker->save();

            $pictures = [];
            if(Storage::disk('public')->exists("img/tmp/{$user_id}")){
                $pictures = $this->pictureService->makePictureData($sake_id, $user_id);
                foreach($pictures as $picture) {
                    $picture->save();
                }
            }

            //仮ディスクを削除
            $this->pictureService->deleteTentativeImageData($user_id);

        });

        $viewData = [];
        $viewData['title'] = '新規登録完了';
        $viewData['sake_id'] = $sake->id;

        return view('maintenance.sake-create-complete', $viewData);
    }

    /**
     * アイテム編集画面遷移
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return void
     *
     */
    function edit($id, Request $request){
        //該当ID酒の存在チェック
        $sake = Sake::find($id);
        if(empty($sake)){
            Log::info('sake edit NOT FOUND : id '.$id);
            abort(500, '該当するお酒がありません。');
        }

        $sake_id = $sake->id;
        $user_id = Auth::user()->id;
        $personal = PersonalEvaluation::whereSakeId($sake_id)->first();
        $maker = MakerEvaluation::whereSakeId($sake_id)->first();

        $viewData = [];
        $flag = false;

        $tentative_images = [];
        $delete_image_ids = [];

        if (!empty($request->session()->get('preserve'))) {
            $tentative_images = $this->pictureService->getTentativeImageData($user_id);
            if (!empty($request->old('delete_image_ids'))) {
                $delete_image_ids = $request->old('delete_image_ids');
            }
        }elseif (!empty($request->session()->get('back'))) {
            $flag = true;
            $tentative_images = $this->pictureService->getTentativeImageData($user_id);
            if (!empty($request->old('delete_image_ids'))) {
                $delete_image_ids = $request->old('delete_image_ids');
            }
        }else{
            //最初の遷移時には仮ディスクの画像は全て消去する
            $this->pictureService->deleteTentativeImageData($user_id);
        }

        $viewData['title'] = '編集';

        $old_input = null;
        if(!empty($request->old())){
            $old_input = $request->old();
        }

        $viewData['sake_info'] = $this->sakeService->getSakeOptions($sake);
        $viewData['sake_id'] = $id;
        $viewData['user_id'] = $user_id;

        $viewData['tasts'] = $this->sakeService->getTasteOptions($old_input,$personal);
        $viewData['evaluations'] = $this->sakeService->getMakerEvaluations($old_input,$flag,$maker,'edit');

        $old_prefecture = null;

        if(!empty($old_input['prefecture'])){
            $old_prefecture = $old_input['prefecture'];
        }

        $viewData['prefecture'] = $this->sakeService->getPrefectureOptions($old_prefecture,$flag,$sake['prefecture'],'edit');

        $memo = $sake->memo;
        if(!empty($old_input['memo'])){
            $memo = $old_input['memo'];
        }

        $viewData['memo'] = $memo;

        $images = $this->pictureService->getS3ImageData($id,$delete_image_ids);

        $viewData['image_datas'] = $images;
        $viewData['delete_image_ids'] = $delete_image_ids;
        $viewData['tentative_images'] = $tentative_images;

        return view('maintenance.sake-edit', $viewData);
    }

    /**
     * アイテム編集確認画面遷移
     *
     * @param int $id
     * @param \Illuminate\Http\Request
     * @return void
     *
     */
    function editConfirm($id, Request $request)
    {
        //「戻る」クリック
        $back = $request->post('back', false);
        if ($back !== false) {
            $page_number = $request->session()->get('page_number');
            return redirect("/maintenance/sake/{$id}/{$page_number}");
        }

        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(),
        $this->getSakeValidationRules(),$this->customMessages());

        if(!empty($request->file('file'))){
            $validator = $this->pictureService
            ->validateStoreImage($user_id,$request->file('file'),$validator);
        }

        if ($validator->fails()) {
            $request->session()->flash('preserve', true);

            return redirect("/maintenance/sake/{$id}/edit")->withInput()
            ->withErrors($validator);
        }

        $viewData = [];
        $viewData['title'] = '編集確認';

        $user_id = Auth::user()->id;
        $viewData['user_id'] = $user_id;

        //削除予定Pictureのid
        $delete_ids = $request->get('delete_image_ids') ? $request->get('delete_image_ids'):[];

        if (!empty($request->get('redirect_delete_image_ids'))) {
            $delete_ids = array_merge($delete_ids,$request->get('redirect_delete_image_ids'));
        }

        //結びつく画像データについて取得
        $exist_images = $this->pictureService->getS3ImageData($id, $delete_ids, true);

        $viewData['delete_image_ids'] = $delete_ids;
        //このidとmerged_delete_idsとの付き合わせを行う。
        if (count($delete_ids) > 0) {
            foreach ($exist_images as $key => $i) {
                if (!in_array($i['id'], $delete_ids)) {
                    unset($i);
                }
            }
        }

        $new_images = $this->pictureService->getTentativeImageData($user_id,true);

        $datas = $this->sakeService->getConfirmColumns($request->post());

        $viewData['datas'] = $datas;

        $viewData['new_images'] = $new_images;
        $viewData['exist_images'] = $exist_images;
        $viewData['sake_id'] = $id;

        return view('maintenance.sake-edit-confirm', $viewData);
    }


    /**
     * アイテム編集画面遷移
     *
     * @param int $id
     * @param \Illuminate\Http\Request $requsest
     * @return void
     *
     */
    function update($id,Request $request){
        //戻るボタン押下
        $back = $request->post('back', false);
        if($back !== false){
            $request->session()->flash('back', true);
            return redirect("/maintenance/sake/{$id}/edit")->withInput();
        }

        //バリデ〜ション
        $validator = Validator::make($request->all(),
        $this->getSakeValidationRules());
        if ($validator->fails()) {
            return redirect("/maintenance/sake/{$id}/edit")->withInput()
            ->withErrors($validator);
        }

        $sake  = Sake::find($id);
        $personal = PersonalEvaluation::whereSakeId($id)->first();
        $maker = MakerEvaluation::whereSakeId($id)->first();

        if(empty($sake) || empty($personal) || empty($maker)) {
            //エラー処理
            Log::info('sake update NOT FOUND : id'.$id);
            abort(500);
        }

        //sakesデータ作成
        $post_data = $request->post();
        $update_sake = $this->sakeService->makeSakeData($sake, $post_data);
        $update_personal = $this->sakeService->makePersonalData($personal, $post_data);
        $update_maker = $this->sakeService->makeMakerData($maker, $post_data);

        $user_id = Auth::user()->id;

        $delete_ids = [];
        if (!empty($request->get('delete_image_ids'))) {
            $delete_ids = $request->get('delete_image_ids');

            //酒と結びついたPictureかどうか確認。一つでもあったらエラー
            $this->pictureService->checkSakeRelation($delete_ids, $id);
        }

        $pictures = [];
        if(Storage::disk('public')->exists("img/tmp/{$user_id}")){
            $pictures = $this->pictureService->makePictureData($id, $user_id);
        }

        //トランザクション開始
        DB::transaction(function () use ($id,$update_sake,$update_personal,$update_maker,$pictures,$user_id,$delete_ids) {
            $update_sake->update();
            $update_personal->update();
            $update_maker->update();

            foreach($pictures as $picture) {
                $picture->save();
            }

            foreach($delete_ids as $d_id){
                $picture =  Picture::find($d_id);
                Storage::disk('s3')->delete('/', $picture->image_path);
                $picture->delete();
            }

            //仮ディスクを削除
            Storage::disk('public')->deleteDirectory("img/tmp/{$user_id}");

        });

        // 二重送信対策
        $request->session()->regenerateToken();

        $viewData = [];
        $viewData['sake_id'] = $id;
        $viewData['title'] = '編集完了';

        return view('maintenance.sake-edit-complete', $viewData);
    }


    /**
     * storage/app/public/img 以下の仮ディスクのイメージファイルを削除する
     *
     * @param \Illuminate\Http\Request
     * @return void
     */
    public function tentativeImageDelete(Request $request){

        $user_id = $request->get('user_id');
        $image_source = $request->get('image_source');

        //そもそもpostしちゃいけないのでは？？要修正
        if(!empty($request->post('create_flag'))){

            //ここ確かめる
            Log::debug('create IS!!!!!');
            $image_name = basename($image_source);
            Storage::disk('public')->delete("img/tmp/{$user_id}/{$image_name}");

        }
        return;
    }


}

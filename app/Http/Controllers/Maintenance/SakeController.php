<?php

namespace App\Http\Controllers\Maintenance;

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
     * コンストラクタ
     *
     * @param int $sakeService
     * @return void
     *
     */
    public function prefectureIndex($prefecture)
    {
        $prefecture_keys = array_keys(MasterDefine::PREFECTURES);

        if (!in_array($prefecture, $prefecture_keys)) {
            //エラー処理
        }

        $sakes = Sake::wherePrefecture($prefecture)->get();
        $datas = [];
        foreach($sakes as $sake){
            $pictures = Picture::whereSakeId($sake->id)->first();

            //現状画像一枚しか表示しないようになっている
            $image_path = null;
            if (!empty($pictures)) {
                $image_path = $pictures->image_path;
            }
            // $image_path = [];
            // foreach ($pictures as $picture) {
            //     $image_paths[] = $picture->image_path;
            // }

            $datas[] = [
                'sake_id' => $sake->id,
                'name' => $sake->name,
                'kura' => $sake->kura,
                'image_path' => $image_path
            ];
        }

        $viewData = [];
        $viewData['datas'] = $datas;

        $prefecture_name = MasterDefine::PREFECTURES[$prefecture];
        $viewData['title'] = $prefecture_name . 'のお酒';

        // var_dump($viewData['datas']);exit;

        return view('maintenance.sake-index', $viewData);
    }

    /**
     * 検索結果表示
     *
     * @return void
     */
    public function searched()
    {
        $viewData = [];
        $viewData['title'] = "'さわ音'検索結果";

        return view('maintenance.searched', $viewData);
    }


    public function show($id)
    {
        //該当ID酒の存在チェック

        $viewData = [];
        $viewData['title'] = 'さわ音';
        $viewData['set_per_page'] = 2;

        return view('maintenance.sake', $viewData);
    }

    /**
     * 作成画面
     *
     * @param \Illuminate\Http\Request
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
            $flag = true;
            $images = $this->pictureService->getTentativeImageData($user_id);
        }else{
            //最初の遷移時には仮ディスクの画像は全て消去する
            $this->pictureService->deleteTentativeImageData($user_id);
        }

        //確認画面から戻ってき時に画像の仮フォルダを削除
        $viewData['user_id'] = $user_id;
        $viewData['title'] = '新規登録';
        $viewData['sake_info'] = $this->sakeService->getSakeOptions();

        if(!empty($old_input['prefecture'])){
            $old_prefecture = $old_input['prefecture'];
        }

        $viewData['tasts'] = $this->sakeService->getTasteOptions($old_input);
        $viewData['evaluations'] = $this->sakeService->getMakerEvaluations($old_input,$flag);
        $viewData['prefecture'] = $this->sakeService->getPrefectureOptions($old_prefecture,$flag);
        $viewData['input_images'] = $images;

        return view('maintenance.sake-create', $viewData);
    }

    public function getSakeValidationRules()
    {
        $rules = [
            'name' => ['required','string','max:256'],
            // 'name_kana' => ['required','string','max:256','regex:/^[ァ-ヶー]+$/'],
            // 'kura' => ['required','string'],
            // 'prefecture' => ['required','string'],
            // 'sweetness' => ['required','string'],
            // 'acidity' => ['required','string'],
            // 'richness' => ['required','string'],
            // 'cost_performance' => ['required','string'],
            // 'recommend_point' => ['required','string'],

            // 'sake_degree' => ['string'],
            // 'amino_acid_degree' => ['string'],

            // 'memo' => ['string','max:1000']

            //
            // 'file' => ['nullable','mimes:jpeg,png,jpg,gif,bmb','max:2048'],
            // 'file' => 'nullable|mimes:jpeg,png,jpg,gif,bmb|max:2048',
            // 'file' => ['file','mimes:jpeg,png,jpg,bmb','max:2048'],
            // 'file' => 'mimes:jpeg,png,bmb',
            // 'file' => 'file',
        ];

        return $rules;
    }

   /**
     * バリデーション用オリジナルメッセージ
     *
     * @param \Illuminate\Http\Request
     */
    public function customMessages(){
        return [
            'name_kana.regex' => '酒名(全角カタカナ)はカタカナのみで入力してください'
        ];
    }

    /**
     * 作成確認画面遷移
     *
     * @param \Illuminate\Http\Request
     */
    function createConfirm(Request $request)
    {
        $user_id = Auth::user()->id;
        $files = [];

        //バリデーション
        $validator = Validator::make($request->all(),
        $this->getSakeValidationRules(),$this->customMessages());

        if (!empty($request->file('file'))) {
            //上記メソッドでバリデーションを通過した画像は仮ディスクに保管される
            $validator = $this->pictureService->validateStoreImage($user_id,$request->file('file'),$validator);
        }

        // var_dump($validator->errors());exit;で出るのみ下のかっこの中に入らない！なぜ？？

        if ($validator->fails()) {
            //バリデーション を通過した画像はリダイレクト先で表示する。そのためのサイン
            $request->session()->flash('preserve', true);
            return redirect('/maintenance/sake/create')->withInput()
            ->withErrors($validator);
        }

        $viewData = [];
        $viewData['title'] = '新規登録確認';

        $datas = $this->sakeService->getConfirmColumns();

        foreach ($datas as $column => $post) {
            if (!isset($post['pulldown'])) {
                $datas[$column]['value'] = $request->get($column);
            }else{
                $pulldown_keys = array_keys($post['pulldown']);
                //postした値が
                $datas[$column]['value'] = null;
                if($request->get($column) !== false && (!is_null($request->get($column)))
                && (in_array($request->get($column), $pulldown_keys))){

                    $datas[$column]['value'] = $post['pulldown'][$request->get($column)];
                }
            }
        }

        //確認画面のモーダル用のデータを取得
        $new_images = $this->pictureService->getTentativeImageData($user_id, true);

        $viewData['user_id'] = $user_id;
        $viewData['datas'] = $datas;
        $viewData['new_images'] = $new_images;

        return view('maintenance.sake-create-confirm', $viewData);
    }


    function createComplete(Request $request){

        // var_dump($request->post());exit;

        //戻るボタン押下の際
        $back = $request->post('back', false);
        if($back !== false){
            $request->session()->flash('preserve', true);
            return redirect('/maintenance/sake/create')->withInput();
        }

        //バリデ〜ション
        $validator = Validator::make($request->all(),
        $this->getSakeValidationRules());
        if ($validator->fails()) {
            // var_dump($validator->errors());exit;
            return redirect('/maintenance/sake/create')->withInput()
            ->withErrors($validator);
        }

        //sakesデータ
        $sake = new Sake;
        $sake->name = $request->post('name');
        $sake->name_kana = $request->post('name_kana');
        $sake->kura = $request->post('kura');
        $sake->memo = $request->post('memo');
        //post値をキーに置き換えるような
        $sake->prefecture = array_search($request->post('prefecture'),MasterDefine::PREFECTURES);

        //personal_evaluationsデータ
        $personal = new PersonalEvaluation;
        $personal->sweetness = $request->post('sweetness');
        $personal->acidity = $request->post('acidity');
        $personal->richness = $request->post('richness');
        $personal->cost_performance = $request->post('cost_performance');
        $personal->recommend_point = $request->post('recommend_point');

        //maker_evaluationsデータ
        $maker = new MakerEvaluation;
        $maker->sake_degree = array_search($request->post('sake_degree'),MasterDefine::SAKE_DEGREES);
        $maker->amino_acid_degree = array_search($request->post('amino_acid_degree'),MasterDefine::AMINO_ACID_DEGREES);

        $user_id = Auth::user()->id;


        //トランザクション開始
        DB::transaction(function () use ($sake,$personal,$maker,$request,$user_id) {
            $sake->save();
            $sake_id = $sake->id;

            if(Storage::disk('public')->exists("img/tmp/{$user_id}")){
                $file_paths = Storage::disk('public')->files("img/tmp/{$user_id}");
                // var_dump($file_paths);exit; //array(1) { [0]=> string(21) "img/tmp/1/english.jpg" }
                foreach($file_paths as $f){
                    $path = Storage::disk('s3')->putFile('sake', 'storage/app/public/' . $f, 'public');

                    $picture = new Picture;
                    $picture->image_path = Storage::disk('s3')->url($path);
                    $picture->sake_id = $sake_id;
                    $picture->save();
                }
            }

            $personal->sake_id = $sake_id;
            $personal->save();

            $maker->sake_id = $sake_id;
            $maker->save();

            //仮ディスクを削除
            $this->pictureService->deleteTentativeImageData($user_id);

        });

        $viewData = [];
        $viewData['title'] = '新規登録完了';
        $viewData['sake_id'] = $sake->id;

        // var_dump($viewData);exit;

        return view('maintenance.sake-create-complete', $viewData);
    }


    function edit($id,Request $request){
        // return view('errors.404', ['title' => 'ご指定のページが見つかりません']);
        // abort(404, 'Not Found');
        // throw new \Exception("testです");
        // var_dump($request->old());exit;

        //該当ID酒の存在チェック
        $sake = Sake::find($id);
        if(empty($sake)){
            var_dump('eieoio');exit; //エラーハンドリング必要
        }

        $sake_id = $sake->id;
        $user_id = Auth::user()->id;
        $personal = PersonalEvaluation::whereSakeId($sake_id)->first();
        $maker = MakerEvaluation::whereSakeId($sake_id)->first();

        $viewData = [];

        //画像データ取得のために
        $flag = false;

        $tentative_images = [];
        $delete_image_ids = [];
        if (!empty($request->session()->get('preserve'))) {
            $flag = true;
            $tentative_images = $this->pictureService->getTentativeImageData($user_id);
            if (!empty($request->old('delete_image_ids'))) {
                $delete_image_ids = $request->old('delete_image_ids');
            }
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
        // var_dump($images);exit;

        $viewData['image_datas'] = $images;
        $viewData['delete_image_ids'] = $delete_image_ids;
        $viewData['tentative_images'] = $tentative_images;

        return view('maintenance.sake-edit', $viewData);
    }


    function editConfirm($id, Request $request){
        $user_id = Auth::user()->id;
        $validator = Validator::make($request->all(),
        $this->getSakeValidationRules(),$this->customMessages());

        if(!empty($request->file('file'))){
            $validator = $this->pictureService->validateStoreImage($user_id,$request->file('file'),$validator);
        }

        if ($validator->fails()) {
            $request->session()->flash('preserve', true);
            return redirect('/maintenance/sake/create')->withInput()
            ->withErrors($validator);
        }

        $viewData = [];
        $viewData['title'] = '編集確認';

        $user_id = Auth::user()->id;
        $viewData['user_id'] = $user_id;

        $delete_ids = $request->get('delete_image_ids') ? $request->get('delete_image_ids'):[];

        if (!empty($request->get('redirect_delete_image_ids'))) {
            $delete_ids = array_merge($delete_ids,$request->get('redirect_delete_image_ids'));
        }

        $exist_images = $this->pictureService->getS3ImageData($id, $delete_ids, true);

        $viewData['delete_image_ids'] = $delete_ids;
        //このidとmerged_delete_idsとの付き合わせを行う
        if (count($delete_ids) > 0) {
            foreach ($exist_images as $key => $i) {
                if (in_array($i['id'], $delete_ids)) {
                    continue;
                }
                unset($i);
                unset($i);
            }
        }

        $new_images = $this->pictureService->getTentativeImageData($user_id,true);

        $datas = $this->sakeService->getConfirmColumns();

        $i = 0;
        foreach ($datas as $column => $post) {
            if (!isset($post['pulldown'])) {
                $datas[$column]['value'] = $request->get($column);
            }else{
                $pulldown_keys = array_keys($post['pulldown']);
                $datas[$column]['value'] = null;

                if($request->get($column) !== false && (!is_null($request->get($column)))
                && (in_array($request->get($column), $pulldown_keys))){
                    // var_dump($column);exit;
                    // var_dump($request->get($column));exit;

                    $datas[$column]['value'] = $post['pulldown'][$request->get($column)];
                }
            }
        }

        $viewData['datas'] = $datas;

        $viewData['new_images'] = $new_images;
        // var_dump($exist_images);exit;
        $viewData['exist_images'] = $exist_images;
        $viewData['sake_id'] = $id;

        return view('maintenance.sake-edit-confirm', $viewData);
    }

    function update($id,Request $request){
        //戻るボタン押下
        $back = $request->post('back', false);
        if($back !== false){
            // var_dump($request->post());exit;
            $request->session()->flash('preserve', true);
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
        if(empty($sake)){



            //エラー処理
        }
        $sake->name = $request->get('name');
        $sake->name_kana = $request->get('name_kana');
        $sake->name_kana = $request->get('name_kana');
        $sake->kura = $request->get('kura');
        $sake->memo = $request->get('memo');
        //post値をキーに置き換えるような
        $sake->prefecture = array_search($request->post('prefecture'),MasterDefine::PREFECTURES);

        $sake_id = $sake->id;

        $personal = PersonalEvaluation::whereSakeId($sake_id)->first();
        if(!empty($personal_evaluation)){


            //エラー処理
        }

        $personal->sweetness = $request->post('sweetness');
        $personal->acidity = $request->post('acidity');
        $personal->richness = $request->post('richness');
        $personal->cost_performance = $request->post('cost_performance');
        $personal->recommend_point = $request->post('recommend_point');

        $maker = MakerEvaluation::whereSakeId($sake_id)->first();
        $maker->sake_degree = array_search($request->post('sake_degree'),MasterDefine::SAKE_DEGREES);
        $maker->amino_acid_degree = array_search($request->post('amino_acid_degree'),MasterDefine::AMINO_ACID_DEGREES);

        $user_id = Auth::user()->id;

        $delete_ids = [];
        if (!empty($request->get('delete_image_ids'))) {
            $delete_ids = $request->get('delete_image_ids');

            //酒と結びついたPictureかどうか確認。一つでもあったらエラー
            foreach($delete_ids as $d_id){
                $picture = Picture::find($d_id);
                if(empty($picture) || ($picture->sake_id != $id)){
                    //エラー処理
                    var_dump('NOT RELATED error!!');
                }
            }
        }



        //トランザクション開始
        DB::transaction(function () use ($id,$sake,$personal,$maker,$request,$user_id,$delete_ids) {
            $sake->update();

            if(Storage::disk('public')->exists("img/tmp/{$user_id}")){
                $file_paths = Storage::disk('public')->files("img/tmp/{$user_id}");
                foreach($file_paths as $f){
                    $path = Storage::disk('s3')->putFile('sake', 'storage/app/public/' . $f, 'public');

                    $picture = new Picture;
                    $picture->image_path = Storage::disk('s3')->url($path);
                    $picture->sake_id = $id;
                    $picture->save();
                }
            }

            $personal->update();
            $maker->update();

            foreach($delete_ids as $d_id){
                $picture =  Picture::find($d_id);
                // var_dump($picture);exit;

                Storage::disk('s3')->delete('/', $picture->image_path);
                $picture->delete();
            }

            //仮ディスクを削除
            Storage::disk('public')->deleteDirectory("img/tmp/{$user_id}");

        });

        // 二重送信対策
        $request->session()->regenerateToken();

        $viewData = [];
        $viewData['sake_id'] = $sake_id;

        $viewData['title'] = '編集完了';
        // 更新のための処理

        return view('maintenance.sake-edit-complete', $viewData);
    }



    function search(Request $request){
        var_dump($request->post());exit;
    }

    public function tentativeImageDelete(Request $request){

        $user_id = $request->get('user_id');
        $image_source = $request->get('image_source');

        //新たに画像を登録するｓ時

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

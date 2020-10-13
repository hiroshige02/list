<?php

namespace App\Http\Controllers\Maintenance;

use App\Models\Sake;
use App\MasterDefine;
use App\Models\Picture;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Services\SakeService;
use App\Models\MakerEvaluation;

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
     * コンストラクタ
     *
     * @param SakeService $sakeService
     */
    public function __construct(SakeService $sakeService)
    {
        $this->sakeService = $sakeService;
    }


    public function prefectureIndex($prefecture)
    {
        // if(!empty($id)){
        // $sake = Sake::wherePrefectureId($prefecture_id)->get();
        // }
        $prefecture_keys = array_keys(MasterDefine::PREFECTURES);

        if (!in_array($prefecture, $prefecture_keys)) {
            return;
        }

        $prefecture = MasterDefine::PREFECTURES[$prefecture];
        // if($prefecture_id == 1){
        $viewData = [];
        $viewData['title'] = $prefecture . 'のお酒';
        return view('maintenance.sake-index', $viewData);
        // }
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

    public function index()
    {
        $viewData = [];
        $viewData['title'] = '千葉県のお酒';
        return view('maintenance.sake-index', $viewData);
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
        $files=[];

        //画像データ取得のために
        if (!empty($request->session()->get('preserve'))) {
            $files = Storage::disk('public')->files("img/tmp/{$user_id}");

            foreach ($files as &$file) {
                $file = basename($file);
            }
        }

        //確認画面から戻ってき時に画像の仮フォルダを削除
        $viewData['user_id'] = $user_id;
        $viewData['title'] = '新規登録';
        $viewData['sake_info'] = $this->sakeService->getSakeOptions();

        $old_input = null;
        if(!empty($request->old())){
            $old_input = $request->old();
        }

        $flag = false;
        if(!empty($request->session()->get('preserve'))){
            $flag = true;
        }
        $viewData['tasts'] = $this->sakeService->getTasteOptions($old_input);
        $viewData['evaluations'] = $this->sakeService->getMakerEvaluations($old_input,$flag);
        $viewData['prefecture'] = $this->sakeService->getPrefectureOptions($old_input,$flag);
        $viewData['input_images'] = $files;

        return view('maintenance.sake-create', $viewData);
    }

    public function getSakeValidationRules()
    {
        $rules = [
            'name' => ['required','string','max:256'],
            'name_kana' => ['required','string','max:256','regex:/^[ァ-ヶー]+$/'],
            'kura' => ['required','string'],
            'prefecture' => ['required','string'],
            'sweetness' => ['required','string'],
            'acidity' => ['required','string'],
            'richness' => ['required','string'],
            'cost_performance' => ['required','string'],
            'recommend_point' => ['required','string'],

            'sake_degree' => ['string'],
            'amino_acid_degree' => ['string'],

            'memo' => ['string','max:1000']
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

        //バリデーション
        $validator = Validator::make($request->all(),
        $this->getSakeValidationRules(),$this->customMessages());
        if ($validator->fails()) {
            // var_dump($validator->errors());exit;
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


        $files = [];
        $user_id = Auth::user()->id;
        $files = [];
        if(!empty(Storage::disk('public')->exists("img/tmp/{$user_id}"))){
            $storage_files = Storage::disk('public')->files("img/tmp/{$user_id}");
            foreach($storage_files as &$f){
                $f = basename($f);
            }
            $files = $storage_files;
        }

        //postされた画像があれば、仮ディスクに保存
        if(!empty($request->file('file'))){
            foreach ($request->file('file') as $file) {
                $file_name = $file->getClientOriginalName();//BBQ.jpg
                $files[] = $file_name;
                $user_id = Auth::user()->id;
                $path = $file->storeAs("/img/tmp/{$user_id}", $file_name, ['disk' => 'public']);
            }
        }

        $viewData['datas'] = $datas;
        $viewData['files'] = $files;

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
            Storage::disk('public')->deleteDirectory("img/tmp/{{$user_id}}");

        });

        $viewData = [];
        $viewData['title'] = '新規登録完了';
        $viewData['sake_id'] = $sake->id;

        // var_dump($viewData);exit;

        return view('maintenance.sake-create-complete', $viewData);
    }


    function edit($id){
        //該当ID酒の存在チェック

        $viewData = [];
        $viewData['title'] = '編集';
        // $viewData['page_number'] = 1;

        return view('maintenance.sake-edit', $viewData);
    }


    function editConfirm(){
        $viewData = [];
        $viewData['title'] = '編集確認';

        return view('maintenance.sake-edit-confirm', $viewData);
    }

    function editComplete(){
        $viewData = [];
        $viewData['title'] = '編集完了';
        // 更新のための処理

        return view('maintenance.sake-edit-complete', $viewData);
    }



    function search(Request $request){
        var_dump($request->post());exit;
    }

    public function tentativeImageDelete(Request $request){
        Log::debug('@@@@@@@@ post tentativeDelete @@@@@@@@');
        Log::debug(print_r($request->post(),true));
        $user_id = $request->get('user_id');
        $image_source = $request->get('image_source');
        // [image_address] => /storage/app/public/img/tmp/1/moviefilm.jpg
        // $request->get('image_address')

        $image_name = basename($image_source);
        Storage::disk('public')->delete("img/tmp/{$user_id}/{$image_name}");
        // Storage::delete($request->get('image_name'));
        // Storage::disk('public')->deleteDirectory("img/tmp/{$user_id}");
    }


}

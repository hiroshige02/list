<?php

namespace App\Http\Controllers\Viewer;
use App\Models\Sake;
use App\MasterDefine;
use Illuminate\Http\Request;
use App\Services\SakeService;
use App\Services\PictureService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
     * 酒の詳細表示画面に遷移
     *
     * @param int $sake_id
     * @param \Illuminate\Http\Request
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
        foreach($datas as $column => &$data){
            if(!empty($data['pulldown']) && !empty($joined_data->{$column})){
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

        return view('viewer.sake', $viewData);
    }

    /**
     * 詳細画面から「戻る」際に必要なセッションをセット
     *
     * @param int $sake_id
     * @param int $page
     * @return void
     *
     */
    public function pageSet($sake_id, $page, Request $request){
        Log::debug($sake_id);
        Log::debug($page);
        // var_dump($sake_id);
        // var_dump($page);exit;

        $request->session()->put('page_number', $page);
        return redirect("/sake/{$sake_id}");

    }


    /**
     * 検索結果表示
     * @param \Illuminate\Http\Request
     * @return void
     */
    public function search(Request $request)
    {

        $viewData = [];
        $viewData['maintenance'] = $request->post('maintenance', false);
        $viewData['return_page'] = 1;

        //show画面から戻ってきた時は、元のページインデックスに戻る
        if($request->session()->get('page_number')){
            $viewData['return_page'] = $request->session()->get('page_number');
            $request->session()->forget('page_number');
        }

        $id_array = $request->post('searched');
        $sakes = Sake::getSakeDatasFromIds($id_array)->get();
        $datas = $this->sakeService->getIndexData($sakes);

        //ページネーション準備
        $per_page = 2;
        $viewData['per_page'] = $per_page;
        $total_pages = count($sakes) % $per_page ?
        ceil(count($sakes)/$per_page) : count($sakes)/$per_page;
        $viewData['total_pages'] = $total_pages;

        // Log::debug('piennnn');
        // Log::debug(count($sakes));
        // Log::debug($total_pages);

        // Log::debug(count($sakes)/$per_page);
        // Log::debug(ceil(count($sakes)/$per_page));


        $viewData['title'] = "検索結果";
        $viewData['datas'] = $datas;

        // var_dump($viewData);exit;

        return view('viewer.searched', $viewData);
    }

        /**
     * 指定された条件でアイテムの検索して返す
     *
     * @param \Illuminate\Http\Request
     * @return json
     */
    function sakeSearch(Request $request){
        $search_text = $request->get('search_text');
        $search_type = $request->get('search_type');

        if(empty($search_text) || empty($search_type)){
            return;
        }

        $sakes_data = [];

        switch ($search_type){
            case 1:
                $sakes_data = $this->sakeService->getSakeFromName($search_text);
                break;
            case 2:
                $search_class = $request->get('class');
                if(empty($search_class)){
                    return;
                }

                $sakes_data = $this->sakeService->getSakeFromMakerEv($search_class, $search_text);
                break;
            case 3:
                Log::debug('$personal_ev $personal_ev');

                $judge = array_filter($search_text);

                if(empty($judge)) {
                    break;
                }

                $sakes_data = $this->sakeService->getSakeFromPerosonalEv($search_text);
                break;
            default:
                break;
        }

        return response()->json($sakes_data);
    }

    /**
     * コンストラクタ
     *
     * @param int $prefecture
     * @return void
     *
     */
    public function prefectureIndex($prefecture, Request $request)
    {

        $viewData = [];
        $viewData['return_page'] = 1;
        $viewData['maintenance'] = !empty(Auth::user());

        //show画面から戻ってきた時は、元のページインデックスに戻る
        if($request->session()->get('page_number')){
            $viewData['return_page'] = $request->session()->get('page_number');
            $request->session()->forget('page_number');
        }

        $prefecture_keys = array_keys(MasterDefine::PREFECTURES);
        if (!in_array($prefecture, $prefecture_keys)) {
            //エラー処理
            abort(500);
        }

        //「戻る」で戻ってこれるようにセット
        $request->session()->put('prefecture', $prefecture);

        $sakes = Sake::wherePrefecture($prefecture)->get();

        $datas = $this->sakeService->getIndexData($sakes);

        $viewData['datas'] = $datas;

        //ページネーション準備
        $per_page = 2;
        $viewData['per_page'] = $per_page;
        $total_pages = count($sakes) % $per_page ?
        ceil(count($sakes)/$per_page) : count($sakes)/$per_page;
        $viewData['total_pages'] = $total_pages;

        $prefecture_name = MasterDefine::PREFECTURES[$prefecture];
        $viewData['title'] = $prefecture_name . 'のお酒';

        return view('viewer.sake-index', $viewData);
    }


}

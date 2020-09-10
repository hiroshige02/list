<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\MasterDefine;

class SakeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    
    public function prefectureIndex($prefecture){
        // if(!empty($id)){
            // $sake = Sake::wherePrefectureId($prefecture_id)->get();
        // }
        $prefecture_keys = array_keys(MasterDefine::PREFECTURES);

        if(!in_array($prefecture,$prefecture_keys)){
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
    function searched(){
        $viewData = [];
        $viewData['title'] = "'さわ音'検索結果";

        return view('maintenance.searched', $viewData);
    }

    function index(){
        $viewData = [];
        $viewData['title'] = '千葉県のお酒';
        return view('maintenance.sake-index', $viewData);
    }

    function show($id){
        //該当ID酒の存在チェック
                
        $viewData = [];
        $viewData['title'] = 'さわ音';
        $viewData['set_per_page'] = 2;

        return view('maintenance.sake', $viewData);
    }

    function create(){
        //該当ID酒の存在チェック
                
        $viewData = [];
        $viewData['title'] = '新規登録';
        // $viewData['page_number'] = 1;

        return view('maintenance.sake-create', $viewData);
    }

    function createConfirm(){
        //該当ID酒の存在チェック
        

        $viewData = [];
        $viewData['title'] = '新規登録確認';
        // $viewData['page_number'] = 1;

        return view('maintenance.sake-create-confirm', $viewData);
    }


    function createComplete(){
        $viewData = [];
        $viewData['title'] = '新規登録完了';
        // $viewData['page_number'] = 1;

        return view('maintenance.sake-create-complete', $viewData);
    }


    function edit(){
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
}
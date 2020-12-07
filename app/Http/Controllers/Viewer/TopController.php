<?php

namespace App\Http\Controllers\Viewer;

use App\Models\Sake;
use App\MasterDefine;
use Illuminate\Http\Request;
use App\Services\SakeService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class TopController extends Controller
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


    /**
     * トップ画面
     *
     * @return void
     */
    public function welcome()
    {
        $viewData = [];
        $viewData['title'] = '日本酒紀行';
        $viewData['searched'] = true;
        $viewData['areas'] = MasterDefine::AREAS;
        $viewData['maintenance'] = !empty(Auth::user());

        // var_dump($viewData['maintenance']);exit;

        $selections_1 = [];
        $selections_2 = [];
        foreach (MasterDefine::SAKE_DEGREES as $key => $value) {
            $selections_1[] = ['text' => $value,'value' => $key];
        }
        foreach (MasterDefine::AMINO_ACID_DEGREES as $key => $value) {
            $selections_2[] = ['text' => $value,'value' => $key];
        }

        $viewData['maker_selections'] = [
            'name_1' => 'maker_class',
            'name_2' => 'selections',
            'label_1' => '評価内容種類',
            'label_2' => '選択肢',
            'classes' => [
                ['text' => MasterDefine::SAKE_DEGREE, 'value' => 'sake_degree'],
                ['text' => MasterDefine::AMINO_ACID_DEGREE, 'value' => 'amino_acid_degree']
            ],
            'selections' => [
                'sake_degree' => $selections_1,
                'amino_acid_degree' => $selections_2,
            ]
        ];

        $viewData['personal_selections'] = $this->sakeService->getTasteOptions(null, null, true);

        return view('viewer.top', $viewData);
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
        $request->session()->put('page_number', $page);
        return redirect("/sake/{$sake_id}");

    }

}

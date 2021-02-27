<?php

namespace App\Http\Controllers\Maintenance;

use App\MasterDefine;
use Illuminate\Http\Request;
use App\Services\SakeService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class MaintenanceController extends Controller
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
     * 管理画面
     *
     * @return void
     */
    public function index()
    {
        $viewData = [];
        $viewData['title'] = '管理画面';
        $viewData['searched'] = true;
        $viewData['areas'] = MasterDefine::AREAS;

        $selections_1 = [];
        $selections_2 = [];
        foreach(MasterDefine::SAKE_DEGREES as $key => $value){
            $selections_1[] = ['text' => $value,'value' => $key];
        }
        foreach(MasterDefine::AMINO_ACID_DEGREES as $key => $value){
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

        return view('maintenance.index', $viewData);
    }
}

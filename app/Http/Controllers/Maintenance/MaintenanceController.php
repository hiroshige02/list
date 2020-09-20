<?php

namespace App\Http\Controllers\Maintenance;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\MasterDefine;

class MaintenanceController extends Controller
{

    // auth:adminでログインしている必要がある
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 管理画面
     *
     * @return array|null $point
     *
     */
    public function tastePoint($type){
        $point = null;

        switch ($type) {
            case 'A':
                for ($i=-5;$i<6;$i++) {
                    $point[] = $i;
                }
                break;
            case 'B':
                for ($i=-5;$i<1;$i++) {
                    $point[] = $i;
                }
                break;
            default:
            break;
        }
        return $point;
    }


    /**
     * 管理画面
     *
     * @return array
     */
    public function getTasteColumnOptions(){
        return [
            'sweetness' => [
                'label' => '甘さ', //対は辛さ
                'selections' => $this->tastePoint('A')
            ],
            'sour_taste' => [
                'label' => '酸味',
                'selections' => $this->tastePoint('B')
            ],

            'richness' => [
                'label' => '濃醇', //対は淡麗
                'selections' => $this->tastePoint('A')
            ],
            'cost_performance' => [
                'label' => 'コストパフォーマンス',
                'selections' => $this->tastePoint('B')
            ],

            'recommend_point' => [
                'label' => 'おすすめ度',
                'selections' => $this->tastePoint('B')
            ]
        ];
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
        $viewData['maker_selections'] = [
            'name_1' => 'maker_class',
            'name_2' => 'selections',
            'label_1' => '評価内容種類',
            'label_2' => '選択肢',
            'classes' => [
                MasterDefine::SAKE_DEGREE,
                MasterDefine::AMINO_ACID_DEGREE
            ],
            'selections' => [
                MasterDefine::SAKE_DEGREE => MasterDefine::SAKE_DEGREES,
                MasterDefine::AMINO_ACID_DEGREE => MasterDefine::AMINO_ACID_DEGREES,

            ]
        ];

        $viewData['personal_selections'] = $this->getTasteColumnOptions();

        return view('maintenance.index', $viewData);
    }
}

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
     * @return void
     */

    function index(){
        $viewData = [];
        $viewData['title'] = '管理画面';
        $viewData['searched'] = true;
        $viewData['areas'] = MasterDefine::AREAS;
        $viewData['maker_selections'] = [
            '評価内容種類' => ['日本酒度','アミノ酸度'],
            '動的に変わる選択肢' => ['1〜5','5〜10']
        ];

        $viewData['personal_selections'] = [
            [
                'class_name' => '項目１',
                'classes' => [
                    '1〜5',
                    '5〜10',
                    '10〜15'
                ],
                'selection_name' => '項目１選択肢',
                'selections' => [
                    '選択肢１',
                    '選択肢２',
                    '選択肢３',
                ]

            ],
            [
                'class_name' => '項目２',
                'classes' => [
                    '1〜5',
                    '5〜10',
                    '10〜15'
                ],
                'selection_name' => '項目２選択肢',
                'selections' => [
                    '選択肢１',
                    '選択肢２',
                    '選択肢３',
                ]

            ],
            [
                'class_name' => '項目３',
                'classes' => [
                    '1〜5',
                    '5〜10',
                    '10〜15'
                ],
                'selection_name' => '項目３選択肢',
                'selections' => [
                    '選択肢１',
                    '選択肢２',
                    '選択肢３',
                ]

            ],
            [
                'class_name' => '項目４',
                'classes' => [
                    '1〜5',
                    '5〜10',
                    '10〜15'
                ],
                'selection_name' => '項目４選択肢',
                'selections' => [
                    '選択肢１',
                    '選択肢２',
                    '選択肢３',
                ]

            ],
            [
                'class_name' => '項目５',
                'classes' => [
                    '1〜5',
                    '5〜10',
                    '10〜15'
                ],
                'selection_name' => '項目５選択肢',
                'selections' => [
                    '選択肢１',
                    '選択肢２',
                    '選択肢３',
                ]

            ],

        ];

        // var_dump($viewData['areas']);exit;
        return view('maintenance.index', $viewData);
    }
}
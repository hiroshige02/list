<?php

namespace App\Http\Controllers\Home;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\MasterDefine;

class TopController extends Controller
{

    /**
     * トップ画面
     *
     * @return void
     */

    public function welcome(){
        $viewData['title'] = '徒然日本酒紀行（仮）';
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


        return view('home.top', $viewData);
    }

}

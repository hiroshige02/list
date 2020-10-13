<?php

namespace App\Services;

use App\MasterDefine;
use Illuminate\Http\Request;

class SakeService
{

    //selectons
    public function tastePoint($type){
        $selections= [];

        switch ($type) {
            case 'A':
                for ($i=-5;$i<6;$i++) {
                    $selections[] = [
                        'text' => $i,
                        'value' => $i
                    ];
                }
                break;
            case 'B':
                for ($i=0;$i<6;$i++) {
                    $selections[] = [
                        'text' => $i,
                        'value' => $i
                    ];
                }
                break;
            default:
            break;
        }
        return $selections;
    }


    /**
     *  このメソッド変更する
     *
     */
    public function getTasteOptions($old_input){
        if(!is_null($old_input)){
            // var_dump($old_input['sweetness']);exit;
            return [
                'sweetness' => [
                    'label' => '甘さ', //対は辛さ
                    'selections' => $this->tastePoint('A'),
                    'input_old' => [
                        'text' => $old_input['sweetness'],
                        'value' => (int)$old_input['sweetness']
                    ]
                ],
                'acidity' => [
                    'label' => '酸味',
                    'selections' => $this->tastePoint('B'),
                    'input_old' => [
                        'text' => $old_input['acidity'],
                        'value' => (int)$old_input['acidity']
                    ]
                ],

                'richness' => [
                    'label' => '濃醇', //対は淡麗
                    'selections' => $this->tastePoint('A'),
                    'input_old' => [
                        'text' => $old_input['richness'],
                        'value' => (int)$old_input['richness'],
                    ],
                ],
                'cost_performance' => [
                    'label' => 'コストパフォーマンス',
                    'selections' => $this->tastePoint('B'),
                    'input_old' => [
                        'text' => $old_input['cost_performance'],
                        'value' => (int)$old_input['cost_performance']
                    ],

                ],
                'recommend_point' => [
                    'label' => 'おすすめ度',
                    'selections' => $this->tastePoint('B'),
                    'input_old' => [
                        'text' => $old_input['recommend_point'],
                        'value' => (int)$old_input['recommend_point']
                    ],

                ]
            ];
        }else{
            return [
                'sweetness' => [
                    'label' => '甘さ', //対は辛さ
                    'selections' => $this->tastePoint('A'),
                ],
                'acidity' => [
                    'label' => '酸味',
                    'selections' => $this->tastePoint('B'),
                ],

                'richness' => [
                    'label' => '濃醇', //対は淡麗
                    'selections' => $this->tastePoint('A'),
                ],
                'cost_performance' => [
                    'label' => 'コストパフォーマンス',
                    'selections' => $this->tastePoint('B'),
                ],
                'recommend_point' => [
                    'label' => 'おすすめ度',
                    'selections' => $this->tastePoint('B'),
                ]
            ];

        }
    }

    public function getSakeOptions(){
        return [
            'name' => '酒名',
            'name_kana' => '酒名(全角カタカナ)',
            'kura' => '蔵名',
        ];
    }

    public function getPrefectureOptions($old_input,$flag){
        $prefecture_selections = [];
        foreach(MasterDefine::PREFECTURES as $key => $prefecture){
            $prefecture_selections[] = [
                'value' => $key,
                'text' => $prefecture,
            ];
        }

        $prefecture =  [
            'name' => 'prefecture',
            'label' => '県',
            'selections' => $prefecture_selections,
        ];

        if (!empty($old_input['prefecture'])) {
            // var_dump(empty($request->session()->flash('preserve')));exit;

            //リダイレクトの時
            if (empty($flag)) {
                $prefecture['input_old'] = [
                    'text' => MasterDefine::PREFECTURES[$old_input['prefecture']],
                    'value' => (int)$old_input['prefecture']
                ];

            //戻るの時
            } else {
                $prefecture['input_old'] = [
                    'text' => $old_input['prefecture'],
                    'value' => array_search($old_input['prefecture'], MasterDefine::PREFECTURES)
                ];

            }
        }

        return $prefecture;
    }


    public function getMakerEvaluations($old_input,$flag){
        $sake_degree_selections = [];
        foreach(MasterDefine::SAKE_DEGREES as $key => $degree){
            $sake_degree_selections[] = [
                'value' => $key,
                'text' => $degree
            ];
        }
        $sake_degree = [
            'name' => 'sake_degree',
            'label' => MasterDefine::SAKE_DEGREE,
            'selections' => $sake_degree_selections,
        ];
        if (!empty($old_input['sake_degree'])) {
            //リダイレクトの時
            if (empty($flag)) {
                $sake_degree['input_old'] = [
                    'text' => MasterDefine::SAKE_DEGREES[$old_input['sake_degree']],
                    'value' => (int)$old_input['sake_degree']
                ];
            //戻るボタンの時
            }else{
                $sake_degree['input_old'] = [
                    'text' => $old_input['sake_degree'],
                    'value' => array_search($old_input['sake_degree'], MasterDefine::SAKE_DEGREES),
                ];
            }
        }

        $acid_degree_selections = [];
        foreach(MasterDefine::AMINO_ACID_DEGREES as $key => $degree){
            $acid_degree_selections[] = [
                'value' => $key,
                'text' => $degree
            ];
        }
        $amino_acid_degree = [
            'name' => 'amino_acid_degree',
            'label' => MasterDefine::AMINO_ACID_DEGREE,
            'selections' => $acid_degree_selections,
        ];
        if (!empty($old_input['amino_acid_degree'])) {
            //リダイレクトの時
            if (empty($flag)) {
                $amino_acid_degree['input_old'] = [
                    'text' => MasterDefine::AMINO_ACID_DEGREES[$old_input['amino_acid_degree']],
                    'value' => (int)$old_input['amino_acid_degree']
                ];
            } else {
                $amino_acid_degree['input_old'] = [
                    'text' => $old_input['amino_acid_degree'],
                    'value' => array_search($old_input['amino_acid_degree'], MasterDefine::AMINO_ACID_DEGREES)
                ];
            }
        }

        // var_dump($old_input['amino_acid_degree']);
        return [$sake_degree, $amino_acid_degree];

    }

    public function getConfirmColumns($input=[]){
        return [
            'name' => [
                'label' => '酒名'
            ],
            'name_kana' => [
                'label' => '酒名(全角カタカナ)'
            ],
            'kura' => [
                'label' => '蔵名'
            ],
            'prefecture' => [
                'label' => '県',
                'pulldown' => MasterDefine::PREFECTURES
            ],
            'sweetness' => [
                'label' => '甘さ',
            ],
            'acidity' => [
                'label' => '酸味'
            ],
            'richness' => [
                'label' => '濃醇'
            ],
            'cost_performance' => [
                'label' => 'コストパフォーマンス'
            ],
            'recommend_point' => [
                'label' => 'おすすめ度'
            ],
            'sake_degree' => [
                'label' => MasterDefine::SAKE_DEGREE,
                'pulldown' => MasterDefine::SAKE_DEGREES
            ],
            'amino_acid_degree' => [
                'label' => MasterDefine::AMINO_ACID_DEGREE,
                'pulldown' => MasterDefine::AMINO_ACID_DEGREES
            ],
            'memo' => [
                'label' => 'コメント'
            ]
        ];
    }

}

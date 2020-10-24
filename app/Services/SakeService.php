<?php

namespace App\Services;

use App\MasterDefine;
use Illuminate\Http\File;
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
     *  個人評価入力のためのデータを取得
     *
     * @param array|null $old_input
     * @param App\Models\PersonalEvaluation|null $personal
     */
    public function getTasteOptions($old_input=null,$personal=null){
        $tasts =  [
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

        //「戻る」やエラーリダイレクト時
        if (!empty($old_input)) {
            foreach(array_keys($tasts) as $column){
                $tasts[$column]['value'] = [
                    'text' => $old_input[$column],
                    'value' => (int)$old_input[$column]
                ];
            }
        }

        //編集時
        elseif(!empty($personal)){
            foreach(array_keys($tasts) as $column){
                $tasts[$column]['value'] = [
                    'text' => $personal->{$column},
                    'value' => (int)$personal->{$column}
                ];
            }
        }

        return $tasts;
    }

    /**
     *
     * 入力画面で必要なデータを取得
     *
     * @param App\Models\Sake|null $sake
     * @return array $info
     */
    public function getSakeOptions($sake=null){
        $info =  [
            'name' => [
                'label' => '酒名',
            ],
            'name_kana' => [
                'label' => '酒名(全角カタカナ)',
            ],
            'kura' => [
                'label' => '蔵名',
            ],
        ];

        //編集時
        if(!empty($sake)){
            foreach(array_keys($info) as $column){
                // var_dump($sake->name);exit;
                $info[$column]['value'] = $sake->{$column};

            }
        }

        return $info;
    }

    /**
     *
     * 入力画面で必要なデータを取得
     *
     * @param string|null $old_prefecture
     * @param boolean $flag
     * @param string|null $value
     * @param string|null $edit
     * @return array $prefecture
     */
    public function getPrefectureOptions($old_prefecture,$flag,$value=null,$edit=null){
        $prefecture_selections = [];
        foreach (MasterDefine::PREFECTURES as $key => $prefecture) {
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

        $p_value = null;

        if(!empty($old_prefecture)) {
            $p_value = $old_prefecture;
        } elseif(!empty($value)){
            $p_value = $value;
        }

        if (!empty($p_value) && empty($flag) && (empty($edit))
        || (!empty($p_value) && empty($flag) && !empty($edit) )) {
            // var_dump($p_value);exit;
            $prefecture['value'] = [
                'text' => MasterDefine::PREFECTURES[$p_value],
                'value' => (int)$p_value
            ];

        //戻るの時
        } elseif (!empty($p_value) && (empty($edit))
        || (!empty($p_value) && !empty($flag) && !empty($edit))) {
            $prefecture['value'] = [
                'text' => $p_value,
                'value' => array_search($p_value, MasterDefine::PREFECTURES)
            ];
        }

        return $prefecture;
    }

    /**
     *
     *
     */
    public function getMakerEvaluations($old_input,$flag,$maker=null,$edit=null){
        $sake_degree_selections = [];
        foreach(MasterDefine::SAKE_DEGREES as $key => $degree){
            $sake_degree_selections[] = [
                'value' => $key,
                'text' => $degree
            ];
        }
        $sake_degree = [
            'label' => MasterDefine::SAKE_DEGREE,
            'selections' => $sake_degree_selections,
        ];

        $acid_degree_selections = [];
        foreach(MasterDefine::AMINO_ACID_DEGREES as $key => $degree){
            $acid_degree_selections[] = [
                'value' => $key,
                'text' => $degree
            ];
        }
        $amino_acid_degree = [
            'label' => MasterDefine::AMINO_ACID_DEGREE,
            'selections' => $acid_degree_selections,
        ];


        $maker_evaluations = [
            'sake_degree' => $sake_degree,
            'amino_acid_degree' => $amino_acid_degree
        ];

        if (empty($flag) && (empty($edit))
        || (empty($flag) && !empty($edit))) {
                foreach (array_keys($maker_evaluations) as $column) {
                    if ($column == 'sake_degree') {
                        $master_array = MasterDefine::SAKE_DEGREES;
                    } elseif ($column == 'sake_degree') {
                        $master_array = MasterDefine::AMINO_ACID_DEGREES;
                    }

                    //これでうまくいったら$makerと$old_inputの処理をまとめられる
                    $value = null;

                    //0の時の扱いに困る
                    if (!empty($maker)) {
                        $value = (int)$maker[$column];
                        $maker_evaluations[$column]['value'] = [
                            'text' => $master_array[$value],
                            'value' => (int)$value
                        ];

                    }
                }
            } elseif(!empty($flag) && (empty($edit))
            || (!empty($flag) && (!empty($edit)))){

                foreach (array_keys($maker_evaluations) as $column) {
                    //メソッド化するしかないのか？？？
                    if ($column == 'sake_degree') {
                        $master_array = MasterDefine::SAKE_DEGREES;
                    } elseif ($column == 'amino_acid_degree') {
                        $master_array = MasterDefine::AMINO_ACID_DEGREES;
                    }

                    $value = null;
                    if(!empty($old_input)){
                        $value = $old_input[$column];
                    }elseif(!empty($maker)){
                        $value = $maker[$column];
                    }

                    if (!empty($value)) {
                        $maker_evaluations[$column]['value'] = [
                            'text' => $value,
                            'value' => array_search($value, $master_array)
                        ];
                    }

                }
            }
            return $maker_evaluations;

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

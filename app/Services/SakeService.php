<?php

namespace App\Services;

use App\Models\Sake;
use App\MasterDefine;
use App\Models\Picture;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SakeService
{

    /**
     *
     * 個人評価プルダウン の選択肢を返す
     *
     * @param string $type
     * @param bool $search_flag
     * @return array $selections
     */
    public function tastePoint($type, $search_flag=false){
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

        if ($search_flag) {
            array_unshift($selections, '');
        }

        Log::debug('$selections $selections');
        Log::debug($selections);
        return $selections;
    }


    /**
     *  個人評価入力のためのデータを取得
     *
     * @param array|null $old_input
     * @param App\Models\PersonalEvaluation|null $personal
     */
    public function getTasteOptions($old_input=null,$personal=null,$search_flag=false){
        $tasts =  [
            'sweetness' => [
                'label' => '甘さ', //対は辛さ
                'selections' => $this->tastePoint('A', $search_flag),
            ],
            'acidity' => [
                'label' => '酸味',
                'selections' => $this->tastePoint('B', $search_flag),
            ],

            'richness' => [
                'label' => '濃醇', //対は淡麗
                'selections' => $this->tastePoint('A', $search_flag),
            ],
            'cost_performance' => [
                'label' => 'コストパフォーマンス',
                'selections' => $this->tastePoint('B', $search_flag),
            ],
            'recommend_point' => [
                'label' => 'おすすめ度',
                'selections' => $this->tastePoint('B', $search_flag),
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
    public function getPrefectureOptions($old_prefecture,$flag=false,$value=null,$edit=null){

        $prefecture_selections = [];
        foreach (MasterDefine::PREFECTURES as $key => $prefecture) {
            $prefecture_selections[] = [
                'value' => $key,
                'text' => $prefecture,
            ];
        }

        $prefecture =  [
            'name' => 'prefecture',
            'label' => __('master.Prefecture'),
            'selections' => $prefecture_selections,
        ];

        $p_value = null;

        if(isset($old_prefecture)) {
            if (in_array((int)$old_prefecture, array_keys(MasterDefine::PREFECTURES),true)) {
                $p_value = $old_prefecture;
            }

        } elseif(isset($value)){
            if (in_array((int)$value, array_keys(MasterDefine::PREFECTURES), true)) {
                $p_value = $value;
            }
        }

        if (!is_null($p_value) && !$flag) {
                // var_dump($p_value);exit;
            $prefecture['value'] = [
                'text' => MasterDefine::PREFECTURES[$p_value],
                'value' => (int)$p_value
            ];

        //戻るの時
        } elseif (!is_null($p_value) && (empty($edit) || (!is_null($p_value) && !empty($edit)))
        || (!empty($p_value) && empty($flag) && !empty($edit))) {
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

        if (empty($flag)) {
            foreach (array_keys($maker_evaluations) as $column) {
                if ($column == 'sake_degree') {
                    $master_array = MasterDefine::SAKE_DEGREES;
                } elseif ($column == 'sake_degree') {
                    $master_array = MasterDefine::AMINO_ACID_DEGREES;
                }

                //これでうまくいったら$makerと$old_inputの処理をまとめられる
                $value = null;

                //0の時の扱いに困る
                if(isset($old_input)){
                    $value = $old_input[$column];
                }elseif(isset($maker[$column])){
                    $value = $maker[$column];
                }

                if (!is_null($value)) {
                    $maker_evaluations[$column]['value'] = [
                        'text' => $master_array[$value],
                        'value' => (int)$value
                    ];

                }
            }
        } else {
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
        $datas =  [
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

        if(!empty($input)){
            foreach ($datas as $column => $post) {

                $post_value = $input[$column];
                if (!isset($post['pulldown'])) {
                    $datas[$column]['value'] = $post_value;
                }else{
                    $pulldown_keys = array_keys($post['pulldown']);
                    $datas[$column]['value'] = null;

                    // if($input[$column] !== false && (!is_null($input[$column]))
                    if($post_value == 0 || (!empty($post_value))
                    && (in_array($post_value, $pulldown_keys))){
                        $datas[$column]['value'] = $post['pulldown'][$post_value];
                    }
                }
            }
        }

        return $datas;

    }

    public function getRaderDatas($sake){
        //甘さ、酸味、味の濃さ、コストパフォーマンス、淡麗さ、おすすめ度、辛さ　の順番
        $tanrei = null;
        if($sake->richness < 0){
            $tanrei = abs($sake->richness);
            $sake->richness = 0;
        }

        $karasa = null;
        if($sake->sweetness < 0){
            $karasa = abs($sake->sweetness);
            $sake->sweetness = 0;
        }

        $personal_data = [
            $sake->sweetness,
            $sake->acidity,
            $sake->richness,
            $sake->cost_performance,
            $tanrei, //淡麗さ
            $sake->recommend_point,
            $karasa,
        ];

        return $personal_data;
    }

    /**
     * 名前からアイテムを取得する
     *
     * @param string $name
     * @return
     */
    public function getSakeFromName($name){
        $sakes = Sake::getSakeFromName($name)->toArray();
        $sakes_data = array_column($sakes,'name','id');

        return $sakes_data;
    }

    /**
     * メーカーの評価からアイテムを取得する
     *
     * @param string $maker_evaluation
     * @return
     */
    public function getSakeFromMakerEv($class,$evaluation){
        $sakes = Sake::getSakeFromMakerEv($class,$evaluation)->toArray();
        $sakes_data = array_column($sakes,'name','id');

        return $sakes_data;
    }

    /**
     * 個人の評価からアイテムを取得する
     *
     * @param array $personal_ev
     * @return array $sakes_data
     */
    public function getSakeFromPerosonalEv($personal_ev) {
        $sakes = Sake::getSakeFromPersonalEv($personal_ev);

        $sakes_data = $sakes->pluck('name','id');

        return $sakes_data;

    }

    /**
     * 一覧画面用のデータを作る
     *
     * @param  $sakes
     * @return array $datas
     */
    public function getIndexData($sakes) {
        $datas = [];

        foreach($sakes as $sake){
            $pictures = Picture::whereSakeId($sake->id)->first();

            //現状画像一枚しか表示しないようになっている
            $image_path = null;
            if (!empty($pictures)) {
                $image_path = $pictures->image_path;
            }

            $datas[] = [
                'sake_id' => $sake->id,
                'name' => $sake->name,
                'kura' => $sake->kura,
                'prefecture' => $sake->prefecture,
                'image_path' => $image_path
            ];
        }
        return $datas;
    }

}

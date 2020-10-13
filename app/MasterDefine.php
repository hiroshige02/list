<?php

namespace App;

class MasterDefine {

    //日本の各エリア
    const HOKKAIDO_AREA = 0;
    const TOHOKU_AREA = 1;
    const KANTO_AREA = 2;
    const CHUBU_AREA = 3;
    const KINKI_AREA = 4;
    const CHUGOKU_AREA = 5;
    const SHIKOKU_AREA = 6;
    const KYUSHU_AREA = 7;


    //都道府県　絶対必要
    const HOKKAIDO = 0;

    const AOMORI = 1;
    const IWATE = 2;
    const AKITA = 3;
    const MIYAGI = 4;
    const YAMAGATA = 5;
    const FUKUSHIMA = 6;

    const IBARAKI = 7;
    const TOCHIGI = 8;
    const GUNMA = 9;
    const SAITAMA = 10;
    const CHIBA = 11;
    const TOKYO = 12;
    const KANAGAWA = 13;

    const NIIGATA = 14;
    const TOYAMA = 15;
    const ISHIKAWA = 16;
    const FUKUI = 17;
    const YAMANASHI = 18;
    const NAGANO = 19;
    const GIFU = 20;
    const SHIZUOKA = 21;
    const AICHI = 22;

    const MIE = 23;
    const SHIGA = 24;
    const KYOTO = 25;
    const OSAKA = 26;
    const HYOUGO = 27;
    const NARA = 28;
    const WAKAYAMA = 29;

    const TOTTORI = 30;
    const SHIMANE = 31;
    const OKAYAMA = 32;
    const HIROSHIMA = 33;
    const YAMAGUCHI = 34;

    const TOKUSHIMA = 35;
    const KAGAWA = 36;
    const EHIME = 37;
    const KOUCHI = 38;

    const FUKUOKA = 39;
    const SAGA = 40;
    const NAGASAKI = 41;
    const KUMAMOTO = 42;
    const OITA = 43;
    const MIYAZAKI = 44;
    const KAGOSHIMA = 45;
    const OKINAWA = 46;



    //都道府県　絶対必要
    const PREFECTURES = [
        MasterDefine::HOKKAIDO => '北海道',

        MasterDefine::AOMORI => '青森',
        MasterDefine::IWATE => '岩手',
        MasterDefine::AKITA => '秋田',
        MasterDefine::MIYAGI => '宮城',
        MasterDefine::YAMAGATA => '山形',
        MasterDefine::FUKUSHIMA => '福島',

        MasterDefine::IBARAKI => '茨城',
        MasterDefine::TOCHIGI => '栃木',
        MasterDefine::GUNMA => '群馬',
        MasterDefine::SAITAMA => '埼玉',
        MasterDefine::CHIBA => '千葉',
        MasterDefine::TOKYO => '東京',
        MasterDefine::KANAGAWA => '神奈川',

        MasterDefine::NIIGATA => '新潟',
        MasterDefine::TOYAMA => '富山',
        MasterDefine::ISHIKAWA => '石川',
        MasterDefine::FUKUI => '福井',
        MasterDefine::YAMANASHI => '山梨',
        MasterDefine::NAGANO => '長野',
        MasterDefine::GIFU => '岐阜',
        MasterDefine::SHIZUOKA => '静岡',
        MasterDefine::AICHI => '愛知',

        MasterDefine::MIE => '三重',
        MasterDefine::SHIGA => '滋賀',
        MasterDefine::KYOTO => '京都',
        MasterDefine::OSAKA => '大阪',
        MasterDefine::HYOUGO => '兵庫',
        MasterDefine::NARA => '奈良',
        MasterDefine::WAKAYAMA => '和歌山',

        MasterDefine::TOTTORI => '鳥取',
        MasterDefine::SHIMANE => '島根',
        MasterDefine::OKAYAMA => '岡山',
        MasterDefine::HIROSHIMA => '広島',
        MasterDefine::YAMAGUCHI => '山口',

        MasterDefine::TOKUSHIMA => '徳島',
        MasterDefine::KAGAWA => '香川',
        MasterDefine::EHIME => '愛媛',
        MasterDefine::KOUCHI => '高知',

        MasterDefine::FUKUOKA => '福岡',
        MasterDefine::SAGA => '佐賀',
        MasterDefine::NAGASAKI => '長崎',
        MasterDefine::KUMAMOTO => '熊本',
        MasterDefine::OITA => '大分',
        MasterDefine::MIYAZAKI => '宮崎',
        MasterDefine::KAGOSHIMA => '鹿児島',
        MasterDefine::OKINAWA => '沖縄',
    ];

    const AREAS = [
        MasterDefine::HOKKAIDO_AREA => [
            'name' => 'hokkaido',
            'display_name' => '北海道',
            'prefectures' => [
                MasterDefine::HOKKAIDO => '北海道'
            ],
        ],
        MasterDefine::TOHOKU_AREA => [
            'name' => 'tohoku',
            'display_name' => '東北',
            'prefectures' => [
                MasterDefine::AOMORI => MasterDefine::PREFECTURES[MasterDefine::AOMORI],
                MasterDefine::IWATE => MasterDefine::PREFECTURES[MasterDefine::IWATE],
                MasterDefine::AKITA => MasterDefine::PREFECTURES[MasterDefine::AKITA],
                MasterDefine::MIYAGI => MasterDefine::PREFECTURES[MasterDefine::YAMAGATA],
                MasterDefine::YAMAGATA => MasterDefine::PREFECTURES[MasterDefine::MIYAGI],
                MasterDefine::FUKUSHIMA => MasterDefine::PREFECTURES[MasterDefine::FUKUSHIMA]
            ]
        ],
        MasterDefine::KANTO_AREA => [
            'name' => 'kanto',
            'display_name' => '関東',
            'prefectures' => [
                MasterDefine::IBARAKI => MasterDefine::PREFECTURES[MasterDefine::IBARAKI],
                MasterDefine::TOCHIGI => MasterDefine::PREFECTURES[MasterDefine::TOCHIGI],
                MasterDefine::GUNMA => MasterDefine::PREFECTURES[MasterDefine::GUNMA],
                MasterDefine::SAITAMA => MasterDefine::PREFECTURES[MasterDefine::SAITAMA],
                MasterDefine::CHIBA => MasterDefine::PREFECTURES[MasterDefine::CHIBA],
                MasterDefine::TOKYO => MasterDefine::PREFECTURES[MasterDefine::TOKYO],
                MasterDefine::KANAGAWA => MasterDefine::PREFECTURES[MasterDefine::KANAGAWA],
            ],
        ],
        MasterDefine::CHUBU_AREA => [
            'name' => 'chubu',
            'display_name' => '中部',
            'prefectures' => [
                MasterDefine::NIIGATA => MasterDefine::PREFECTURES[MasterDefine::NIIGATA],
                MasterDefine::TOYAMA => MasterDefine::PREFECTURES[MasterDefine::TOYAMA],
                MasterDefine::ISHIKAWA => MasterDefine::PREFECTURES[MasterDefine::ISHIKAWA],
                MasterDefine::FUKUI => MasterDefine::PREFECTURES[MasterDefine::FUKUI],
                MasterDefine::YAMANASHI => MasterDefine::PREFECTURES[MasterDefine::YAMANASHI],
                MasterDefine::NAGANO => MasterDefine::PREFECTURES[MasterDefine::NAGANO],
                MasterDefine::GIFU => MasterDefine::PREFECTURES[MasterDefine::GIFU],
                MasterDefine::SHIZUOKA => MasterDefine::PREFECTURES[MasterDefine::SHIZUOKA],
                MasterDefine::AICHI => MasterDefine::PREFECTURES[MasterDefine::AICHI],
            ]
        ],
        MasterDefine::KINKI_AREA => [
            'name' => 'kinki',
            'display_name' => '近畿',
            'prefectures' => [
                MasterDefine::MIE => MasterDefine::PREFECTURES[MasterDefine::MIE],
                MasterDefine::SHIGA => MasterDefine::PREFECTURES[MasterDefine::SHIGA],
                MasterDefine::KYOTO => MasterDefine::PREFECTURES[MasterDefine::KYOTO],
                MasterDefine::OSAKA => MasterDefine::PREFECTURES[MasterDefine::OSAKA],
                MasterDefine::HYOUGO => MasterDefine::PREFECTURES[MasterDefine::HYOUGO],
                MasterDefine::NARA => MasterDefine::PREFECTURES[MasterDefine::NARA],
                MasterDefine::WAKAYAMA => MasterDefine::PREFECTURES[MasterDefine::WAKAYAMA],

            ]
        ],
        MasterDefine::CHUGOKU_AREA => [
            'name' => 'chugoku',
            'display_name' => '中国',
            'prefectures' => [
                MasterDefine::TOTTORI => MasterDefine::PREFECTURES[MasterDefine::TOTTORI],
                MasterDefine::SHIMANE => MasterDefine::PREFECTURES[MasterDefine::SHIMANE],
                MasterDefine::OKAYAMA => MasterDefine::PREFECTURES[MasterDefine::OKAYAMA],
                MasterDefine::HIROSHIMA => MasterDefine::PREFECTURES[MasterDefine::HIROSHIMA],
                MasterDefine::YAMAGUCHI => MasterDefine::PREFECTURES[MasterDefine::YAMAGUCHI],
            ]
        ],
        MasterDefine::SHIKOKU_AREA => [
            'name' => 'shikoku',
            'display_name' => '四国',
            'prefectures' => [
                MasterDefine::TOKUSHIMA => MasterDefine::PREFECTURES[MasterDefine::TOKUSHIMA],
                MasterDefine::KAGAWA => MasterDefine::PREFECTURES[MasterDefine::KAGAWA],
                MasterDefine::EHIME => MasterDefine::PREFECTURES[MasterDefine::EHIME],
                MasterDefine::KOUCHI => MasterDefine::PREFECTURES[MasterDefine::KOUCHI],
            ]
        ],
        MasterDefine::KYUSHU_AREA => [
            'name' => 'kyushu',
            'display_name' => '九州',
            'prefectures' => [
                MasterDefine::FUKUOKA => MasterDefine::PREFECTURES[MasterDefine::FUKUOKA],
                MasterDefine::SAGA => MasterDefine::PREFECTURES[MasterDefine::SAGA],
                MasterDefine::NAGASAKI => MasterDefine::PREFECTURES[MasterDefine::NAGASAKI],

                MasterDefine::KUMAMOTO => MasterDefine::PREFECTURES[MasterDefine::KUMAMOTO],
                MasterDefine::OITA => MasterDefine::PREFECTURES[MasterDefine::OITA],
                MasterDefine::MIYAZAKI => MasterDefine::PREFECTURES[MasterDefine::MIYAZAKI],
                MasterDefine::KAGOSHIMA => MasterDefine::PREFECTURES[MasterDefine::KAGOSHIMA],
                MasterDefine::OKINAWA => MasterDefine::PREFECTURES[MasterDefine::OKINAWA],

            ],
        ]

    ];

    //日本酒度
    const SAKE_DEGREE = '日本酒度';

    //日本酒度
    const SAKE_DEGREE_0 = 0;
    const SAKE_DEGREE_1 = 1;
    const SAKE_DEGREE_2 = 2;
    const SAKE_DEGREE_3 = 3;
    const SAKE_DEGREE_4 = 4;
    const SAKE_DEGREE_5 = 5;
    const SAKE_DEGREE_6 = 6;
    const SAKE_DEGREE_7 = 7;
    const SAKE_DEGREE_8 = 8;
    const SAKE_DEGREE_9 = 9;
    const SAKE_DEGREE_10 = 10;
    const SAKE_DEGREE_11 = 11;

    const SAKE_DEGREES  = [
        MasterDefine::SAKE_DEGREE_0 => '-26~-30',
        MasterDefine::SAKE_DEGREE_1 => '-21~-25',
        MasterDefine::SAKE_DEGREE_2 => '-16~-20',
        MasterDefine::SAKE_DEGREE_3 => '-11~-15',
        MasterDefine::SAKE_DEGREE_4 => '-6~-10',
        MasterDefine::SAKE_DEGREE_5 => '-1~-5',

        MasterDefine::SAKE_DEGREE_6 => '0~5',
        MasterDefine::SAKE_DEGREE_7 => '6~10',
        MasterDefine::SAKE_DEGREE_8 => '11~15',
        MasterDefine::SAKE_DEGREE_9 => '16~20',
        MasterDefine::SAKE_DEGREE_10 => '21~25',
        MasterDefine::SAKE_DEGREE_11 => '26~30',

    ];

    //アミノ酸度
    const AMINO_ACID_DEGREE = 'アミノ酸度';

    const AMINO_ACID_DEGREE_0 = 0;
    const AMINO_ACID_DEGREE_1 = 1;
    const AMINO_ACID_DEGREE_2 = 2;
    const AMINO_ACID_DEGREE_3 = 3;
    const AMINO_ACID_DEGREE_4 = 4;
    const AMINO_ACID_DEGREE_5 = 5;

    const AMINO_ACID_DEGREES = [
        MasterDefine::AMINO_ACID_DEGREE_0 => '0~0.5',
        MasterDefine::AMINO_ACID_DEGREE_1 => '0.6~1.0',
        MasterDefine::AMINO_ACID_DEGREE_2 => '1.1~1.5',
        MasterDefine::AMINO_ACID_DEGREE_3 => '1.6~2.0',
        MasterDefine::AMINO_ACID_DEGREE_4 => '2.1~2.5',
        MasterDefine::AMINO_ACID_DEGREE_5 => '2.6~3.0',
    ];

    //個人評価項目
    const SWEETNESS = '甘さ';
    const ACIDITY = '酸味';
    const RICHNESS = '味の濃さ';
    const COST_PERFORMANCE = 'コストパフォーマンス';
    const RECOMMEND_POINT = 'おすすめ度';

}

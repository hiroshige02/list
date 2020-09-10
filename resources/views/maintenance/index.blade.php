<div id="app">
<v-app>
<v-main>

@extends('layouts.maintenance')

@section('contents')


<v-container>
    
        <v-row>
            <v-col cols=12>
                <!-- <a href="#" class="link">
                    新規登録
                </a> -->
                <button-event
                    button-text="新規登録"
                    button-color="pink"
                    :is-large='true'
                    :height=50
                    font="large-button"
                >
                </button-event>

            </v-col>
        </v-row>
        <v-row no-gutters>
            <v-col cols=12 class="d-flex">
                <v-col cols="9">
                    {{--この割り方をなくせばpaddingというか隙間はなくなる --}}
                    <search-text></search-text>
                </v-col>
                <v-col cols=3>
                    <button-event
                    button-text="検索"
                    button-color="primary"
                    is-normal='false'
                    :is-large='true'
                    :height=56
                    font="large-button"
                    >
                    </button-event>
                </v-col>   
            
            </v-col>
                
            <v-col cols="12" v-if="{{ $searched }}">
                <ul>
                    <li><a>検索結果1</a></li>
                    <li><a>検索結果2</a></li>
                    <li><a>検索結果3</a></li>
                </ul>
            </v-col>
            <v-col class="text-center">
                <a href="#" class="link">
                    もっと見る
                </a>
            </v-col>

        </v-row>

        {{-- メーカーの評価 --}}
        <v-row class="no-gutters pt-8">
            <v-col cols=12 justify="center">
                <v-col class="text-center">
                    <h2 class="center">メーカーの評価から探す</h2>
                </v-col>
                <v-col class="d-flex">
                    @foreach($maker_selections as $label => $items)
                        <v-col cols=6>
                            <pulldown-event
                            label="{{ $label }}"
                            :items='@json($items)'
                            ></v-select>
                        </v-col>
                    @endforeach
                </v-col>
            </v-col>
        </v-row>

        {{-- 個人の評価 --}}
        <v-row class="pt-8">
            <v-col cols=12 justify="center">
                <h2 class="center">個人の評価から探す</h2>
            </v-col>
            @foreach($personal_selections as $item)
                <v-col cols=12 class="d-flex no-gutters">
                    <v-col cols=6>
                        <pulldown-event
                        label="{{ $item['class_name'] }}"
                        :items='@json($item["classes"])'
                        ></v-select>
                    </v-col>
                    <v-col cols=6>
                        <pulldown-event
                        label="{{ $item['selection_name'] }}"
                        :items='@json($item["selections"])'
                        ></v-select>
                    </v-col>
                </v-col>
            @endforeach      
        </v-row>



        <v-row>

            <v-col cols=12 justify="center" class="no-gutters pt-8">
                <h2 class="center">エリアから探す</h2>
            </v-col>

            <v-col cols=12 class="no-gutters">
                @foreach($areas as $areas => $area)
                    <ul>
                        {{-- 将来的には@foreachで書いた方がいい --}}
                        <li id="{{ $area['name'] }}" onclick="displayToggle(this.id)">
                            {{ $area['display_name'] }}
                            <ul id="{{ $area['name'] }}_prefectures" class="hide">
                                @foreach($area['prefectures'] as $p)
                                    {{-- /maintenance/sake/area/1 みたいなアドレス --}}
                                    <li>
                                        <a href="maintenance/sake/area/1" class="link">{{ $p }}</a>
                                    </li>
                                @endforeach
                            </ul>
                    
                        </li>
                    </ul>
                @endforeach
            </v-col>     
        </v-row>


    

</v-main>
</v-app>
</div>



@endsection
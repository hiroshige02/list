@extends('layouts.app')

@section('contents')

<div id="app">
    <v-app>
        <v-main>

            <v-container>
                <v-row justify="center">
                        <!-- 編集ボタン -->
                        <!-- <div class="text-center"> -->
                    <v-col cols="12" class="text-center"> <!-- 中心寄せはこれを反映 -->
                        <button-event
                            button-text="編集"
                            button-color="pink"
                            :is-large="true"
                            width="150"
                            font="large-button"
                        >
                        </button-event>
                    </v-col>
                </v-row>

                <v-row no-gutters>
                <!-- foreachスタート -->
                    <v-col cols="12" class="d-flex">
                        <v-col cols="3">
                            <p>地域</p>
                        </v-col>
                        <v-col cols="9">
                            <p>どこか知らない場所・・ながくしたらどうなるのんおおおおおおお</p>
                        </v-col>
                    </v-col>
                    <!-- foreach終わり -->

                    <v-col cols="12" class="d-flex">
                        <v-col cols="3">
                            <p>蔵名</p>
                        </v-col>
                        <v-col cols="9">
                            <p>小沢酒造</p>
                        </v-col>
                    </v-col>
                    
                </v-row>

                <v-row justify="center" no-gutters>
                    <v-col cols="12">

                        <!-- カルーセル -->
                        <carousel-list
                            :per-page="{{ $set_per_page }}"                        >
                        </carousel-list>
                        
                    </v-col>
                </v-row>

                {{-- グラフ表示 --}}
                <v-row justify="center">
                </v-row>

                {{-- グラフ表示 --}}
                <v-row no-gutters>
                    <v-col cols="12" class="d-flex">
                        <v-col cols="3">
                            <p>コメント</p>
                        </v-col>
                        <v-col cols="9">
                            <p>どこか知らない場所・・ながくしたらどうなるのんおおおおおおお</p>
                        </v-col>
                    </v-col>
                </v-row>
                
                <v-row justify="center">
                    <a href="#" class="link">
                        <p>戻る</p>
                    </a>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</div>


   <!-- カルーセルスライダー導入 -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-carousel@0.18.0/dist/vue-carousel.min.js"></script> -->
    
@endsection
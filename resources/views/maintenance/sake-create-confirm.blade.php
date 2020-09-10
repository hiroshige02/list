@extends('layouts.app')

@section('contents')
<div id="app">
    <v-app>
        <v-main>

            <v-container>
                <v-row justify="center" no-gutters>
                    <v-col cols=12 class="d-flex">
                        <v-col cols=3>
                            <p>酒名</p>
                        
                        <!-- <label-text text-title='酒名'></label-text>
                        <label-text text-title='酒名(全角カタカナ)'></label-text>
                        <label-text text-title='地域'></label-text>
                        <label-text text-title='蔵'></label-text>
                        <label-text text-title='項目１'></label-text>
                        <label-text text-title='項目２'></label-text> -->
                        <!-- <label-text text-title='項目３'></label-text> -->
                        </v-col>
                        <v-col cols=9>
                            <p>酒名ですよ</p>
                        </v-col>
                    </v-col>
                    <v-col cols=12 class="d-flex">
                        <v-col cols=3>
                            <p>酒名(全角カタカナ)</p>
                        </v-col>
                        <v-col cols=9>
                            <p>酒名(全角カタカナ)ですよ</p>
                        </v-col>                        
                    </v-col>
                    <v-col cols=12 class="d-flex">
                        <v-col cols=3>
                            <p>地域</p>
                        </v-col>
                        <v-col cols=9>
                            <p>東京とかの地域ですよ</p>
                        </v-col>                        
                    </v-col>
                    <v-col cols=12 class="d-flex">
                        <v-col cols=3>
                            <p>蔵</p>
                        </v-col>
                        <v-col cols=9>
                            <p>小澤酒造とかの蔵名ですよ</p>
                        </v-col>                        
                    </v-col>                    
                    <v-col cols=12 class="d-flex">
                        <v-col cols=3>
                            <p>項目１</p>
                        </v-col>
                        <v-col cols=9>
                            <p>50とか項目１の値ですよ</p>
                        </v-col>                        
                    </v-col>
                    <v-col cols=12 class="d-flex">
                        <v-col cols=3>
                            <p>項目２</p>
                        </v-col>
                        <v-col cols=9>
                            <p>４とか項目２の値ですよ</p>
                        </v-col>                        
                    </v-col>
                    <v-col cols=12 class="d-flex">
                        <v-col cols=3>
                            <p>項目３</p>
                        </v-col>
                        <v-col cols=9>
                            <p>０とか項目３の値ですよ</p>
                        </v-col>                        
                    </v-col>
                    <v-col cols=12 class="d-flex">
                        <v-col cols=3>
                            <p>画像登録</p>
                        </v-col>
                        <v-col cols=9>
                            {{-- <img class="logo" src="{{ asset('img/jazz.png') }}"> --}}
                            <img class="register-image" src="/public/img/jazz.png" alt="logo" class="register-image">
                            <img class="register-image" src="/public/img/hiyoko.jpg" alt="logo" class="register-image">
                        </v-col>       
                </v-row>
                
                <!-- ボタン/戻る エリア -->
                <v-row  justify="center">
                    <v-col cols="12" class="text-center">
                        <button-event
                            button-text='登録確認'
                            button-color="pink"
                            :is-normal='true'
                            height="56px"
                            width="150px"
                            font="large-button"
                        >
                        </button-event>
                        <v-col class="text-center">
                            <a href="#" class="link">
                                戻る
                            </a>
                        </v-col>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</div>


@endsection
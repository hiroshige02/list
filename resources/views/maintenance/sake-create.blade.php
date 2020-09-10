@extends('layouts.app')

@section('contents')
<div id="app">
    <v-app>
        <v-main>

            <v-container>
                <v-row justify="center" no-gutters>
                    <v-col cols="12">
                        <label-text text-title='酒名'></label-text>
                        <label-text text-title='酒名(全角カタカナ)'></label-text>
                        <label-text text-title='地域'></label-text>
                        <label-text text-title='蔵'></label-text>
                        <label-text text-title='項目１'></label-text>
                        <label-text text-title='項目２'></label-text>
                        <label-text text-title='項目３'></label-text>
                    </v-col>
                </v-row>
                
                <v-row no-gutters>
                    <p class="label-text">画像登録</p>
                    <file-input-component
                        name="file_1"
                        button-text="-"
                        :files="['public/img/hiyoko.jpg']"
                        font="normal-button"
                    >
                    </file-input>
                </v-row>


                <v-row>
                    <v-col cols="12">
                        
                        <label-text-area
                            color="pink"
                            name="コメント"
                            value=""
                            placeholder="コメントを入力してください"
                        >
                        </label-text-area>
                        
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
                            font="normal-button"
                            event-name="something"
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
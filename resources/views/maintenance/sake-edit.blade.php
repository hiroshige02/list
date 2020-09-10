@extends('layouts.app')

@section('contents')
<div id="app">
    <v-app>
        <v-main>

            <v-container>
                <v-row justify="center" no-gutters>
                    <v-col cols="12">
                        <label-text text-title='酒名' exist-value='酒名ですよ'></label-text>
                        <label-text text-title='酒名(全角カタカナ)' exist-value='酒名カタカナですよ'></label-text>
                        <label-text text-title='地域' exist-value='地域ですよ'></label-text>
                        <label-text text-title='蔵' exist-value='蔵ですよ'></label-text>
                        <label-text text-title='項目１' exist-value='項目１ですよ'></label-text>
                        <label-text text-title='項目２' exist-value='項目２ですよ'></label-text>
                        <label-text text-title='項目３' exist-value='項目３ですよ'></label-text>
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
                            value="コメントですよ"
                            placeholder="コメントを入力してください"
                        >
                        </label-text-area>
                        
                    </v-col>
                </v-row>
                
                <!-- ボタン/戻る エリア -->
                <v-row>
                    <v-col cols=12 class="d-flex">
                        <v-col cols=6>
                            <button-event
                                button-text='削除'
                                button-color="pink"
                                :is-large='true'
                                height="56px"
                                width="150px"
                                font="large-button"
                            >
                            </button-event>
                        </v-col>
                        <v-col cols="6">
                            <button-event
                                button-text='変更確認'
                                button-color="pink"
                                :is-large='true'
                                height="56px"
                                width="150px"
                                font="large-button"
                            >
                            </button-event>
                        </v-col>
                    </v-col>
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
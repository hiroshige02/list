@extends('layouts.app')

@section('contents')
<div id="app">
    <v-app>
        <v-main>

            <v-container>
                <v-row justify="center">

                    <v-col cols="12" class="text-center">
                        
                            <button-event
                                button-text='更新したお酒を見る'
                                button-color="pink"
                                :is-large='true'
                                height="56"
                                width="220"
                                font="large-button"
                            >
                            </button-event>
                    </v-col>
                    <v-col cols="12" class="text-center">
                            <button-event
                                button-text='管理画面に移動'
                                button-color="primary"
                                :is-large='true'
                                height="56"
                                width="220"
                                font="large-button"
                            >
                            </button-event>
                    </v-col>
                            <v-col cols="12" class="text-center">
                                <a href="#" class="link">
                                    <p>戻る</p>
                                </a>
                            </v-col>
                    </v-col>
                </v-row>

            </v-container>
        </v-main>
    </v-app>
</div>


@endsection
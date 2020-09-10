@extends('layouts.app')

@section('contents')

<?php //OK echo 'eeeee'; exit;?>
<div id="app">
<v-app>
<v-main>

    <v-container>
        
        <v-row justify="center">

        {{-- <form method="POST" action="{{ route('login') }}">
                @csrf --}}

                <v-col>
                    <label-text text-title='ユーザー名'></label-text>
                    <label-text text-title='パスワード'></label-text>
                    <v-col cols=12 class="text-center large-button">
                        <button-event
                            button-text='{{$title}}'
                            button-color="pink"
                            :is-large='true'
                            height="50px"
                            width="150px"
                            font="large-button"
                        >
                        </button-event>
                    </v-col>
                    <v-col class="text-center">
                        <a href="#" class="link">
                            戻る
                        </a>
                    </v-col>
                    

                </v-col>
                
            {{-- </form> --}}
        </v-row>

    </v-container>
    </v-main>
    </v-app>
</div>

@endsection
@extends('layouts.app')

@section('contents')

<div id="app">
    <v-app>
        <v-main>

            <v-container>
                <v-row dense>
                    {{-- コントローラーからjson配列を送る
                        @foreach($json_datas as $data) --}}
                        <list-index></list-index>
                    {{-- @endforeach --}}
                </v-row>
                <v-row justify="center">
                    <v-col cols=12>
                        <pagenate></pagenate>
                    </v-col>
                    <v-col cols=12 class="text-center">
                        <a href="#" class="link">
                            戻る
                        </a>
                    </v-col>
                </v-row>
            </v-container>
    </v-main>
    </v-app>
</div>
@endsection

<div id="app">
    <v-app>
        <v-main>

            @extends('layouts.app')
            @section('contents')

            <v-container>
                <v-row dense>
                    <v-col cols="12">
                        <list-index
                        datas='@json($datas)'>
                        </list-index>
                    </v-col>
                </v-row>
                <v-row justify="center">
                    <v-col cols=12>
                        <pagenation
                        total-pages="{{ $total_pages }}"
                        per-page=2
                        datas="{{ $datas }}"
                        ></pagenation>
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

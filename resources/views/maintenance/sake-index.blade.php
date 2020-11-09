
<div id="app">
    <v-app>
        <v-main>

            @extends('layouts.app')
            @section('contents')

            <v-container>
                <items-pagenate
                datas='@json($datas)'
                :total-pages="{{ $total_pages }}"
                per-page="{{ $per_page }}"
                :return-page="{{ $return_page }}"
                ></items-pagenate>
                <v-row justify="center">
                    <v-col cols=12 class="text-center">
                        <a href="/maintenance" class="link">
                            {{__('master.Back')}}
                        </a>
                    </v-col>
                </v-row>
            </v-container>
    </v-main>
    </v-app>
</div>
@endsection

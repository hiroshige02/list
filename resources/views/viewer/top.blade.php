<div id="app">
    <v-app>
        <v-main>

            @extends('layouts.app')
            @section('contents')

            <v-container>
                {{-- <v-row>
                    <v-col cols="12" align="center">
                        <textarea class="updated">2020/7/2  ○ ○ UP<br>2020/6/2  ○ ○ UP
                        </textarea>
                    </v-col>
                </v-row> --}}

                {{-- お酒の名前 --}}
                <v-row justify="center" class="pt-8">
                    <v-col cols="12" align="center">
                        <h2 class="center">{{__('master.SearchName')}}</h2>
                    </v-col>
                </v-row>
                <text-search
                name="name_search"
                search-text=""
                is-error=false
                error-messages=""
                maintenance="{{ $maintenance }}"
                >
                </text-search>

                {{-- メーカーの評価 --}}
                <v-row class="pt-8" justify="center">
                    <v-col cols="12" align="center">
                        <h2>{{__('master.SearchMakerEvaluation')}}</h2>
                    </v-col>
                    <coordinate-pulldown
                    :items='@json($maker_selections)'
                    maintenance="{{ $maintenance }}"
                    >
                    </coordinate-pulldown>
                </v-row>

                {{-- 個人の評価 --}}
                <v-row class="pt-8" justify="center">
                    <v-col cols=12 align="center">
                        <h2 class="center">{{__('master.SearchPersonalEvaluation')}}</h2>
                    </v-col>

                    <personal-search
                    personal-data='@json($personal_selections)'
                    maintenance="{{ $maintenance }}"
                    >
                    </personal-search>
                </v-row>

                {{-- エリアから探す --}}
                <v-row justify="center" class="pt-8">
                    <v-col cols=12 align="center">
                        <h2 class="center">{{__('master.SearchArea')}}</h2>
                    </v-col>

                    <v-col cols="3" class="d-flex"></v-col>

                    <v-col cols="9" class="no-gutters">
                        @foreach($areas as $areas => $area)
                            <ul>
                                <li id="{{ $area['name'] }}">
                                    <span id="{{ $area['name'] }}" class="area" onclick="displayToggle(this.id)">
                                        {{ $area['display_name'] }}
                                    </span>
                                    <ul id="{{ $area['name'] }}_prefectures" class="hide" onclick="event.stopPropagation()">
                                        @foreach($area['prefectures'] as $number => $p)
                                            <li>
                                                <a href="sake/prefecture/{{$number}}" class="link inner">{{ $p }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        @endforeach
                    </v-col>
                </v-row>

            </v-container>

        </v-main>
    </v-app>
</div>

@endsection


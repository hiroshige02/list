<div id="app">
    <v-app>
        <v-main>

            @extends('layouts.app')
            @section('contents')

            <v-container>
                <v-row justify="center">
                    <v-col cols="12">
                        <textarea class="updated">2020/7/2  ○ ○ UP<br>2020/6/2  ○ ○ UP
                        </textarea>
                    </v-col>
                </v-row>

                <v-row no-gutters>
                    <search-area
                    name="name_search"
                    search-text=""
                    is-error=false
                    error-messages=""
                    maintenance="{{ $maintenance }}"
                    >
                    </search-area>
                </v-row>

                {{-- メーカーの評価 --}}
                <v-row class="pt-8">
                    <v-col cols=12 align="center">
                        <h2 class="center">{{__('master.SearchMakerEvaluation')}}</h2>
                    </v-col>
                    <coordinate-pulldown
                    :items='@json($maker_selections)'
                    maintenance="{{ $maintenance }}"
                    >
                    </coordinate-pulldown>
                </v-row>

                {{-- 個人の評価 --}}
                <v-row class="pt-8">
                    <v-col cols=12 align="center">
                        <h2 class="center">{{__('master.SearchPersonalEvaluation')}}</h2>
                    </v-col>

                    <personal-search
                    personal-data='@json($personal_selections)'
                    maintenance="{{ $maintenance }}"
                    >
                    </personal-search>
                </v-row>

                <v-row>
                    <v-col cols=12 align="center" class="no-gutters pt-8">
                        <h2 class="center">{{__('master.SearchArea')}}</h2>
                    </v-col>

                    <v-col cols=12 class="no-gutters">
                        @foreach($areas as $areas => $area)
                            <ul>
                                <li id="{{ $area['name'] }}" onclick="displayToggle(this.id)">
                                    {{ $area['display_name'] }}
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


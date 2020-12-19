<div id="app">
    <v-app>
        <v-main>

            @extends('layouts.maintenance')
            @section('contents')

            <v-container>
                <v-row justify="center no-gutters">
                    <v-col cols="8">
                        <a href="/maintenance/sake/create" style="display:inline-block;">
                            <button-event
                            button-text="{{__('master.Register')}}"
                            button-color="pink"
                            :is-large='true'
                            :height=50
                            font="large-button">
                            </button-event>
                        </a>
                    </v-col>
                </v-row>

                {{-- お酒の名前 --}}
                <v-row no-gutters justify="center" class="pt-8">
                    <v-col cols=12 align="center">
                        <h2 class="center">{{__('master.SearchName')}}</h2>
                    </v-col>

                    <text-search
                    name="name_search"
                    search-text=""
                    :is-error="false"
                    error-messages=""
                    :maintenance="true"
                    >
                    </text-search>
                </v-row>

                {{-- メーカーの評価 --}}
                <v-row class="pt-8" justify="center">
                    <v-col cols="12" align="center">
                        <h2>{{__('master.SearchMakerEvaluation')}}</h2>
                    </v-col>
                    <v-col cols="12" justify="center">
                        <coordinate-pulldown
                        :items='@json($maker_selections)'
                        :maintenance="true"
                        >
                        </coordinate-pulldown>
                    </v-col>
                </v-row>

                {{-- 個人の評価 --}}
                <v-row class="pt-8" justify="center">
                    <v-col cols=12 align="center">
                        <h2 class="center">{{__('master.SearchPersonalEvaluation')}}</h2>
                    </v-col>

                    <personal-search
                    personal-data='@json($personal_selections)'
                    :maintenance="true"
                    >
                    </personal-search>
                </v-row>

                {{-- エリアから探す --}}
                <v-row justify="center" class="pt-8">
                    <v-col cols=12 align="center" class="no-gutters">
                        <h2 class="center">{{__('master.SearchArea')}}</h2>
                    </v-col>

                    <v-col cols="3" class="d-flex"></v-col>

                    <v-col cols="9" class="no-gutters">
                        @foreach($areas as $areas => $area)
                            <ul>
                                <li>
                                    <span id="{{ $area['name'] }}" class="area" onclick="displayToggle(this.id)">
                                        {{ $area['display_name'] }}
                                    </span>
                                    <ul id="{{ $area['name'] }}_prefectures" class="hide" onclick="event.stopPropagation()">
                                        @foreach($area['prefectures'] as $number => $p)
                                            <li>
                                                <a href="sake/prefecture/{{$number}}">{{ $p }}</a>
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

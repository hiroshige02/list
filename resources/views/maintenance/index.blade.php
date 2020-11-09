<div id="app">
<v-app>
<v-main>

@extends('layouts.maintenance')

@section('contents')


<v-container>

    <form id="" method="POST" action="/maintenance/">
        @csrf

        <v-row>
            <v-col cols=12>
                <a href="/maintenance/sake/create">
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
        <v-row no-gutters>
            <v-col cols=12 class="d-flex">
                <v-col cols="9">
                    {{--この割り方をなくせばpaddingというか隙間はなくなる --}}
                    <search-text></search-text>
                </v-col>
                <v-col cols=3>
                    <button-event
                    button-text="{{__('master.Search')}}"
                    button-color="primary"
                    is-normal='false'
                    :is-large='true'
                    :height=56
                    font="large-button"
                    >
                    </button-event>
                </v-col>

            </v-col>

            <v-col cols="12" v-if="{{ $searched }}">
                <ul>
                    <li><a>検索結果1</a></li>
                    <li><a>検索結果2</a></li>
                    <li><a>検索結果3</a></li>
                </ul>
            </v-col>
            <v-col class="text-center">
                <a href="#" class="link">
                    {{__('master.More')}}
                </a>
            </v-col>

        </v-row>

        {{-- メーカーの評価 --}}
        <v-row class="pt-8">
            <v-col cols=12 justify="center">
                <h2 class="center">{{__('master.SearchMakerEvaluation')}}</h2>
                    <coordinate-pulldown
                    :items='@json($maker_selections)'
                    >
                    </coordinate-pulldown>

            </v-col>
        </v-row>

        {{-- 個人の評価 --}}
        <v-row class="pt-8">
            <v-col cols=12 justify="center">
                <h2 class="center">{{__('master.SearchPersonalEvaluation')}}</h2>
            </v-col>
            @foreach($personal_selections as $column => $option)
                <v-col cols=12 class="d-flex no-gutters">
                    <v-col cols=6>
                        <span>{{ $option['label'] }}</span>
                    </v-col>
                    <v-col cols=6>
                        <pulldown-event
                        :item-array='@json($option["selections"])'
                        class-postname="{{$column}}"
                        ></pulldown-event>
                    </v-col>
                </v-col>
            @endforeach
        </v-row>

        <v-row>

            <v-col cols=12 justify="center" class="no-gutters pt-8">
                <h2 class="center">{{__('master.SearchArea')}}</h2>
            </v-col>

            <v-col cols=12 class="no-gutters">
                @foreach($areas as $areas => $area)
                    <ul>
                        {{-- 将来的には@foreachで書いた方がいい --}}
                        <li id="{{ $area['name'] }}" onclick="displayToggle(this.id)">
                            {{ $area['display_name'] }}
                            <ul id="{{ $area['name'] }}_prefectures" class="hide">
                                @foreach($area['prefectures'] as $number => $p)
                                    {{-- /maintenance/sake/area/1 みたいなアドレス --}}
                                    <li>
                                        <a href="maintenance/sake/prefecture/{{$number}}" class="link">{{ $p }}</a>
                                    </li>
                                @endforeach
                            </ul>

                        </li>
                    </ul>
                @endforeach
            </v-col>
        </v-row>

        <button type="submit">{{__('master.Submit')}}</button>
    </form>
</v-container>

</v-main>
</v-app>
</div>

@endsection

@extends('layouts.app')
@section('contents')

<v-container>
    <v-row>
        @foreach($datas as $column => $data)
            <v-col cols="12" class="d-flex no-gutters">
                <v-col cols="3">
                    <p>{{ $data['label'] }}</p>
                </v-col>
                <v-col cols="9">
                    <p>{{ $data['value'] }}</p>
                </v-col>
            </v-col>
        @endforeach
    </v-row>

    @if(!empty($images))
        <v-row justify="center" no-gutters>
            <v-col cols="12" class="d-flex no-gutters">
                <v-col cols="3">
                    <p>{{__('master.Picture')}}</p>
                </v-col>
                <!-- カルーセル -->
                <carousel-list
                :per-page="{{ $set_per_page }}"
                :images='@json($images)'>
                </carousel-list>
            </v-col>
        </v-row>
    @endif

    {{-- グラフ表示 --}}
    <v-row justify="center" no-gutters>
        <v-col cols="12" sm="9">
            <radar-chart
            :rader-data='@json($rader_data)'
            sake-name="{{ $datas['name']['value'] }}">
            </radar-chart>
        </v-col>
    </v-row>

</v-container>

@endsection

<div id="app">
    <v-app>
        <v-main>

        @extends('layouts.app')
        @section('contents')

            <v-container>
                <v-row justify="center">

                    <!-- 編集ボタン -->
                    <v-col cols="12" class="text-center">
                        <a href="/maintenance/sake/{{ $sake_id }}/edit">
                            <button-event
                            button-text="{{__('master.Edit')}}"
                            button-color="pink"
                            :is-large="true"
                            width="150"
                            font="large-button"
                            >
                            </button-event>
                        </a>
                    </v-col>

                </v-row>

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
                        <v-col cols="12">
                            <!-- カルーセル -->
                            <carousel-list
                            :per-page="{{ $set_per_page }}"
                            :images='@json($images)'>
                            </carousel-list>
                        </v-col>
                    </v-row>
                @endif

                {{-- グラフ表示 --}}
                <v-row justify="center">
                    <v-col cols=12>
                        <radar-chart
                        :rader-data='@json($rader_data)'
                        sake-name="{{ $datas['name']['value'] }}">
                        </radar-chart>
                    </v-col>
                </v-row>


                <v-row justify="center">
                    @if(!empty($back_to))
                        <a href="{{ $back_to }}" class="link">
                    @else
                        <a href="/maintenance" class="link">
                    @endif
                            <p> {{__('master.Back')}}</p>
                        </a>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</div>



@endsection

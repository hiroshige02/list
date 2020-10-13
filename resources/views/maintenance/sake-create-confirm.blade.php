<div id="app">
    <v-app>
        <v-main>

            @extends('layouts.maintenance')

            @section('contents')

            <v-container>

                <form method="post" action="/maintenance/sake/createcomplete">
                    @csrf

                <v-row justify="center" no-gutters>
                    @foreach($datas as $column => $data)
                        <v-col cols=12 class="d-flex">
                            <v-col cols=3>
                                <p>{{$data['label']}}</p>
                            </v-col>
                            <v-col cols=9>
                                <label>{{$data['value']}}</label>
                            </v-col>
                        <input type="hidden" name="{{$column}}" value="{{$data['value']}}">
                        </v-col>
                    @endforeach

                    <v-col cols=12 class="d-flex">
                        <v-col cols=3>
                            <p>画像登録</p>
                        </v-col>
                        <v-spacer></v-spacer>
                    </v-col>
                    @foreach($files as $file)
                        <v-col cols=12 class="d-flex">
                            <v-spacer></v-spacer>
                            <v-col cols=9>
                                <label>{{$file}}</label>
                            </v-col>
                        </v-col>
                    @endforeach

                </v-row>


                <!-- ボタン/戻る エリア -->
                <v-row  justify="center">
                    <v-col cols="12" class="text-center">
                        <button-event
                        type="submit"
                        button-text='登録確認'
                        button-color="pink"
                        :is-normal='true'
                        height="56px"
                        width="150px"
                        font="large-button"
                        >
                        </button-event>
                        <button type="submit" name="back">戻る</button>

                    </v-col>
                </v-row>

            </form>
            </v-container>
        </v-main>
    </v-app>
</div>


@endsection

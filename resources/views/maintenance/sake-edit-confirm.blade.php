<div id="app">
    <v-app>
        <v-main>

            @extends('layouts.app')
            @section('contents')

            <v-container>

            <form method="post" action="/maintenance/sake/{{$sake_id}}">
                @csrf
                @method('PUT')

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
                </v-row>

                <v-row>

                    <v-col cols=12 class="d-flex">
                        <v-col cols=3>
                            <p>画像登録</p>
                        </v-col>
                        <v-spacer></v-spacer>
                    </v-col>

                    @if(!empty($exist_images))
                        <v-col cols=12 class="d-flex">
                            <v-col cols=4>
                                <p>登録済画像</p>
                            </v-col>
                            <v-spacer></v-spacer>
                        </v-col>
                        @foreach($exist_images as $image)
                            <v-col cols="12">
                                <modal-link
                                file='@json($image)'
                                user-id = "{{ $user_id }}"
                                >
                                </modal-link>
                            </v-col>
                        @endforeach
                    @endif

                    @foreach($delete_image_ids as $d_id)
                        <input type="hidden" name="delete_image_ids[]" value="{{$d_id}}">
                    @endforeach


                    @if(!empty($new_images))
                        <v-col cols=12 class="d-flex">
                            <v-col cols=4>
                                <p>新規登録画像</p>
                            </v-col>
                            <v-spacer></v-spacer>
                        </v-col>

                        @foreach($new_images as $image)
                            <v-col cols="12">
                                <modal-link
                                file='@json($image)'
                                user-id = "{{ $user_id }}"
                                >
                                </modal-link>
                            </v-col>
                        @endforeach
                    @endif
            </v-row>

                <!-- ボタン/戻る エリア -->
                <v-row  justify="center">
                    <v-col cols="12" class="text-center">
                        <button-event
                        type="submit"
                        button-text='更新'
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

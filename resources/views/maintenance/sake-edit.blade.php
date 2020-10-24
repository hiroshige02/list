<div id="app">
    <v-app>
        <v-main>

            @extends('layouts.maintenance')
            @section('contents')

            <v-container>
                <form method="post" action="/maintenance/sake/{{$sake_id}}/editconfirm" enctype="multipart/form-data">
                    @csrf
                    {{-- 入力ボックス --}}
                    @foreach($sake_info as $name => $data)
                        @if(!empty($data['value']))
                            <label-text
                            text-title="{{ $data['label'] }}"
                            name="{{ $name }}"
                            value="{{ $data['value'] }}"
                            error-messages="{{ $errors->first($name) }}"
                            >
                            </label-text>
                        @else
                            <label-text
                            text-title="{{ $data['label'] }}"
                            name="{{ $name }}"
                            value="{{ old($name) }}"
                            error-messages="{{ $errors->first($name) }}"
                            >
                            </label-text>
                        @endif
                    @endforeach

                    <v-col cols=12 class="d-flex no-gutters">
                        <v-col cols=6>
                            <span>{{ $prefecture['label'] }}</span>
                        </v-col>
                        <v-col cols="6">
                            @if(!empty($prefecture['value']))
                                <pulldown-event
                                :item-array='@json($prefecture['selections'])'
                                name="{{ $prefecture['name'] }}"
                                :value='@json($prefecture['value'])'
                                error-message="{{ $errors->first($prefecture['name']) }}"
                                ></pulldown-event>
                            @else
                                <pulldown-event
                                :item-array='@json($prefecture["selections"])'
                                name="{{ $prefecture['name'] }}"
                                error-message="{{ $errors->first($prefecture['name']) }}"
                                ></pulldown-event>
                            @endif

                        </v-col>
                    </v-col>

                    {{-- プルダウン  --}}
                    <h4>個人評価</h4>
                    @foreach($tasts as $name => $data)
                        <v-col cols=12 class="d-flex no-gutters">
                            <v-col cols=6>
                                <span>{{ $data['label'] }}</span>
                            </v-col>
                            <v-col cols=6>
                                @if(!empty($data['value']))
                                    <pulldown-event
                                    :item-array='@json($data["selections"])'
                                    name="{{ $name }}"
                                    :value='@json($data['value'])'
                                    error-message="{{$errors->first($name)}}"
                                    ></pulldown-event>
                                @else
                                    <pulldown-event
                                    :item-array='@json($data["selections"])'
                                    name="{{ $name }}"
                                    ></pulldown-event>
                                @endif

                            </v-col>
                        </v-col>
                    @endforeach

                    <h4>メーカー評価</h4>

                    @foreach($evaluations as $column => $evaluation)
                    <?php //var_dump($evaluations);exit;?>
                        <v-col cols="12" class="d-flex no-gutters">
                            <v-col cols="6">
                                <span>{{ $evaluation['label'] }}</span>
                            </v-col>
                            <v-col cols="6">
                                @if(!empty($evaluation['value']))
                                    <?php //var_dump($evaluation['name']);exit;?>
                                    <pulldown-event
                                    :item-array='@json($evaluation["selections"])'
                                    name="{{ $column }}"
                                    :value='@json($evaluation['value'])'
                                    error-message="{{$errors->first($column)}}"
                                    ></pulldown-event>
                                @else
                                    <pulldown-event
                                    :item-array='@json($evaluation["selections"])'
                                    name="{{ $column }}"
                                    error-message="{{$errors->first($column)}}"
                                    ></pulldown-event>
                                @endif

                            </v-col>
                        </v-col>
                    @endforeach

                    {{-- コメント --}}
                    <v-row>
                        <v-col cols="12">
                            <?php //var_dump($sake_info['memo']['value']);exit;?>
                        @if(!empty($memo))
                            <label-text-area
                            color="pink"
                            label="コメント"
                            name="memo"
                            value="{{ $memo }}"
                            error-messages="{{ $errors->first('memo') }}"
                            placeholder="コメントを入力してください"
                            >
                            </label-text-area>

                        @else
                            <label-text-area
                            color="pink"
                            label="コメント"
                            name="memo"
                            error-messages="{{ $errors->first('memo') }}"
                            placeholder="コメントを入力してください"
                            >
                            </label-text-area>
                        @endif

                        </v-col>
                    </v-row>

                    <v-row>
                        <p class="label-text">画像</p>
                    </v-row>

                @if(!empty($image_datas))
                    <v-col cols=12 class="d-flex">
                        <v-col cols="4">
                            <p>登録済画像</p>
                        </v-col>
                        <v-spacer></v-spacer>
                    </v-col>

                    <v-row>
                        @foreach($image_datas as $image)
                            <modal-link
                            file='@json($image)'
                            user-id = "{{ $user_id }}"
                            >
                            </modal-link>
                        @endforeach
                    </v-row>
                @endif

                    @if(!empty($tentative_images))
                        <v-col cols=12 class="d-flex">
                            <v-col cols="4">
                                <p>新規登録画像</p>
                            </v-col>
                            <v-spacer></v-spacer>
                        </v-col>

                        @foreach($tentative_images as $image)
                            <modal-link
                            file='@json($image)'
                            user-id = "{{ $user_id }}"
                            >
                            </modal-link>
                        @endforeach
                    @endif

                    @if(!empty($delete_image_ids))
                        @foreach($delete_image_ids as $image_id)
                            <input type="hidden" name="redirect_delete_image_ids[]" value="{{ $image_id }}">
                        @endforeach
                    @endif

                    <v-row no-gutters>
                        <file-input-component
                        name="file[]"
                        button-text="-"
                        font="normal-button"
                        >
                        </file-input-component>
                    </v-row>

                    <!-- ボタン/戻る エリア -->
                    <v-row  justify="center">
                        <v-col cols="12" class="text-center">
                            <button-event
                            type="submit"
                            button-text='編集確認'
                            button-color="pink"
                            :is-normal='true'
                            height="56px"
                            width="150px"
                            font="normal-button"
                            event-name="create"
                            >
                            </button-event>

                            <input type="button" name="back" value="戻る">
                        </v-col>
                    </v-row>
                </form>
            </v-container>
        </v-main>
    </v-app>
@endsection

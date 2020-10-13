<div id="app">
    <v-app>
        <v-main>

@extends('layouts.maintenance')

@section('contents')


            <v-container>
                <form method="post" action="/maintenance/sake/createconfirm" enctype="multipart/form-data">
                    @csrf

                    {{-- 入力ボックス --}}
                    @foreach($sake_info as $name => $label)
                        <label-text
                        text-title="{{ $label }}"
                        name="{{ $name }}"
                        value="{{ old($name) }}"
                        error-messages="{{ $errors->first($name) }}"
                        >
                        </label-text>
                    @endforeach


                    {{-- 県だけ別になってるのがなんか気持ち悪いな --}}
                    <v-col cols=12 class="d-flex no-gutters">
                        <v-col cols=6>
                            <span>{{ $prefecture['label'] }}</span>
                        </v-col>
                        <v-col cols="6">
                            @if(!empty($prefecture['input_old']))
                            <?php //var_dump($prefecture['input_old']);exit;?>
                                <pulldown-event
                                :item-array='@json($prefecture['selections'])'
                                name="{{ $prefecture['name'] }}"
                                :value='@json($prefecture['input_old'])'
                                error-message="{{ $errors->first($prefecture['name']) }}"
                                ></pulldown-event>
                            @elseif(!empty($errors->first($prefecture['name'])))
                                <pulldown-event
                                :item-array='@json($prefecture['selections'])'
                                name="{{ $prefecture['name'] }}"
                                error-message="{{ $errors->first($prefecture['name']) }}"
                                ></pulldown-event>
                            @else
                                <pulldown-event
                                :item-array='@json($prefecture["selections"])'
                                name="{{ $prefecture['name'] }}"
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
                                {{-- @if(isset($data['input_old'] && !is_null['input_old']['value'])) --}}
                                @if(!empty($data['input_old']) && !is_null($data['input_old']['text']))

                                    <pulldown-event
                                    :item-array='@json($data["selections"])'
                                    name="{{ $name }}"
                                    :value='@json($data['input_old'])'
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

                    @foreach($evaluations as $evaluation)
                    <?php //var_dump($evaluations);exit;?>
                        <v-col cols="12" class="d-flex no-gutters">
                            <v-col cols="6">
                                <span>{{ $evaluation['label'] }}</span>
                            </v-col>
                            <v-col cols="6">
                                @if(!empty($evaluation['input_old']['value']))
                                <?php //var_dump($evaluation['name']);exit;?>
                                <pulldown-event
                                :item-array='@json($evaluation["selections"])'
                                name="{{ $evaluation['name'] }}"
                                :value='@json($evaluation['input_old'])'
                                ></pulldown-event>
                            @else
                                <pulldown-event
                                :item-array='@json($evaluation["selections"])'
                                name="{{ $evaluation['name'] }}"
                                ></pulldown-event>
                            @endif

                            </v-col>
                        </v-col>
                    @endforeach

                    {{-- コメント --}}
                    <v-row>
                        <v-col cols="12">

                            <label-text-area
                            color="pink"
                            label="コメント"
                            name="memo"
                            value="{{ old('memo') }}"
                            error-messages="{{ $errors->first('memo') }}"
                            placeholder="コメントを入力してください"
                            >
                            </label-text-area>

                        </v-col>
                    </v-row>

                    <v-row>
                        <p class="label-text">画像</p>
                    </v-row>
                    <?php //var_dump($input_images);exit;?>

                    @if(!empty($input_images))
                        <v-row>
                            {{-- 画像削除後に空隙ができてしまう --}}
                            @foreach($input_images as $image)
                                <v-col cols="12">
                                    <modal-link
                                    file="{{ $image }}"
                                    user-id="{{ $user_id }}"
                                    >
                                    </modal-link>
                                </v-col>
                            @endforeach
                        </v-row>
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
                        button-text='登録確認'
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

<div id="app">
    <v-app>
        <v-main>

@extends('layouts.maintenance')

@section('contents')


            <v-container>
                <form method="post" action="/maintenance/sake/createconfirm" enctype="multipart/form-data">
                    @csrf

                    {{-- 入力ボックス --}}
                    @foreach($sake_info as $name => $data)
                        <label-text
                        text-title="{{ $data['label'] }}"
                        name="{{ $name }}"
                        value="{{ old($name) }}"
                        error-messages="{{ $errors->first($name) }}"
                        >
                        </label-text>
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
                                {{-- @if(isset($data['input_old'] && !is_nzpsakeull['input_old']['value'])) --}}
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
                        <v-col cols="12" class="d-flex no-gutters">
                            <v-col cols="6">
                                <span>{{ $evaluation['label'] }}</span>
                            </v-col>
                            <v-col cols="6">
                                @if(!empty($evaluation['value']))
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

                    @error('file')
                        <p>{{ $message }}</p>
                    @enderror

                    @if(!empty($input_images))
                        <v-row>
                            @foreach($input_images as $image)
                                <modal-link
                                file='@json($image)'
                                user-id="{{ $user_id }}"
                                create-flag='true'
                                >
                                </modal-link>
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
                    </v-col>
                    <v-col cols=12 align="center">
                        <a href="/maintenance">
                            <p>戻る</p>
                        </a>
                    </v-col>
                </v-row>

            </form>
            </v-container>
        </v-main>
    </v-app>
@endsection

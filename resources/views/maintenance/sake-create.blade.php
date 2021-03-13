@extends('layouts.maintenance')
@section('contents')

<v-container>
    <form method="post" action="/maintenance/sake/createconfirm" enctype="multipart/form-data">
        @csrf

        {{-- 入力ボックス --}}
        @foreach($sake_info as $name => $data)
            <v-row no-gutters justify="center">
                <v-col cols="12" sm="9">
                    <label-text
                    text-title="{{ $data['label'] }}"
                    name="{{ $name }}"
                    value="{{ old($name) }}"
                    error-messages="{{ $errors->first($name) }}"
                    color="pink"
                    >
                    </label-text>
                </v-col>
            </v-row>
        @endforeach

        <v-row justify="center" d-flex no-gutters>
            <v-col cols="4" sm="3">
                <span>{{ $prefecture['label'] }}</span>
            </v-col>
            <v-col cols="6" sm="4">
                @if(!empty($prefecture['value']['text']))
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
        </v-row>

        {{-- 個人評価  --}}
        <h4>{{__('master.PersonalEvaluation')}}</h4>
        @foreach($tasts as $name => $data)
            <v-row justify="center" d-flex no-gutters>
                <v-col cols="4" sm="3">
                    <span>{{ $data['label'] }}</span>
                </v-col>
                <v-col cols="6" sm="4">
                    @if(isset($data['value']['text']))
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
                        error-message="{{$errors->first($name)}}"
                        ></pulldown-event>
                    @endif
                </v-col>
            </v-row>
        @endforeach

        {{-- メーカー評価  --}}
        <h4>{{__('master.MakerEvaluation')}}</h4>
        @foreach($evaluations as $column => $evaluation)
            <v-row justify="center" d-flex no-gutters>
                <v-col cols="4" sm="3">
                    <span>{{ $evaluation['label'] }}</span>
                </v-col>
                <v-col cols="6" sm="4">
                    @if(isset($evaluation['value']))
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
            </v-row>
        @endforeach

        {{-- コメント --}}
        <v-row justify="center">
            <v-col cols="12" sm="9">
                <p>コメント</p>
                <v-col cols="12" align="center">
                    <label-text-area
                    color="pink"
                    name="memo"
                    value="{{ old('memo') }}"
                    error-messages="{{ $errors->first('memo') }}"
                    placeholder="コメントを入力してください"
                    >
                    </label-text-area>
                </v-col>
            </v-col>
        </v-row>

        {{-- 画像 --}}
        <h4>{{__('master.Picture')}}</h4>

        {{-- エラー表示 --}}
        @error('file.*')
            @foreach($errors->get('file.*') as $messages)
                @foreach($messages as $message)
                    <p style="error-font">{{ $message }}</p>
                @endforeach
            @endforeach
        @enderror

        @if(!empty($input_images))
            @foreach($input_images as $image)
                <modal-link
                file='@json($image)'
                user-id="{{ $user_id }}"
                create-flag='true'
                >
                </modal-link>
            @endforeach
        @endif
        <v-row no-gutters>
            <file-input-component
            name="file[]"
            font="incre-del-button"
            >
            </file-input-component>
        </v-row>

        {{-- ボタン/戻る エリア --}}
        <v-row>
            <v-col cols="12" align="center">
                <button-event
                type="submit"
                button-text="{{__('master.RegisterConfirm')}}"
                button-color="pink"
                :is-normal='true'
                height="56px"
                width="150px"
                font="large-button"
                event-name="create"
                >
                </button-event>
            </v-col>
        </v-row>
    </form>
</v-container>

@endsection

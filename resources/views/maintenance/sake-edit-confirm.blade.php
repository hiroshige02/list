@extends('layouts.maintenance')
@section('contents')

<v-container>

    <form method="post" action="/maintenance/sake/{{$sake_id}}">
        @csrf
        @method('PUT')

        <v-row justify="center" no-gutters>
            @foreach($datas as $column => $data)
                <v-col cols=12 class="d-flex">
                    <v-col cols="4">
                        <p>{{$data['label']}}</p>
                    </v-col>
                    <v-col cols="8">
                        <label>{{$data['value']}}</label>
                    </v-col>
                <input type="hidden" name="{{$column}}" value="{{$data['value']}}">
                </v-col>
            @endforeach
        </v-row>

        {{-- 登録済み画像 --}}
        @if(!empty($exist_images))
            <v-col cols=12 class="no-gutters">
                <v-col cols=4>
                    <p>{{__('master.RegisteredPicture')}}</p>
                </v-col>
                <v-spacer></v-spacer>
            </v-col>

            @foreach($exist_images as $image)
                <v-row no-gutters>
                    <modal-link
                    file='@json($image)'
                    user-id = "{{ $user_id }}"
                    >
                    </modal-link>
                </v-row>
            @endforeach
        @endif

        @foreach($delete_image_ids as $d_id)
            <input type="hidden" name="delete_image_ids[]" value="{{$d_id}}">
        @endforeach

        {{-- 新規登録画像 --}}
        @if(!empty($new_images))
            <v-col cols=12 class="no-gutters">
                <v-col cols=4>
                    <p>{{__('master.NewPicture')}}</p>
                </v-col>
            </v-col>

            @foreach($new_images as $image)
                <v-row no-gutters>
                    <modal-link
                    file='@json($image)'
                    user-id = "{{ $user_id }}"
                    >
                    </modal-link>
                </v-row>
            @endforeach
        @endif

        {{-- 更新ボタン --}}
        <v-row  justify="center">
            <v-col cols="12" align="center">
                <button-event
                type="submit"
                button-text='{{__('master.Update')}}'
                button-color="pink"
                :is-normal='true'
                height="56px"
                width="150px"
                font="large-button"
                >
                </button-event>
                <input class="pt-6" type="submit" name="back" value="{{__('master.Back')}}">

            </v-col>
        </v-row>
    </form>

</v-container>

@endsection

@extends('layouts.maintenance')
@section('contents')

<v-container>
    <v-row justify="center">

        <v-col cols="12" align="center">
            <a href="/maintenance/sake/{{$sake_id}}">
                <button-event
                    button-text='登録したお酒を見る'
                    button-color="pink"
                    :is-large='true'
                    height="56"
                    width="220"
                    font="large-button"
                >
                </button-event>
            </a>
        </v-col>
        <v-col cols="12" align="center">
            <a href="/maintenance">
                <button-event
                button-text="{{__('master.ToMaintenance')}}"
                button-color="primary"
                :is-large='true'
                height="56"
                width="220"
                font="large-button"
                >
                </button-event>
            </a>
    </v-row>

</v-container>

@endsection

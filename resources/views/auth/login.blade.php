@extends('layouts.app')
@section('contents')

<v-container>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <v-row justify="center">
            <v-col cols="12" sm="8">
                <label-text
                text-title="{{__('master.Account')}}"
                name="email"
                value="{{ old('email') }}"
                error-messages="{{ $errors->first('email') }}"
                color="pink"
                >
                </label-text>
                <label-text
                text-title="{{__('master.Password')}}"
                type="password"
                name="password"
                value="{{ old('password') }}"
                error-messages="{{ $errors->first('password') }}"
                color="pink"
                >
                </label-text>

                <v-col cols="12" class="large-button" align="center">
                    <button-event
                    type="submit"
                    button-text='{{$title}}'
                    button-color="pink"
                    :is-large='true'
                    height="50px"
                    width="150px"
                    font="large-button"
                    event-name="login"
                    >
                    </button-event>
                </v-col>

            </v-col>
        </v-row>
    </form>

</v-container>

@endsection

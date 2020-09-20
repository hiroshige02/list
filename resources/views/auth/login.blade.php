@extends('layouts.app')

@section('contents')

<div id="app">
<v-app>
<v-main>

    <v-container>

        <form method="POST" action="{{ route('login') }}">
            @csrf

        <v-row justify="center">

            {{-- error-messages='{{ $errors->first('email') }}' --}}
                <v-col cols="12">
                    <label-text
                        text-title='アカウント'
                        name="email"
                        value="{{ old('email') }}"
                        error-messages="{{ $errors->first('email') }}"
                    >
                    </label-text>
                    <label-text
                        text-title='パスワード'
                        name="password"
                        value="{{ old('password') }}"
                        error-messages="{{ $errors->first('password') }}"
                    >
                    </label-text>

                    <v-col cols="12" class="text-center large-button">
                        <button-event
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
                    <v-col class="text-center">
                        <a href="#" class="link">
                            戻る
                        </a>
                    </v-col>


                </v-col>
            </v-row>
        </form>

    </v-container>
    </v-main>
    </v-app>
</div>

@endsection

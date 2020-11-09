@extends('layouts.app')

@section('contents')

<div id="app">
    <v-app>
        <v-main>

            <v-container>
                <v-row dense>
                        <list-index></list-index>
                </v-row>

                <v-row justify="center">
                    <v-col cols=12>
                        <pagenate></pagenate>
                    </v-col>
                    <v-col cols=12 class="text-center">
                        <a href="#" class="link">
                            {{__('master.Back')}}
                        </a>
                    </v-col>
                </v-row>

            </v-container>
    </v-main>
    </v-app>
</div>
@endsection

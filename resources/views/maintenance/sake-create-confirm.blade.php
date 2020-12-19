<div id="app">
    <v-app>
        <v-main>

            @extends('layouts.maintenance')
            @section('contents')

            <v-container>

                <form method="post" action="/maintenance/sake/createcomplete">
                    @csrf

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

                        <v-col cols=12 class="d-flex">
                            <v-col cols=3>
                                <p>{{__('master.Picture')}}</p>
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

                    </v-row>


                <!-- ボタン/戻る エリア -->
                <v-row  justify="center">
                    <v-col cols="12" align="center">
                        <button-event
                        type="submit"
                        button-text="{{__('master.Register')}}"
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
        </v-main>
    </v-app>
</div>


@endsection

<!DOCTYPE html>
<html lang="{{ config('app.locale','ja') }}">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache">

        <link rel="stylesheet" href="/public/css/app.css">
        <link rel="stylesheet" href="/public/css/make.css">
        {{-- icon導入のため --}}
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
</head>

<body>
    <div class="body-container">
        <v-app id="app">
            <v-main>
                <div class="title-container">
                    <v-row>

                        <v-col cols="12" class="d-flex no-gutters">
                            <v-col cols="6" class="" style="padding-left:100px">
                                    <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button-event
                                type="submit"
                                button-text="{{__('master.Logout')}}"
                                button-color="pink"
                                :is-small='true'
                                >
                                </button-event>
                                </form>
                            </v-col>
                            <v-col cols="5">
                                <a href="/maintenance" class="link-top">TOPヘ</a>
                            </v-col>
                        </v-col>

                    </v-row>

                    <h1>{{ $title }}</h1>
                </div>

                @yield('contents')

            </v-main>
        </v-app>

    </div>


    {{--
    <script src="{{ mix('/js/app.js') }}"></script>
    mix-manifest.json内のパスが/public/js/app.jsに変更できるまで不使用
        --}}
    <script src="/public/js/app.js"></script>

    {{-- vueではないjavascript --}}
    <script src="/public/js/maintenance.js"></script>
</body>
</html>




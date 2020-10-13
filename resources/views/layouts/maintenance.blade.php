<!DOCTYPE html>
<html lang="{{ config('app.locale','ja') }}">
<head>

    <meta charset="UTF-8">
    {{--
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
     mix-manifest.json内のパスが/public/css/app.cssに変更できるまで不使用
        --}}
        <link rel="stylesheet" href="/public/css/app.css">
        <link rel="stylesheet" href="/public/css/make.css">
        {{-- icon導入のため --}}
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>


</head>

<body>
        <div class="body-container">
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <div class="logout-button">
                    <button-event
                    type="submit"
                    button-text="ログアウト"
                    button-color="pink"
                    :is-small='true'
                    >
                    </button-event>
                </div>
            </form>
            <div class="title-container">
                <h1>{{ $title }}</h1>
            </div>
            @yield('contents')
        </div>
        {{--
        <script src="{{ mix('/js/app.js') }}"></script>
        mix-manifest.json内のパスが/public/js/app.jsに変更できるまで不使用
            --}}
        <script src="/public/js/app.js"></script>

        {{-- vueではないjavascript --}}
        <script src="/public/js/maintenance.js"></script>
</body>



